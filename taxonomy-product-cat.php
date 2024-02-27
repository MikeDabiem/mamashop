<?php get_header(); ?>
<section class="category-page wrapper filler">
    <?php
    woocommerce_breadcrumb();
    $term_id = get_term_by('slug', get_query_var('product_cat'), 'product_cat')->term_id;
    $term_children = get_term_children($term_id, 'product_cat');
    $title_class = empty($term_children) ? '' : ' subcategory-title';
    $products_count = wc_get_loop_prop('total');
    ?>
    <h1 class="section-title<?= $title_class ?>"><?php woocommerce_page_title(); ?></h1>
    <p class="products-count font-14-20 fw-400"><?= $products_count . ' ' . true_wordform($products_count, 'товар', 'товари', 'товарів') ?></p>
    <?php if (!empty($term_children)) { ?>
        <div class="subcategory__items d-flex flex-wrap">
            <?php foreach ($term_children as $term_child_id) { ?>
                <a href="<?= get_term_link($term_child_id); ?>" class="subcategory__item card-hover transition-default d-block">
                    <h4 class="subcategory__item-title font-18-22 fw-600"><?= get_term($term_child_id)->name; ?></h4>
                </a>
            <?php } ?>
        </div>
    <?php
    } else {
        require "components/banner.php";
    }
    ?>
    <button class="header__catalog header__catalog--body std-btn blue-btn font-15-24 fw-600 transition-default">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none"><path stroke-width="2" d="M3.53 7.458c0-1.22 0-1.83.2-2.31A2.617 2.617 0 0 1 5.146 3.73c.481-.2 1.09-.2 2.31-.2s1.83 0 2.311.2c.641.265 1.15.775 1.417 1.416.199.481.199 1.09.199 2.31s0 1.83-.2 2.311a2.618 2.618 0 0 1-1.416 1.416c-.481.2-1.09.2-2.31.2s-1.83 0-2.31-.2A2.617 2.617 0 0 1 3.73 9.768c-.2-.481-.2-1.09-.2-2.31ZM16.618 7.458c0-1.22 0-1.83.2-2.31a2.617 2.617 0 0 1 1.416-1.417c.48-.2 1.09-.2 2.31-.2s1.83 0 2.31.2a2.617 2.617 0 0 1 1.417 1.416c.2.481.2 1.09.2 2.31s0 1.83-.2 2.311a2.617 2.617 0 0 1-1.416 1.416c-.482.2-1.091.2-2.31.2-1.22 0-1.83 0-2.311-.2a2.617 2.617 0 0 1-1.417-1.416c-.2-.481-.2-1.09-.2-2.31ZM3.53 20.545c0-1.22 0-1.83.2-2.31a2.617 2.617 0 0 1 1.416-1.417c.481-.2 1.09-.2 2.31-.2s1.83 0 2.311.2c.641.266 1.15.775 1.417 1.417.199.48.199 1.09.199 2.31s0 1.83-.2 2.31a2.618 2.618 0 0 1-1.416 1.417c-.481.2-1.09.2-2.31.2s-1.83 0-2.31-.2a2.618 2.618 0 0 1-1.417-1.416c-.2-.482-.2-1.091-.2-2.31ZM16.618 20.545c0-1.22 0-1.83.2-2.31a2.617 2.617 0 0 1 1.416-1.417c.48-.2 1.09-.2 2.31-.2s1.83 0 2.31.2a2.617 2.617 0 0 1 1.417 1.417c.2.48.2 1.09.2 2.31s0 1.83-.2 2.31a2.617 2.617 0 0 1-1.416 1.417c-.482.2-1.091.2-2.31.2-1.22 0-1.83 0-2.311-.2a2.617 2.617 0 0 1-1.417-1.416c-.2-.482-.2-1.091-.2-2.31Z"/></svg>
        Каталог
    </button>
    <?php if (!empty($term_children)) { ?>
        <h2 class="cat-products section-title">Товари з цієї категорії</h2>
    <?php }
    $search = fetch_data(16);
    if ($search->have_posts()): ?>
        <?php require 'shop.php';
    endif;
    wp_reset_postdata();
    ?>
</section>
<?php get_footer();