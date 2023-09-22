<?php if (wp_doing_ajax()) {
    add_action( 'wp_ajax_filter', 'products_filter' );
    add_action( 'wp_ajax_nopriv_filter', 'products_filter' );
    add_action( 'wp_ajax_hide_filters', 'hide_filters' );
    add_action( 'wp_ajax_nopriv_hide_filters', 'hide_filters' );
    add_action( 'wp_ajax_handle_cart_item', 'handle_cart_item' );
    add_action( 'wp_ajax_nopriv_handle_cart_item', 'handle_cart_item' );
    add_action( 'wp_ajax_change_qty', 'change_qty' );
    add_action( 'wp_ajax_nopriv_change_qty', 'change_qty' );
    add_action( 'wp_ajax_user_orders_sort', 'user_orders_sort' );
    add_action( 'wp_ajax_rev_q_tabs', 'rev_q_tabs' );
    add_action( 'wp_ajax_order_repeat', 'order_repeat' );
    add_action( 'wp_ajax_user_favorites', 'user_favorites' );
    add_action( 'wp_ajax_remove_user_favorites', 'remove_user_favorites' );
    add_action( 'wp_ajax_register_user', 'register_user' );
    add_action( 'wp_ajax_nopriv_register_user', 'register_user' );
    add_action( 'wp_ajax_check_email', 'check_email' );
    add_action( 'wp_ajax_nopriv_check_email', 'check_email' );
    add_action( 'wp_ajax_get_next_reviews', 'get_next_reviews' );
    add_action( 'wp_ajax_nopriv_get_next_reviews', 'get_next_reviews' );
    add_action( 'wp_ajax_new_comment', 'new_comment' );
    add_action( 'wp_ajax_change_password', 'change_password' );
    add_action( 'wp_ajax_db_city_search', 'db_city_search' );
    add_action( 'wp_ajax_nopriv_db_city_search', 'db_city_search' );
    add_action( 'wp_ajax_db_np_depart_search', 'db_np_depart_search' );
    add_action( 'wp_ajax_nopriv_db_np_depart_search', 'db_np_depart_search' );
    add_action( 'wp_ajax_coupon_check', 'coupon_check' );
    add_action( 'wp_ajax_nopriv_coupon_check', 'coupon_check' );
}

function fetch_data($posts_per_page) {
    $sort_args = [];
    if (isset($_GET['sort'])) {
        $orderby_value = wc_clean($_GET['sort']);
        $sort_args = match ($orderby_value) {
            'new' => [
                'orderby' => 'date',
                'order' => 'DESC',
            ],
            'price-asc' => [
                'orderby' => 'meta_value_num',
                'order' => 'ASC',
                'meta_key' => '_price',
            ],
            'price-desc' => [
                'orderby' => 'meta_value_num',
                'order' => 'DESC',
                'meta_key' => '_price',
            ],
            'rating' => [
                'orderby' => 'meta_value_num',
                'order' => 'DESC',
                'meta_key' => '_wc_average_rating',
            ],
            'price-disc' => [
                'orderby' => 'meta_value_num',
                'order' => 'DESC',
                'meta_key' => '_discount_value',
            ],
            default => [
                'orderby' => 'meta_value_num',
                'order' => 'DESC',
                'meta_key' => '_total_views_count',
            ],
        };
    }
    $price_args = [];
    if (isset($_GET['price'])) {
        $price_args = [
            'meta_query' => [
                [
                    'key' => '_price',
                    'value' => wc_clean(explode('-', $_GET['price'])),
                    'type' => 'numeric',
                    'compare' => 'BETWEEN'
                ]
            ]
        ];
    }
    $filter_args = [
        'tax_query' => [
            'relation' => 'AND',
        ]
    ];
    foreach (array_keys($_GET) as $key) {
        if (str_contains($key, 'pa_')) {
            $filter_args['tax_query'][] = [
                'taxonomy' => $key,
                'field' => 'slug',
                'terms' => explode(',', $_GET[$key])
            ];
        };
    }
    if (get_query_var('product_cat')) {
        $filter_args['tax_query'][] = [
            'taxonomy' => 'product_cat',
            'field' => 'slug',
            'terms' => get_query_var('product_cat')
        ];
    }
    $args = [
        'post_type' => 'product',
        'posts_per_page' => $posts_per_page,
        'paged' => isset($_GET['page']) ?? 1
    ];
    if (isset($_GET['s'])) {
        $args['s'] = $_GET['s'];
    }
    return new WP_Query(array_merge($args, $sort_args, $price_args, $filter_args));
}

function products_filter() {
    if ($_GET) {
        $query = fetch_data(16);
        if ($query->have_posts()): ?>
            <div class="search-page__results__items d-flex flex-wrap">
                <?php while ($query->have_posts()): $query->the_post();
                    get_template_part('components/product-item');
                endwhile;
                wp_reset_postdata(); ?>
            </div>
            <div class="pagination">
                <?php $pagArrow = '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="8" fill="none"><path stroke-width="2" d="m11.3 1.1-5 5-5-5"/></svg>';
                echo paginate_links([
                    'base' => site_url() . '%_%',
                    'format' => '?page=%#%',
                    'prev_text' => $pagArrow,
                    'next_text' => $pagArrow,
                    'total' => $query->max_num_pages,
                    'current' => $_GET['page'] ?: 1
                ]); ?>
            </div>
        <?php else: ?>
            <div class="d-flex justify-content-center p-5">
                <h2>За заданими фільтрами нічого не знайдено</h2>
            </div>
        <?php endif;
        wp_reset_postdata();
    }
    wp_die();
}

function hide_filters() {
    $filters = fetch_data(-1);
    if ($filters->have_posts()):
        require "product-filter-attr.php";
    else:
        $filters = new WP_Query([
            's' => get_search_query(),
            'post_type' => 'product',
            'posts_per_page' => -1,
            'paged' => $_GET['page'] ?: 1
        ]);
        require "product-filter-attr.php";
    endif;
    wp_reset_postdata();
    wp_die();
}

function handle_cart_item() {
    if ($_POST['key']) {
        WC()->cart->remove_cart_item($_POST['key']);
    } elseif ($_POST['id']) {
        if (is_array($_POST['id'])) {
            foreach ($_POST['id'] as $post_id) {
                WC()->cart->add_to_cart($post_id);
            }
        } else {
            WC()->cart->add_to_cart($_POST['id']);
        }
    }
    get_template_part('components/cart-menu');
    wp_die();
}

function change_qty() {
    if ($_POST['act'] === 'plus') {
        WC()->cart->set_quantity($_POST['key'], $_POST['value'] + 1);
    } else {
        WC()->cart->set_quantity($_POST['key'], $_POST['value'] - 1);
    }
    $cart_items_count = absint(WC()->cart->get_cart_contents_count());
    $cart_all_count = $cart_items_count . ' ' . true_wordform($cart_items_count, 'товар', 'товари', 'товарів');
    $cart_item_qty = WC()->cart->get_cart_item($_POST['key'])['quantity'];
    $total = WC()->cart->get_cart_contents_total();
    $response = [
        'allCount' => $cart_all_count,
        'itemCount' => $cart_item_qty,
        'total' => $total . ' ' . 'грн'
    ];
    echo json_encode($response);
    wp_die();
}

function user_orders_sort() {
    if ($_POST) {
        $post_status = match ($_POST['post_status']) {
            'sort-processing' => 'wc-processing',
            'sort-completed' => 'wc-completed',
            default => array_keys(wc_get_order_statuses())
        };
        $customer_orders = get_posts(
            apply_filters(
                'woocommerce_my_account_my_orders_query',
                [
                    'numberposts' => 20,
                    'meta_key'    => '_customer_user',
                    'meta_value'  => $_POST['user_id'],
                    'post_type'   => wc_get_order_types('view-orders'),
                    'post_status' => $post_status,
                ]
            )
        );
        if ($customer_orders) {
            get_template_part('components/my-account/orders-item', null, ['customer_orders' => $customer_orders]);
        } else {
            get_template_part('components/my-account/empty');
        }
    }
    wp_die();
}


function rev_q_tabs() {
    if ($_POST) {
        $type = $_POST['type'];
        $args = [
            'type' => 'review',
            'user_id' => get_current_user_id(),
            'meta_query' => [
                [
                    'key' => 'type',
                    'value' => $type,
                ]
            ]
        ];
        $reviews = get_comments($args);
        if (!empty($reviews)) {
            foreach ($reviews as $review) {
                if ($type === 'review') {
                    get_template_part('components/my-account/account-reviews-item', null, ['review' => $review]);
                } elseif ($type === 'question') {
                    get_template_part('components/my-account/account-questions-item', null, ['review' => $review]);
                }
            }
        } else {
            if ($type === 'review') {
                get_template_part('components/my-account/reviews-empty', null, ['title' => 'Ви ще не залишали відгуки']);
            } elseif ($type === 'question') {
                get_template_part('components/my-account/reviews-empty', null, ['title' => 'Ви ще не нічого не запитували']);
            }
        }
    }
    wp_die();
}

function order_repeat() {
    if ($_POST['id']) {
        WC()->cart->empty_cart();
        foreach ($_POST['id'] as $post_id) {
            WC()->cart->add_to_cart($post_id);
        }
        echo wc_get_page_permalink('checkout');
    }
}

function user_favorites() {
    if ($_POST['prod_id']) {
        $user_id = get_current_user_id();
        $favorites_arr = get_user_meta($user_id, 'favorites');
        if (!in_array($_POST['prod_id'], $favorites_arr)) {
            add_user_meta($user_id, 'favorites', $_POST['prod_id']);
        } else {
            delete_user_meta($user_id, 'favorites', $_POST['prod_id']);
        }
    }
    wp_die();
}

function remove_user_favorites() {
    if ($_POST['prod_id']) {
        $user_id = get_current_user_id();
        delete_user_meta($user_id, 'favorites', $_POST['prod_id']);
        get_template_part('components/my-account/favorites', null, ['user_id' => $user_id]);
    }
    wp_die();
}

function register_user() {
    if ($_POST['reg']) {
        $reg_form = $_POST['reg'];
        $userdata = [];
        foreach ($reg_form as $input) {
            $userdata[$input['name']] = $input['value'];
        }
        $user_id = wc_create_new_customer($userdata['user_email'], $userdata['user_email'], $userdata['user_pass'], $userdata);
        update_user_meta($user_id, 'billing_phone', $userdata['user_phone']);
        update_user_meta($user_id, 'billing_first_name', $userdata['first_name']);
        update_user_meta($user_id, 'billing_last_name', $userdata['last_name']);
    }
    wp_die();
}

function check_email() {
    if ($_POST['email'] && email_exists($_POST['email'])) {
        echo 'Користувач з таким Email вже існує';
    }
    wp_die();
}

function get_next_reviews() {
    if ($_POST['prod_id'] && $_POST['offset']) {
        $product_id = $_POST['prod_id'];
        $offset = $_POST['offset'];
        $type = $_POST['type'];
        $args = [
            'type' => 'review',
            'post_id' => $product_id,
            'number'  => 3,
            'orderby ' => 'comment_date',
            'order' => 'DESC',
            'offset' => $offset,
            'meta_query' => [
                [
                    'key' => 'type',
                    'value' => $type,
                ]
            ]
        ];
        $rev_count = get_count_of_reviews($product_id, $type);
        $reviews = get_approved_comments($product_id, $args);
        foreach ($reviews as $review) {
            if ($type === 'review') {
                get_template_part('components/reviews-item', null, ['review' => $review, 'prod_id' => $product_id]);
            } elseif ($type === 'question') {
                get_template_part('components/questions-item', null, ['question' => $review, 'prod_id' => $product_id]);
            }
        }
        if ($rev_count - 3 > $offset) { ?>
            <button class="reviews__more std-btn pale-purple-btn font-16-22 fw-600" data-id="<?= $product_id ?>" data-type="<?= $type ?>">Показати ще</button>
        <?php }
    }
    wp_die();
}

function new_comment() {
    if ($_POST['rev_form']) {
        $rev_form = $_POST['rev_form'];
        $rev_content = [];
        foreach ($rev_form as $input) {
            $rev_content[$input['name']] = $input['value'];
        }
        $data = [
            'comment_post_ID'  => $rev_content['product_id'],
            'comment_content'  => $rev_content['review-text'],
            'comment_type'     => 'review',
            'user_id'          => get_current_user_id(),
            'comment_approved' => 0,
            'comment_meta'     => [
                'type' => 'review',
                'rating' => $rev_content['stars'] ?: 1
            ]
        ];
    } elseif ($_POST['ask_form']) {
        $ask_form = $_POST['ask_form'];
        $ask_content = [];
        foreach ($ask_form as $input) {
            $ask_content[$input['name']] = $input['value'];
        }
        $data = [
            'comment_post_ID'  => $ask_content['product_id'],
            'comment_content'  => $ask_content['question-text'],
            'comment_type'     => 'review',
            'user_id'          => get_current_user_id(),
            'comment_approved' => 0,
            'comment_meta'     => [
                'type' => 'question'
            ]
        ];
    }
    wp_insert_comment($data);
    wp_die();
}

function change_password() {
    if ($_POST['data']) {
        $user_id = get_current_user_id();
        $user = get_userdata($user_id);
        $formdata = [];
        foreach ($_POST['data'] as $input) {
            $formdata[$input['name']] = $input['value'];
        }
        $current_password = $formdata['password_current'];
        $new_password = $formdata['password_new'];
        if ($user && wp_check_password($current_password, $user->user_pass, $user_id)) {
            wp_set_password($new_password, $user_id);
            echo 'success';
        } else {
            echo 'password-error';
        }
    }
    wp_die();
}

function db_city_search() {
    if ($_POST) {
        global $wpdb;
        $search = sanitize_text_field($_POST['search']);
        $area_ref = $_POST['ref'];
        $cities_data = $wpdb->get_results("
            SELECT ref, description
            FROM wp_nova_poshta_cities
            WHERE area_ref = '$area_ref'
            AND (description LIKE '$search%'
            OR description_ru LIKE '$search%')
            LIMIT 20
        ");
        foreach ($cities_data as $item) {
            $name = $item->description;
            $ref = $item->ref;
            get_template_part('components/checkout/checkout-select-option', null, ['name' => $name, 'ref' => $ref]);
        }
    }
    wp_die();
}

function db_np_depart_search() {
    if ($_POST) {
        global $wpdb;
        $search = sanitize_text_field($_POST['search']);
        $city_ref = $_POST['ref'];
        if ($_POST['type'] === 'department') {
            $cities_data = $wpdb->get_results("
                SELECT ref, description
                FROM wp_nova_poshta_warehouses
                WHERE city_ref = '$city_ref'
                AND warehouse_type < 3
                AND (description LIKE '%$search%'
                OR description_ru LIKE '%$search%')
                LIMIT 20
            ");
        } elseif ($_POST['type'] === 'postomat') {
            $cities_data = $wpdb->get_results("
                SELECT description
                FROM wp_nova_poshta_warehouses
                WHERE city_ref = '$city_ref'
                AND warehouse_type = 3
                AND (description LIKE '%$search%'
                OR description_ru LIKE '%$search%')
                LIMIT 20
            ");
        } else {
            exit;
        }
        foreach ($cities_data as $item) {
            get_template_part('components/checkout/checkout-select-option', null, ['name' => $item->description]);
        }
    }
    wp_die();
}

function coupon_check() {
    if ($_POST['coupon']) {
        $coupon = new WC_Coupon(sanitize_text_field($_POST['coupon']));
        $discounts = new WC_Discounts( WC()->cart );
        $is_valid = is_wp_error( $discounts->is_coupon_valid($coupon) ) ? false : true;
        if (WC()->cart->has_discount( $_POST['coupon'] )) {
            echo json_encode(['error' => 'Промокод вже застосований'], JSON_UNESCAPED_UNICODE);
        } elseif ($is_valid) {
            $cart = WC()->cart;
            $disc_val = $cart->get_cart_contents_total() * ($coupon->get_amount() / 100);
            $cart->apply_coupon('test');
            echo json_encode(['discount' => $disc_val, 'total' => $cart->get_cart_contents_total()]);
        } else {
            echo json_encode(['error' => 'Промокод недійсний'], JSON_UNESCAPED_UNICODE);
        }
    }
    wp_die();
}