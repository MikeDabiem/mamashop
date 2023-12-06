<?php /* Template Name: Home Template */
get_header(); ?>
<div class="homepage wrapper filler">
    <?php require "components/banner.php"; ?>
    <button class="header__catalog header__catalog--body std-btn blue-btn font-15-24 fw-600 transition-default">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none"><path stroke-width="2" d="M3.53 7.458c0-1.22 0-1.83.2-2.31A2.617 2.617 0 0 1 5.146 3.73c.481-.2 1.09-.2 2.31-.2s1.83 0 2.311.2c.641.265 1.15.775 1.417 1.416.199.481.199 1.09.199 2.31s0 1.83-.2 2.311a2.618 2.618 0 0 1-1.416 1.416c-.481.2-1.09.2-2.31.2s-1.83 0-2.31-.2A2.617 2.617 0 0 1 3.73 9.768c-.2-.481-.2-1.09-.2-2.31ZM16.618 7.458c0-1.22 0-1.83.2-2.31a2.617 2.617 0 0 1 1.416-1.417c.48-.2 1.09-.2 2.31-.2s1.83 0 2.31.2a2.617 2.617 0 0 1 1.417 1.416c.2.481.2 1.09.2 2.31s0 1.83-.2 2.311a2.617 2.617 0 0 1-1.416 1.416c-.482.2-1.091.2-2.31.2-1.22 0-1.83 0-2.311-.2a2.617 2.617 0 0 1-1.417-1.416c-.2-.481-.2-1.09-.2-2.31ZM3.53 20.545c0-1.22 0-1.83.2-2.31a2.617 2.617 0 0 1 1.416-1.417c.481-.2 1.09-.2 2.31-.2s1.83 0 2.311.2c.641.266 1.15.775 1.417 1.417.199.48.199 1.09.199 2.31s0 1.83-.2 2.31a2.618 2.618 0 0 1-1.416 1.417c-.481.2-1.09.2-2.31.2s-1.83 0-2.31-.2a2.618 2.618 0 0 1-1.417-1.416c-.2-.482-.2-1.091-.2-2.31ZM16.618 20.545c0-1.22 0-1.83.2-2.31a2.617 2.617 0 0 1 1.416-1.417c.48-.2 1.09-.2 2.31-.2s1.83 0 2.31.2a2.617 2.617 0 0 1 1.417 1.417c.2.48.2 1.09.2 2.31s0 1.83-.2 2.31a2.617 2.617 0 0 1-1.416 1.417c-.482.2-1.091.2-2.31.2-1.22 0-1.83 0-2.311-.2a2.617 2.617 0 0 1-1.417-1.416c-.2-.482-.2-1.091-.2-2.31Z"/></svg>
        Каталог
    </button>
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
        <button type="button" class="top__prev products-slider__prev slider-arrow transition-default" aria-label="Попередні товари">
            <svg xmlns="http://www.w3.org/2000/svg" width="9" height="14" fill="none"><path stroke="#363D44" stroke-linecap="round" stroke-width="2" d="M8 13 2 7l6-6"/></svg>
        </button>
        <button type="button" class="top__next products-slider__next slider-arrow transition-default" aria-label="Ще товари">
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
        <button type="button" class="hits__prev products-slider__prev slider-arrow transition-default" aria-label="Попередні товари">
            <svg xmlns="http://www.w3.org/2000/svg" width="9" height="14" fill="none"><path stroke="#363D44" stroke-linecap="round" stroke-width="2" d="M8 13 2 7l6-6"/></svg>
        </button>
        <button type="button" class="hits__next products-slider__next slider-arrow transition-default" aria-label="Ще товари">
            <svg xmlns="http://www.w3.org/2000/svg" width="9" height="14" fill="none"><path stroke="#363D44" stroke-linecap="round" stroke-width="2" d="m1 1 6 6-6 6"/></svg>
        </button>
    </section>
    <?php $promos = new WP_Query(['post_type' => 'promo', 'posts_per_page' => 3]);
    $promos_link = get_field('promos_page', 'options');
    if ($promos->have_posts()): ?>
        <section class="promo">
            <h2 class="section-title">Акції</h2>
            <div class="promo__items">
                <?php while ($promos->have_posts()): $promos->the_post();
                    require 'components/promo-item.php';
                endwhile;
                wp_reset_postdata(); ?>
                <a href="<?= $promos_link; ?>" class="promo__item promo__item__all transition-default d-flex justify-content-center align-items-center">
                    <p class="promo__item__all-text font-15-24 fw-600">Усі акції</p>
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