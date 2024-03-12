<?php if (isset($filters) && $filters->have_posts()): ?>
    <div class="product-filter">
        <section class="product-filter__mob">
            <div class="product-filter__mob__head">
                <h2 class="product-filter__mob-title section-title text-center">Фільтр</h2>
                <button type="button" class="product-filter__mob-close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                        <path d="M13.6147 1.41643L12.2823 0.0839844L6.99976 5.36653L1.71721 0.0839844L0.384766 1.41643L5.66731 6.69897L0.384766 11.9815L1.71721 13.314L6.99976 8.03142L12.2823 13.314L13.6147 11.9815L8.3322 6.69897L13.6147 1.41643Z" fill="black"/>
                    </svg>
                </button>
            </div>
            <?php require 'product-filter-chosen.php' ?>
        </section>
        <button type="button" class="product-filter-clear font-11-13 fw-400 transition-default">Очистити всі фільтри</button>
        <form class="product-filter__price" type="get">
            <div class="product-filter__spoiler transition-default d-flex justify-content-between align-items-center" data-name="price">
                <h5 class="product-filter__spoiler-title font-14-20 fw-500">Ціна</h5>
                <svg class="transition-default" xmlns="http://www.w3.org/2000/svg" width="13" height="8" fill="none"><path stroke="#3F383A" stroke-width="2" d="m11.3 1.1-5 5-5-5"/></svg>
            </div>
            <div class="product-filter__spoiler__content" data-name="price">
                <?php
                $min_price = 0;
                $max_price = 0;
                while ($filters->have_posts()): $filters->the_post();
                    $price = wc_get_product()->get_price();
                    if (!$min_price || $min_price > $price) {
                        $min_price = $price;
                    }
                    if ($max_price < $price) {
                        $max_price = $price;
                    }
                endwhile;
                if (array_key_exists('price', $_GET)) {
                    $current_prices = wc_clean(explode('-', $_GET['price']));
                }
                if ($min_price && $max_price) { ?>
                    <div class="product-filter__price__inputs d-flex align-items-center">
                        <label for="price-val-min" class="product-filter__price-label font-13-16 fw-500">Від</label>
                        <input type="number" name="price" id="price-val-min" class="product-filter__price-val font-13-16 fw-400">
                        <label for="price-val-max" class="product-filter__price-label font-13-16 fw-500">до</label>
                        <input type="number" name="price" id="price-val-max" class="product-filter__price-val font-13-16 fw-400">
                    </div>
                    <div class="product-filter__price__range">
                        <div class="product-filter__price__range-track"></div>
                        <input type="range" min="<?= $min_price; ?>" max="<?= $max_price; ?>" value="<?php isset($current_prices) ? print $current_prices[0] : print $min_price; ?>" id="price-range-min">
                        <input type="range" min="<?= $min_price; ?>" max="<?= $max_price; ?>" value="<?php isset($current_prices) ? print $current_prices[1] : print $max_price; ?>" id="price-range-max">
                    </div>
                    <button type="button" class="product-filter__price__send pale-purple-btn font-15-24 fw-600 transition-default">Застосувати</button>
                <?php } ?>
            </div>
        </form>
        <form class="product-filter__filter" type="get">
            <?php require "product-filter-attr.php"; ?>
        </form>
    </div>
<?php endif;