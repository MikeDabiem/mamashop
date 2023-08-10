<?php /* Template Name: Promo Template */
get_header(); ?>
<div class="promo-page wrapper filler">
    <?php woocommerce_breadcrumb(); ?>
    <h1 class="section-title"><?php the_title(); ?></h1>
    <?php $promos = new WP_Query(['post_type' => 'promo', 'posts_per_page' => -1]);
    if ($promos->have_posts()): ?>
        <?php $promos_count = $promos->found_posts; ?>
        <p class="products-count font-14-20 fw-400"><?= $promos_count . ' ' . true_wordform($promos_count, 'акція', 'акції', 'акцій') ?></p>
        <div class="promo-page__items d-flex flex-wrap">
            <?php while ($promos->have_posts()): $promos->the_post();
                require 'components/promo-item.php';
            endwhile; ?>
        </div>
    <?php endif;
    wp_reset_postdata(); ?>
</div>
<?php get_footer();
