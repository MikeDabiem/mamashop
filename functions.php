<?php
/*Load styles and scripts*/
function load_style_script() {
    $timestamp = time();

    // CSS PLUGINS
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css');
    wp_enqueue_style('slick', get_template_directory_uri() . '/css/slick.css');

    // CSS CUSTOM
    wp_enqueue_style('styleMain', get_template_directory_uri() . '/css/compiled-css/style.css', [], $timestamp);
    wp_enqueue_style('style', get_template_directory_uri() . '/style.css');

    // JS PLUGINS
    wp_enqueue_script('jquery');
    wp_enqueue_script('bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js');
    wp_enqueue_script('slick', get_template_directory_uri() . '/js/slick.js');
    wp_enqueue_script('slick-js', get_template_directory_uri() . '/js/slick-main.js', ['slick'], $timestamp);

    // JS CUSTOM HEADER
    wp_enqueue_script('main', get_template_directory_uri() . '/js/main.js', ['jquery'], $timestamp);
    wp_enqueue_script('nova-poshta', get_template_directory_uri() . '/js/nova-poshta.js', [], $timestamp);

    wp_localize_script('nova-poshta', 'ajaxurl', ['url' => admin_url('admin-ajax.php')]);

    global $wp_query;
    $wp_query_vars = $wp_query->query_vars;
    $category = $wp_query_vars['product_cat'] ?? '';
    $search_helper = get_field('search_helper', 'options');
    $searchHelpArr = [];
    foreach ($search_helper as $help) {
        $searchHelpArr[] = $help['search_helper_text'];
    }
    wp_localize_script('main', 'phpData', [
        'ajaxurl' => admin_url('admin-ajax.php'),
        'searchHelpArr' => $searchHelpArr,
        'category'  => $category,
	    'minOrderPrice' => get_field('min_price', 'options'),
	    'shopAddress' => get_field('shop_address', 'options')
    ]);
}
add_action("wp_enqueue_scripts", "load_style_script");
/*END Load styles and scripts*/

add_theme_support('woocommerce');
add_theme_support('menus');
add_theme_support('widgets');

// get products
function fetch_data($posts_per_page) {
    $sort_options = [];
    $orderby_value = isset($_GET['sort']) ? wc_clean($_GET['sort']) : '';
    $sort_options = match ($orderby_value) {
        'new' => [
            'meta_key' => '_date',
            'type'     => 'DATE',
            'order'    => 'DESC',
        ],
        'price-asc' => [
            'meta_key' => '_price',
            'type'  => 'NUMERIC',
            'order'    => 'ASC',
        ],
        'price-desc' => [
            'meta_key' => '_price',
            'type'  => 'NUMERIC',
            'order'    => 'DESC',
        ],
        'rating' => [
            'meta_key' => '_wc_average_rating',
            'type'  => 'NUMERIC',
            'order'    => 'DESC',
        ],
        'price-disc' => [
            'meta_key' => '_discount_value',
            'type'  => 'NUMERIC',
            'order'    => 'DESC',
        ],
        default => [
            'meta_key' => '_total_views_count',
            'type'  => 'NUMERIC',
            'order'    => 'DESC',
        ],
    };
	$sort_args = [
		'meta_query' => [
			'relation' => 'AND',
			'sort_options' => [
				'key'  => $sort_options['meta_key'],
				'type' => $sort_options['type']
			],
			'stock_status' => [
				'key' => '_stock_status',
			]
		],
		'orderby'  => [
			'stock_status' => 'ASC',
			'sort_options' => $sort_options['order']
		]
	];

    $price_args = [];
    if (isset($_GET['price'])) {
        $price_args = [
            'meta_query' => [
                [
                    'key'     => '_price',
                    'value'   => wc_clean(explode('-', $_GET['price'])),
                    'type'    => 'numeric',
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
                'field'    => 'slug',
                'terms'    => explode(',', $_GET[$key])
            ];
        };
    }

    if (get_query_var('product_cat') || !empty($_GET['category'])) {
        $terms = get_query_var('product_cat') ?: $_GET['category'];
        $filter_args['tax_query'][] = [
            'taxonomy' => 'product_cat',
            'field'    => 'slug',
            'terms'    => $terms
        ];
    }

    $args = [
        'post_type'      => 'product',
        'posts_per_page' => $posts_per_page,
        'paged'          => $_GET['page'] ?? 1
    ];
    if (isset($_GET['s'])) {
        $args['s'] = $_GET['s'];
    }

    return new WP_Query(array_merge_recursive($args, $sort_args, $price_args, $filter_args));
}

require_once 'components/ajax.php';
require_once 'components/shortcodes.php';
require_once 'components/checkout/checkout-settings.php';

//add views count meta to new products
add_action('save_post_product', 'brinpl_add_product_meta', 10, 3);
function brinpl_add_product_meta($product_id, $product, $update) {
	if (!$update) {
		add_post_meta($product_id, '_date', date('Y/m/d', time()), true);
	    add_post_meta($product_id, '_total_views_count', 0, true);
	    add_post_meta($product_id, '_discount_value', get_product_discount($product_id), true);
	}
}

// update views product counter
add_action("woocommerce_before_single_product", "product_view_counter");
function product_view_counter() {
    $meta = get_post_meta( get_the_ID(), "_total_views_count", true );
    $meta = (int)($meta) ? $meta + 1 : 1;
    update_post_meta( get_the_ID(), "_total_views_count", $meta );
}

// update discount meta value on update product
add_action("woocommerce_update_product", "update_product_discount_meta_value");
function update_product_discount_meta_value($id) {
    update_post_meta($id, "_discount_value", get_product_discount($id));
}

// calc product discount
function get_product_discount($id) {
	$_pf = new WC_Product_Factory();
	$product = $_pf->get_product( $id );
    $price = $product->get_regular_price();
    $salePrice = $product->get_sale_price();
    if ($price && $salePrice) {
        return round(100 - $salePrice / $price * 100);
    } else {
        return 0;
    }
}

// breadcrumbs settings
add_filter( 'woocommerce_breadcrumb_defaults', function($defaults) {
    return array_merge($defaults, [
        'delimiter' => ' > ',
        'home' => 'Головна',
        'wrap_before' => '<nav class="breadcrumbs font-11-13 fw-400">'
    ]);
} );

function true_wordform($num, $form_for_1, $form_for_2, $form_for_5) {
    $num = abs($num) % 100;
    $num_x = $num % 10;
    if ($num > 10 && $num < 20)
        return $form_for_5;
    if ($num_x > 1 && $num_x < 5)
        return $form_for_2;
    if ($num_x === 1)
        return $form_for_1;
    return $form_for_5;
}

// Make ACF Options
if (function_exists('acf_add_options_page')) {
    $args = ['page_title' => 'Options', 'menu_title' => 'Options'];
    acf_add_options_page($args);
}

// SVG Through admin-panel
function cc_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

// register promo post type
function promo_post_type() {
    $args = [
        'labels' => [
            'name' => 'Акції',
            'singular_name' => 'Акція',
            'add_new' => 'Додати Акцію',
            'edit_item' => 'Редагувати Акцію',
            'view_item' => 'Переглянути Акцію',
            'menu_name' => 'Акції'
        ],
        'public' => true,
        'exclude_from_search' => true,
        'show_in_nav_menus' => false,
        'menu_icon' => 'dashicons-chart-line',
        'supports' => [
            'title',
            'editor',
            'thumbnail'
        ]
    ];
    register_post_type( 'promo', $args );
}
add_action( 'init', 'promo_post_type' );

add_filter( 'woocommerce_add_to_cart_fragments', 'cart_products_count' );
function cart_products_count( $fragments ) {
    $cart_items_count = absint(WC()->cart->get_cart_contents_count());
    $fragments[ '.cart-menu__value' ] = `<p class="cart-menu__value font-14-20 fw-500">` . $cart_items_count . ' ' . true_wordform($cart_items_count, 'товар', 'товари', 'товарів') . `</p>`;
    return $fragments;
}

// remove currency symbol
add_filter('woocommerce_currency_symbol', function() {return false;});

// add my-account endpoints
add_action( 'init', 'cabinet_add_endpoints', 25 );
function cabinet_add_endpoints() {
    add_rewrite_endpoint( 'favorites', EP_PAGES );
    add_rewrite_endpoint( 'reviews', EP_PAGES );
    add_rewrite_endpoint( 'security', EP_PAGES );
}

// add fields to edit-account
add_action( 'woocommerce_save_account_details', 'save_additional_account_details' );
function save_additional_account_details( $user_id ) {
    if (isset($_POST['account_first_name'])) {
        update_user_meta($user_id, 'billing_first_name', sanitize_text_field($_POST['account_first_name']));
    }
    if (isset($_POST['account_last_name'])) {
        update_user_meta($user_id, 'billing_last_name', sanitize_text_field($_POST['account_last_name']));
    }
    if (isset($_POST['account_middle_name'])) {
        update_user_meta($user_id, 'middle_name', sanitize_text_field($_POST['account_middle_name']));
    }
    if (isset($_POST['billing_phone'])) {
        update_user_meta($user_id, 'billing_phone', sanitize_text_field($_POST['billing_phone']));
    }
}

// login after registration
add_action( 'user_register', 'auto_login_new_user' );
function auto_login_new_user($user_id) {
    wp_set_current_user($user_id);
    wp_set_auth_cookie($user_id);
}

// get product rating
function get_product_rating ($product) {
    $ratings_arr = $product->get_rating_counts();
    if (!empty($ratings_arr)) {
        $ratings_sum = [];
        foreach ($ratings_arr as $value => $count) {
            $ratings_sum[] = $value * $count;
        }
        return array_sum($ratings_sum) / array_sum($ratings_arr);
    } else {
        return 0;
    }
}

// get count of product reviews
function get_count_of_reviews($product_id, $meta_value = 'review') {
    return count(get_approved_comments($product_id, [
        'type' => 'review',
        'post_id' => $product_id,
        'meta_query' => [
            [
                'key' => 'type',
                'value' => $meta_value,
            ],
        ],
    ]));
}

// redirect to custom lost-password page
add_action( 'login_form_lostpassword', 'redirect_to_custom_lostpassword' );
function redirect_to_custom_lostpassword() {
    if ( is_user_logged_in() ) {
        wp_redirect(wc_get_page_permalink('myaccount') . '/security/');
        exit;
    }

    wp_redirect( home_url() );
    exit;
}

add_action( 'login_form_rp', 'redirect_to_custom_password_reset' );
add_action( 'login_form_resetpass', 'redirect_to_custom_password_reset' );
function redirect_to_custom_password_reset() {
    if ( $_SERVER['REQUEST_METHOD'] === 'GET' ) {
        $user = check_password_reset_key( $_REQUEST['key'], $_REQUEST['login'] );
        if ( !$user || is_wp_error( $user ) ) {
            if ( $user && $user->get_error_code() === 'expired_key' ) {
                wp_redirect( home_url( '404?error=expiredkey' ) );
            } else {
                wp_redirect( home_url( '404?error=invalidkey' ) );
            }
            exit;
        }

        $redirect_url = home_url( 'lost-password' );
        $redirect_url = add_query_arg( 'login', esc_attr( $_REQUEST['login'] ), $redirect_url );
        $redirect_url = add_query_arg( 'key', esc_attr( $_REQUEST['key'] ), $redirect_url );
        wp_redirect( $redirect_url );
        exit;
    } elseif ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
        $rp_key = $_REQUEST['rp_key'];
        $rp_login = $_REQUEST['rp_login'];
        $user = check_password_reset_key( $rp_key, $rp_login );
        if ( ! $user || is_wp_error( $user ) ) {
            if ( $user && $user->get_error_code() === 'expired_key' ) {
                wp_redirect( home_url( '404?error=expiredkey' ) );
            } else {
                wp_redirect( home_url( '404?error=invalidkey' ) );
            }
            exit;
        }
        reset_password( $user, $_POST['pass1'] );
        $redirect_url = home_url();
        $redirect_url = add_query_arg( 'password', 'changed', $redirect_url );

        wp_redirect( $redirect_url );
        exit;
    }
}

// change retrieve password email message
add_filter( 'retrieve_password_title', 'replace_retrieve_password_title' );
function replace_retrieve_password_title($title) {
    $site = str_replace('www.', '', $_SERVER['HTTP_HOST']);
    $title = "Зміна паролю на сайті $site";
    return $title;
}

// change retrieve password email message
add_filter( 'retrieve_password_message', 'replace_retrieve_password_message' , 10, 4 );
function replace_retrieve_password_message( $message, $key, $user_login, $user_data ) {
    $user = get_user_by('email', $user_login);
    $site = str_replace('www.', '', $_SERVER['HTTP_HOST']);
    $msg  = "Вітаємо, $user->first_name!" . "\r\n\r\n";
    $msg .= "Ви подали заявку на зміну паролю на сайті $site" . "\r\n\r\n";
    $msg .= 'Якщо сталася помилка, або це були не Ви, просто не звертайте увагу на це повідомлення і пароль не буде змінено.' . "\r\n\r\n";
    $msg .= 'Щоб змінити пароль до Вашого акаунту перейдіть за цим посиланням:' . "\r\n\r\n";
    $msg .= site_url( "wp-login.php?action=rp&key=$key&login=" . rawurlencode( $user_login ), 'login' ) . "\r\n";
    return $msg;
}

add_action( 'template_redirect', 'thanks_redirect');
function thanks_redirect() {
    if ( is_wc_endpoint_url( 'order-received' ) ) {
        global $wp;
        $order_id =  intval( str_replace( 'checkout/order-received/', '', $wp->request ) );
        wp_redirect(home_url("?success-order=$order_id"));
        exit;
    }
}

// add queried products categories to array
function categories_from_query(WP_Query $categories): array {
    $categories_arr = [];
    while ($categories->have_posts()): $categories->the_post();
        $id = get_the_ID();
        $terms = get_the_terms($id, 'product_cat');
        foreach ($terms as $term) {
            $categories_arr[$term->term_id]['name'] = $term->name;
            $categories_arr[$term->term_id]['link'] = get_term_link($term);
        }
    endwhile;
    return $categories_arr;
}

// disable adding "-scaled" to images filename
add_filter( 'big_image_size_threshold', '__return_false' );

// woocommerce order statuses
function brinpl_order_statuses_filter( $order_statuses ) {
	$order_statuses['wc-processing'] = 'Новый заказ';
	$order_statuses['wc-on-hold'] = 'Форс мажор';

	$order_statuses_keys_order = array(
		'wc-pending',
		'wc-pay-wait-self',
		'wc-processing',
		'wc-on-hold',
		'wc-ready-to-shipping',
		'wc-on-delivery',
		'wc-delivered',
		'wc-completed',
		'wc-cancelled',
		'wc-refunded',
		'wc-failed'
	);

	$new_order_statuses = array();
	foreach ( $order_statuses_keys_order as $key ) {
		if ( isset( $order_statuses[ $key ] ) ) {
			$new_order_statuses[ $key ] = $order_statuses[ $key ];
		}
	}

    return $new_order_statuses;
}
add_filter( 'wc_order_statuses', 'brinpl_order_statuses_filter' );

// change emails titles
function custom_content_before_email_settings() {
	$mailer = WC()->mailer()->get_emails();
	$mailer['WC_Email_Customer_On_Hold_Order']->title = 'Форс мажор';
	$mailer['WC_Email_Customer_Processing_Order']->title = 'Новый заказ (оплачен)';
}
add_action( 'woocommerce_sections_email', 'custom_content_before_email_settings' );

// rename "Записи" to "Блог"
function rename_posts_menu_label() {
	global $menu;

	$menu[5][0] = 'Блог';
}
add_action('admin_menu', 'rename_posts_menu_label');

// turn off ACF pro updates
add_filter('site_transient_update_plugins', function ($value) {
	if (isset($value) && is_object($value)) {
		unset($value->response['advanced-custom-fields-pro/acf.php']);
	}
	return $value;
});