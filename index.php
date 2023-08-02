<?php /* Template Name: Home Template */
get_header(); ?>
<div class="homepage wrapper filler">
    <?php require "components/banner.php"; ?>
    <section class="top products-slider">
        <h2 class="section-title">Топ товари</h2>
        <div class="top__items products-slider__items">
            <?php $topProducts = new WP_Query(['post_type' => 'product', 'posts_per_page' => 10]);
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
            <?php if ($topProducts->have_posts()): while ($topProducts->have_posts()): $topProducts->the_post();
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
    <section class="promo">
        <h2 class="section-title">Акції</h2>
        <div class="promo__items d-flex">
            <?php for ($p = 0; $p < 3; $p++) { ?>
                <a href="#" class="promo__item transition-default d-block">
                    <div class="img-wrapper-cover">
                        <div class="promo__item-text">
                            <h3 class="promo__item-title font-22-26 fw-600">Шалена економія -50%</h3>
                            <p class="promo__item-subtitle font-14-20 fw-500">На будь-який засіб для прання</p>
                        </div>
                    </div>
                </a>
            <?php } ?>
            <a href="#" class="promo__item transition-default d-flex justify-content-center align-items-center">
                <p class="promo__item-all font-15-24 fw-600">Усі акції</p>
                <?php require "components/link-arrow.php"; ?>
            </a>
        </div>
    </section>
    <section class="brands">
        <h2 class="section-title">Бренди</h2>
        <div class="brands__items d-flex flex-wrap">
            <?php for ($b = 0; $b < 11; $b++) {
                require "components/brands-item.php";
            } ?>
            <a href="#" class="brands-item brands__link transition-default d-flex justify-content-center align-items-center">
                <p class="brands__link-all font-15-24 fw-600">Усі бренди</p>
                <?php require "components/link-arrow.php"; ?>
            </a>
        </div>
    </section>
</div>
<?php get_footer();