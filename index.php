<?php /* Template Name: Home Template */
get_header(); ?>
<div class="homepage wrapper filler">
    <?php require "components/banner.php"; ?>
    <section class="top products-slider">
        <h2 class="section-title">Топ товари</h2>
        <div class="top__items products-slider__items">
            <?php $topProducts = new WP_Query([
                'post_type' => 'product',
                'posts_per_page' => 10,
                'orderby' => 'meta_value_num',
                'order' => 'DESC',
                'meta_key' => '_wc_average_rating'
            ]);
            if ($topProducts->have_posts()): while ($topProducts->have_posts()): $topProducts->the_post();
                require "components/product-item.php";
            endwhile; endif;
            wp_reset_postdata(); ?>
        </div>
        <button type="button" class="top__prev products-slider__prev slider-arrow transition-default">
            <svg xmlns="http://www.w3.org/2000/svg" width="9" height="14" fill="none"><path stroke="#363D44" stroke-linecap="round" stroke-width="2" d="M8 13 2 7l6-6"/></svg>
        </button>
        <button type="button" class="top__next products-slider__next slider-arrow transition-default">
            <svg xmlns="http://www.w3.org/2000/svg" width="9" height="14" fill="none"><path stroke="#363D44" stroke-linecap="round" stroke-width="2" d="m1 1 6 6-6 6"/></svg>
        </button>
    </section>
    <?php require 'components/categories.php'; ?>
    <section class="hits products-slider">
        <h2 class="section-title">Хіти продажів</h2>
        <div class="hits__items products-slider__items">
            <?php $hits = new WP_Query([
                'post_type' => 'product',
                'posts_per_page' => 10,
                'meta_key' => 'total_sales',
                'orderby' => 'meta_value_num',
            ]);
            if ($hits->have_posts()): while ($hits->have_posts()): $hits->the_post();
                require "components/product-item.php";
            endwhile; endif;
            wp_reset_postdata(); ?>
        </div>
        <button type="button" class="hits__prev products-slider__prev slider-arrow transition-default">
            <svg xmlns="http://www.w3.org/2000/svg" width="9" height="14" fill="none"><path stroke="#363D44" stroke-linecap="round" stroke-width="2" d="M8 13 2 7l6-6"/></svg>
        </button>
        <button type="button" class="hits__next products-slider__next slider-arrow transition-default">
            <svg xmlns="http://www.w3.org/2000/svg" width="9" height="14" fill="none"><path stroke="#363D44" stroke-linecap="round" stroke-width="2" d="m1 1 6 6-6 6"/></svg>
        </button>
    </section>
    <?php $promos = new WP_Query(['post_type' => 'promo', 'posts_per_page' => 3]);
    $promos_link = get_field('promos_page', 'options');
    if ($promos->have_posts()): ?>
        <section class="promo">
            <h2 class="section-title">Акції</h2>
            <div class="promo__items d-flex">
                <?php while ($promos->have_posts()): $promos->the_post();
                    require 'components/promo-item.php';
                endwhile; ?>
                <a href="<?= $promos_link; ?>" class="promo__item transition-default d-flex justify-content-center align-items-center">
                    <p class="promo__item-all font-15-24 fw-600">Усі акції</p>
                    <?php require "components/link-arrow.php"; ?>
                </a>
            </div>
        </section>
    <?php endif; ?>
    <section class="brands">
        <h2 class="section-title">Бренди</h2>
        <div class="brands__items d-flex flex-wrap">
            <?php $brands_page_link = get_field('brands_page', 'options');
            $brands = get_terms(['taxonomy' => 'pa_brand']);
            $brands_logos = get_field('brands', 'options');
            for ($b = 0; $b < 11; $b++) {
                $brand = $brands[$b];
                foreach ($brands_logos as $logo) {
                    if ($logo['brand_name'] === $brand->name) {
                        require "components/brands-item.php";
                    }
                }
            } ?>
            <a href="<?= $brands_page_link; ?>" class="brands-item brands__link transition-default d-flex justify-content-center align-items-center">
                <p class="brands__link-all font-15-24 fw-600">Усі бренди</p>
                <?php require "components/link-arrow.php"; ?>
            </a>
        </div>
    </section>
</div>
<?php get_footer();