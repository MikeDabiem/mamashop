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

require 'components/ajax.php';

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
