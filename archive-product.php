<?php get_header();
//wp_redirect(get_home_url());
//exit;
$page = get_query_var('page', 1);
$search = new WP_Query([
    'post_type'      => 'product',
    'posts_per_page' => 16,
    'paged'          => $page,
    'orderby'        => 'meta_value_num',
    'order'          => 'DESC',
    'meta_key'       => '_total_views_count',
]); ?>
<div class="shop-page wrapper filler">
    <?php woocommerce_breadcrumb();
    require "components/banner.php";
    require 'shop.php'; ?>
</div>
<?php get_footer();