<?php
/*Load styles and scripts*/
function load_style_script()
{
    $templatePath = ['templateUrl' => get_template_directory_uri()];

    // CSS PLUGINS
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css');
    wp_enqueue_style('slick', get_template_directory_uri() . '/css/slick.css');

    // CSS CUSTOM
    wp_enqueue_style('styleMain', get_template_directory_uri() . '/css/compiled-css/style.css');
    wp_enqueue_style('style', get_template_directory_uri() . '/style.css');

    // JS PLUGINS
    wp_enqueue_script('jquery');
    wp_enqueue_script('bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js');
    wp_enqueue_script('slick', get_template_directory_uri() . '/js/slick.min.js');
    wp_enqueue_script('slick-js', get_template_directory_uri() . '/js/slick-main.js');
    wp_enqueue_script('nova-poshta', get_template_directory_uri() . '/js/nova-poshta.js');

    // JS CUSTOM HEADER
    wp_enqueue_script('main', get_template_directory_uri() . '/js/main.js');

    wp_localize_script('main', 'ajaxurl', ['url' => admin_url('admin-ajax.php')]);
    wp_localize_script('main', 'searchHelpArr', [
        "Порошок для прання",
        "Пом'якшувач для тканини",
        "Мило для прання",
        "Рідкий пральний засіб",
        "Плямовивідник",
        "Порошок для посуду",
        "Порошок для прибирання",
        "Гель для прання",
        "Гель для душу",
        "Шампунь"
    ]);
}
add_action("wp_enqueue_scripts", "load_style_script");
/*END Load styles and scripts*/

add_theme_support('woocommerce');
add_theme_support('menus');
add_theme_support('widgets');

require 'components/ajax.php';
require 'components/checkout-settings.php';

//add views count meta to new products
add_action('woocommerce_new_product', 'initialize_total_views_count');
function initialize_total_views_count($product_id) {
    add_post_meta($product_id, '_total_views_count', 0, true);
    add_post_meta($product_id, '_discount_value', get_product_discount($product_id), true);
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
    $product = wc_get_product($id);
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

// Hide/remove content editor
function hide_editor() {
    $template_file = basename(get_page_template());
    $templatesArray = ['brands.php'];
    if (in_array($template_file, $templatesArray)) remove_post_type_support('page', 'editor');
}
add_action('admin_head', 'hide_editor');

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
    add_rewrite_endpoint( 'qna', EP_PAGES );
    add_rewrite_endpoint( 'security', EP_PAGES );
}

// add fields to edit-account
add_action( 'woocommerce_save_account_details', 'save_additional_account_details' );
function save_additional_account_details( $user_id ) {
    if (isset($_POST['birthday'])) {
        update_user_meta($user_id, 'account_middle_name', sanitize_text_field($_POST['account_middle_name']));
        update_user_meta($user_id, 'birthday', sanitize_text_field($_POST['birthday']));
    }
}