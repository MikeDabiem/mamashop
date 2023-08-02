<?php /* Template Name: Shop Template */
get_header(); ?>
<div class="shoppage wrapper filler">
    <?php $allProducts = new WP_Query(['post_type' => 'product', 'post_per_page' => 1]);
    if ($allProducts->have_posts()): while ($allProducts->have_posts()): $allProducts->the_post();
        echo '<pre>';
        $brand = $product->get_attribute('brend');
        print_r($brand);
        echo '</pre>';
    endwhile; endif;
    wp_reset_postdata(); ?>
</div>
<?php get_footer();