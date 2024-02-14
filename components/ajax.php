<?php if (wp_doing_ajax()) {

    // filter products
    add_action( 'wp_ajax_filter', 'products_filter' );
    add_action( 'wp_ajax_nopriv_filter', 'products_filter' );
    function products_filter() {
        if ($_GET) {
            $query = fetch_data(16);
            if ($query->have_posts()) { ?>
                <div class="search-page__results__items">
                    <?php while ($query->have_posts()): $query->the_post();
                        get_template_part('components/product-item');
                    endwhile;
                    wp_reset_postdata(); ?>
                </div>
                <?php
                $pagArrow = '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="8" fill="none"><path stroke-width="2" d="m11.3 1.1-5 5-5-5"/></svg>';
                $pagination = paginate_links([
                    'base' => site_url() . '%_%',
                    'format' => '?page=%#%',
                    'prev_text' => $pagArrow,
                    'next_text' => $pagArrow,
                    'total' => $query->max_num_pages,
                    'current' => $_GET['page'] ?: 1
                ]);
                if ($pagination) { ?>
                    <div class="pagination">
                        <?= $pagination ?>
                    </div>
                <?php }
            } else { ?>
                <div class="d-flex justify-content-center p-5">
                    <h2>За заданими фільтрами нічого не знайдено</h2>
                </div>
            <?php }
            wp_reset_postdata();
            get_template_part('components/spinner');
        }
        wp_die();
    }

    // hide filters
    add_action( 'wp_ajax_hide_filters', 'hide_filters' );
    add_action( 'wp_ajax_nopriv_hide_filters', 'hide_filters' );
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

    // add/remove cart items
    add_action( 'wp_ajax_handle_cart_item', 'handle_cart_item' );
    add_action( 'wp_ajax_nopriv_handle_cart_item', 'handle_cart_item' );
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

    // change quantity of product in the cart
    add_action( 'wp_ajax_change_qty', 'change_qty' );
    add_action( 'wp_ajax_nopriv_change_qty', 'change_qty' );
    function change_qty() {
        WC()->cart->set_quantity($_POST['key'], $_POST['value']);

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

    // sort orders in user profile
    add_action( 'wp_ajax_user_orders_sort', 'user_orders_sort' );
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
                        'meta_value'  => get_current_user_id(),
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

    // toggle reviews/questions tabs in user profile
    add_action( 'wp_ajax_rev_q_tabs', 'rev_q_tabs' );
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

    // repeat order in orders list in user profile
    add_action( 'wp_ajax_order_repeat', 'order_repeat' );
    function order_repeat() {
        if ($_POST['id']) {
            WC()->cart->empty_cart();
            foreach ($_POST['id'] as $post_id) {
                WC()->cart->add_to_cart($post_id);
            }
            echo wc_get_page_permalink('checkout');
        }
    }

    // add/remove user favorite products
    add_action( 'wp_ajax_user_favorites', 'user_favorites' );
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

    // remove favorite product from user profile
    add_action( 'wp_ajax_remove_user_favorites', 'remove_user_favorites' );
    function remove_user_favorites() {
        if ($_POST['prod_id']) {
            $user_id = get_current_user_id();
            delete_user_meta($user_id, 'favorites', $_POST['prod_id']);
            get_template_part('components/my-account/favorites', null, ['user_id' => $user_id]);
        }
        wp_die();
    }

    // login user
    add_action( 'wp_ajax_login_user', 'login_user' );
    add_action( 'wp_ajax_nopriv_login_user', 'login_user' );
    function login_user() {
        $username = sanitize_email($_POST['login']);
        if ($username) {
            if (username_exists($username)) {
                $user = get_user_by('login', $username);
                $password = sanitize_text_field($_POST['password']);
                if ($user && wp_check_password($password, $user->data->user_pass, $user->ID)) {
                    wp_clear_auth_cookie();
                    wp_set_current_user ( $user->ID );
                    wp_set_auth_cookie  ( $user->ID, $_POST['remember'] );
                    echo 'success';
                } else {
                    echo 'password_error';
                }
            } else {
                echo 'login_error';
            }
        }
        wp_die();
    }

    // register user
    add_action( 'wp_ajax_register_user', 'register_user' );
    add_action( 'wp_ajax_nopriv_register_user', 'register_user' );
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
            update_user_meta($user_id, 'billing_country', 'UA');
        }
        wp_die();
    }

    // send reset password email
    add_action( 'wp_ajax_lost_password_email', 'lost_password_email' );
    add_action( 'wp_ajax_nopriv_lost_password_email', 'lost_password_email' );
    function lost_password_email() {
        retrieve_password(sanitize_email($_POST['email']));
        wp_die();
    }

    // check is there registered user email
    add_action( 'wp_ajax_check_email', 'check_email' );
    add_action( 'wp_ajax_nopriv_check_email', 'check_email' );
    function check_email() {
        $email = sanitize_email($_POST['email']);
        if ($email && email_exists($email)) {
            echo 'Користувач з таким Email вже існує';
        }
        wp_die();
    }

    // get next reviews on button click
    add_action( 'wp_ajax_get_next_reviews', 'get_next_reviews' );
    add_action( 'wp_ajax_nopriv_get_next_reviews', 'get_next_reviews' );
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

    // make product new review/question
    add_action( 'wp_ajax_new_comment', 'new_comment' );
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

    // change user password from user profile
    add_action( 'wp_ajax_change_password', 'change_password' );
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

    // search city in nova_poshta database
    add_action( 'wp_ajax_db_city_search', 'db_city_search' );
    add_action( 'wp_ajax_nopriv_db_city_search', 'db_city_search' );
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

    // search department in nova_poshta database
    add_action( 'wp_ajax_db_np_depart_search', 'db_np_depart_search' );
    add_action( 'wp_ajax_nopriv_db_np_depart_search', 'db_np_depart_search' );
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

    // coupon handler
    add_action( 'wp_ajax_coupon_check', 'coupon_check' );
    add_action( 'wp_ajax_nopriv_coupon_check', 'coupon_check' );
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

    // desktop search helper for categories
    add_action( 'wp_ajax_search_helper_categories', 'search_helper_categories' );
    add_action( 'wp_ajax_nopriv_search_helper_categories', 'search_helper_categories' );
    function search_helper_categories() {
        $search = sanitize_text_field($_GET['search']);
        if ($search) {
            $categories = new WP_Query([
                'post_type' => 'product',
                'posts_per_page' => -1,
                's' => $search
            ]);
            if ($categories->have_posts()): ?>
                <?php $categories_arr = categories_from_query($categories);
                wp_reset_postdata();

                for ($i = 0; $i < 3; $i++) {
                    $category = array_values($categories_arr)[$i]; ?>
                    <a href="<?= $category['link'] ?>" class="search-try__item search-try__link font-14-20 fw-400 d-block"><?= $category['name'] ?></a>
                <?php } ?>
            <?php endif;
        }
        wp_die();
    }

    // desktop search helper for products
    add_action( 'wp_ajax_search_helper_products', 'search_helper_products' );
    add_action( 'wp_ajax_nopriv_search_helper_products', 'search_helper_products' );
    function search_helper_products() {
        $search = sanitize_text_field($_GET['search']);
        if ($search) {
            $popular = new WP_Query([
                'post_type' => 'product',
                'posts_per_page' => 5,
                'meta_key' => 'total_sales',
                'orderby' => 'meta_value_num',
                's' => $search
            ]);
            if ($popular->have_posts()): while ($popular->have_posts()): $popular->the_post();
                get_template_part('components/search-product');
            endwhile; endif;
            wp_reset_postdata();
        }
        wp_die();
    }

    // mobile search
    add_action( 'wp_ajax_mobile_search', 'mobile_search' );
    add_action( 'wp_ajax_nopriv_mobile_search', 'mobile_search' );
    function mobile_search() {
        $search = sanitize_text_field($_GET['search']);
        if ($search) {
            $categories = new WP_Query([
                'post_type' => 'product',
                'posts_per_page' => -1,
                's' => $search
            ]);
            if ($categories->have_posts()): ?>
                <section class="mobile-search__categories">
                    <h2 class="mobile-search__section-title font-20-24 fw500">Категорії</h2>
                    <div class="mobile-search__categories__list d-flex flex-wrap">
                        <?php $categories_arr = categories_from_query($categories);
                        wp_reset_postdata();

                        foreach ($categories_arr as $category) { ?>
                            <a href="<?= $category['link'] ?>" class="mobile-search__categories__link"><?= $category['name'] ?></a>
                        <?php } ?>
                    </div>
                </section>
            <?php endif;
            $popular = new WP_Query([
                'post_type' => 'product',
                'posts_per_page' => 2,
                'meta_key' => 'total_sales',
                'orderby' => 'meta_value_num',
                's' => $search
            ]);
            if ($popular->have_posts()): ?>
                <section class="mobile-search__popular">
                    <h2 class="mobile-search__section-title font-20-24 fw500">Популярні товари</h2>
                    <div class="mobile-search__popular__items">
                        <?php while ($popular->have_posts()): $popular->the_post();
                            get_template_part('components/product-item');
                        endwhile;
                        wp_reset_postdata(); ?>
                    </div>
                </section>
                <button class="mobile-search__button std-btn purple-btn" form="mobile-search">Переглянути всі результати пошуку</button>
            <?php endif;
        }
        wp_die();
    }
}