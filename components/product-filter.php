<?php if (isset($filters) && $filters->have_posts()): ?>
    <div class="product-filter">
        <button type="button" class="product-filter-clear font-11-13 fw-400">Очистити всі фільтри</button>
        <form class="product-filter__price" type="get">
            <div class="product-filter__spoiler transition-default d-flex justify-content-between align-items-center" data-name="price">
                <h5 class="product-filter__spoiler-title font-14-20 fw-500">Ціна</h5>
                <svg class="transition-default" xmlns="http://www.w3.org/2000/svg" width="13" height="8" fill="none"><path stroke="#3F383A" stroke-width="2" d="m11.3 1.1-5 5-5-5"/></svg>
            </div>
            <div class="product-filter__spoiler__content" data-name="price">
                <?php $getMinPrice = new WP_Query([
                    's' => get_search_query(),
                    'posts_per_page' => 1,
                    'orderby' => 'meta_value_num',
                    'order' => 'ASC',
                    'meta_query' => [['key' => '_price']]
                ]);
                if ($getMinPrice->have_posts()):
                    $minPrice = get_post_meta($getMinPrice->posts[0]->ID, '_price', true);
                endif;
                wp_reset_postdata();
                $getMaxPrice = new WP_Query([
                    's' => get_search_query(),
                    'posts_per_page' => 1,
                    'orderby' => 'meta_value_num',
                    'order' => 'DESC',
                    'meta_query' => [['key' => '_price']]
                ]);
                if ($getMaxPrice->have_posts()):
                    $maxPrice = get_post_meta($getMaxPrice->posts[0]->ID, '_price', true);
                endif;
                wp_reset_postdata();
                if (isset($minPrice) && isset($maxPrice)) { ?>
                    <div class="product-filter__price__inputs d-flex align-items-center">
                        <label for="price-val-min" class="product-filter__price-label font-13-16 fw-500">Від</label>
                        <input type="number" name="price" id="price-val-min" class="product-filter__price-val font-13-16 fw-400">
                        <label for="price-val-max" class="product-filter__price-label font-13-16 fw-500">до</label>
                        <input type="number" name="price" id="price-val-max" class="product-filter__price-val font-13-16 fw-400">
                    </div>
                    <div class="product-filter__price__range">
                        <div class="product-filter__price__range-track"></div>
                        <input type="range" min="<?= $minPrice; ?>" max="<?= $maxPrice; ?>" value="<?= $minPrice; ?>" id="price-range-min">
                        <input type="range" min="<?= $minPrice; ?>" max="<?= $maxPrice; ?>" value="<?= $maxPrice; ?>" id="price-range-max">
                    </div>
                    <button type="button" class="product-filter__price__send font-15-24 fw-600 transition-default">Застосувати</button>
                <?php } ?>
            </div>
        </form>
        <form class="product-filter__filter" type="get">
            <?php require "product-filter-content.php"; ?>
        </form>
    </div>
<?php endif; ?>
