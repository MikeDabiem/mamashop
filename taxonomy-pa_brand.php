<?php get_header(); ?>
    <section class="category-page wrapper filler">
        <?php woocommerce_breadcrumb(); ?>
        <h1 class="section-title"><?php woocommerce_page_title(); ?></h1>
        <?php $search = new WP_Query([
            'post_type' => 'product',
            'posts_per_page' => 16,
            'tax_query' => [
                [
                    'taxonomy' => 'pa_brand',
                    'field' => 'name',
                    'terms' => woocommerce_page_title(false)
                ]
            ]
        ]);
        if ($search->have_posts()):
            $products_count = wc_get_loop_prop('total'); ?>
            <p class="products-count font-14-20 fw-400"><?= $products_count . ' ' . true_wordform($products_count, 'товар', 'товари', 'товарів') ?></p>
            <?php require "components/banner.php";
            require 'shop.php';
        endif;
        wp_reset_postdata(); ?>
    </section>
<?php get_footer();