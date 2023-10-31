<?php get_header(); ?>
<section class="category-page wrapper filler">
    <?php woocommerce_breadcrumb(); ?>
    <h1 class="section-title"><?php woocommerce_page_title(); ?></h1>
    <?php $term_id = get_term_by('slug', get_query_var('product_cat'), 'product_cat')->term_id;
    $term_children = get_term_children($term_id, 'product_cat');
    if (!empty($term_children)) { ?>
        <div class="subcategory__items d-flex flex-wrap">
            <?php foreach ($term_children as $term_child_id) { ?>
                <a href="<?= get_term_link($term_child_id); ?>" class="subcategory__item card-hover transition-default d-block">
                    <?php $thumb_id = get_term_meta($term_child_id, 'thumbnail_id', true);
                    $thumb_id = $thumb_id ?: get_term_meta($term_id, 'thumbnail_id', true);
                    $term_img = wp_get_attachment_url($thumb_id);
                    $alt = get_post_meta($thumb_id, '_wp_attachment_image_alt', true); ?>
                    <div class="subcategory__item-image img-wrapper-contain">
                        <img src="<?= $term_img; ?>" alt="<?= $alt; ?>">
                    </div>
                    <h4 class="subcategory__item-title font-18-22 fw-600"><?= get_term($term_child_id)->name; ?></h4>
                </a>
            <?php } ?>
        </div>
        <?php $topProducts = new WP_Query([
            'post_type' => 'product',
            'posts_per_page' => 10,
            'orderby' => 'meta_value_num',
            'order' => 'DESC',
            'meta_key' => '_wc_average_rating',
            'tax_query' => [
                [
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => get_query_var('product_cat')
                ]
            ]
        ]);
        if ($topProducts->have_posts()): ?>
            <section class="top products-slider">
                <h2 class="section-title">Топ товари з цієї категорії</h2>
                <div class="top__items products-slider__items">
                    <?php while ($topProducts->have_posts()): $topProducts->the_post();
                        require "components/product-item.php";
                    endwhile; ?>
                </div>
                <button type="button" class="top__prev products-slider__prev slider-arrow transition-default">
                    <svg xmlns="http://www.w3.org/2000/svg" width="9" height="14" fill="none"><path stroke="#363D44" stroke-linecap="round" stroke-width="2" d="M8 13 2 7l6-6"/></svg>
                </button>
                <button type="button" class="top__next products-slider__next slider-arrow transition-default">
                    <svg xmlns="http://www.w3.org/2000/svg" width="9" height="14" fill="none"><path stroke="#363D44" stroke-linecap="round" stroke-width="2" d="m1 1 6 6-6 6"/></svg>
                </button>
            </section>
        <?php endif;
        wp_reset_postdata();
    } else { ?>
        <?php $search = fetch_data(16);
        if ($search->have_posts()):
            $products_count = wc_get_loop_prop('total'); ?>
            <p class="products-count font-14-20 fw-400"><?= $products_count . ' ' . true_wordform($products_count, 'товар', 'товари', 'товарів') ?></p>
            <?php require "components/banner.php"; ?>
            <button class="header__catalog header__catalog--body std-btn blue-btn font-15-24 fw-600 transition-default">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none"><path stroke-width="2" d="M3.53 7.458c0-1.22 0-1.83.2-2.31A2.617 2.617 0 0 1 5.146 3.73c.481-.2 1.09-.2 2.31-.2s1.83 0 2.311.2c.641.265 1.15.775 1.417 1.416.199.481.199 1.09.199 2.31s0 1.83-.2 2.311a2.618 2.618 0 0 1-1.416 1.416c-.481.2-1.09.2-2.31.2s-1.83 0-2.31-.2A2.617 2.617 0 0 1 3.73 9.768c-.2-.481-.2-1.09-.2-2.31ZM16.618 7.458c0-1.22 0-1.83.2-2.31a2.617 2.617 0 0 1 1.416-1.417c.48-.2 1.09-.2 2.31-.2s1.83 0 2.31.2a2.617 2.617 0 0 1 1.417 1.416c.2.481.2 1.09.2 2.31s0 1.83-.2 2.311a2.617 2.617 0 0 1-1.416 1.416c-.482.2-1.091.2-2.31.2-1.22 0-1.83 0-2.311-.2a2.617 2.617 0 0 1-1.417-1.416c-.2-.481-.2-1.09-.2-2.31ZM3.53 20.545c0-1.22 0-1.83.2-2.31a2.617 2.617 0 0 1 1.416-1.417c.481-.2 1.09-.2 2.31-.2s1.83 0 2.311.2c.641.266 1.15.775 1.417 1.417.199.48.199 1.09.199 2.31s0 1.83-.2 2.31a2.618 2.618 0 0 1-1.416 1.417c-.481.2-1.09.2-2.31.2s-1.83 0-2.31-.2a2.618 2.618 0 0 1-1.417-1.416c-.2-.482-.2-1.091-.2-2.31ZM16.618 20.545c0-1.22 0-1.83.2-2.31a2.617 2.617 0 0 1 1.416-1.417c.48-.2 1.09-.2 2.31-.2s1.83 0 2.31.2a2.617 2.617 0 0 1 1.417 1.417c.2.48.2 1.09.2 2.31s0 1.83-.2 2.31a2.617 2.617 0 0 1-1.416 1.417c-.482.2-1.091.2-2.31.2-1.22 0-1.83 0-2.311-.2a2.617 2.617 0 0 1-1.417-1.416c-.2-.482-.2-1.091-.2-2.31Z"/></svg>
                Каталог
            </button>
            <?php require 'shop.php';
        endif;
        wp_reset_postdata();
    } ?>
</section>
<?php get_footer();