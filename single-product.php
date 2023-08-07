<?php get_header();
the_post();
$id = get_the_ID();
$product = wc_get_product();
$price = $product->get_regular_price();
$sale_price = $product->get_sale_price();
$sale_val = get_post_meta($id, '_discount_value', true);
?>
<div class="single-product-page wrapper filler">
    <?php woocommerce_breadcrumb(); ?>
    <main class="single-product__info">
        <div class="info__main d-flex justify-content-between">
            <div class="info__main__col1">
                <div class="single-product__image">
                    <?php if ($sale_val) { ?>
                        <span class="sale-val font-16-22 fw-600">-<?= $sale_val; ?>%</span>
                    <?php } ?>
                    <div class="single-product__image-main img-wrapper-contain">
                        <?php
                        $thumb = get_the_post_thumbnail_url($id, "medium_large");
                        if ($thumb) {
                            $thumb_id = get_post_thumbnail_id($id);
                            $alt = get_post_meta($thumb_id, '_wp_attachment_image_alt', true); ?>
                            <img src="<?= $thumb; ?>" alt="<?= $alt; ?>">
                        <?php } else { ?>
                            <img src="<?php bloginfo('template_url'); ?>/images/eye-slash.svg" alt="no image" class="no-image">
                        <?php } ?>
                    </div>
                    <?php if ($thumb) {
                        $gallery_ids = $product->get_gallery_image_ids();
                        if (!empty($gallery_ids)) { ?>
                            <div class="single-product__image__gallery d-flex">
                                <img class="single-product__image-main--mini transition-default d-none" src="<?= $thumb; ?>" alt="<?= $alt; ?>">
                                <?php foreach($gallery_ids as $gallery_id) {
                                    $image_link = wp_get_attachment_url($gallery_id);
                                    $image_alt = get_post_meta($gallery_id, '_wp_attachment_image_alt', TRUE); ?>
                                    <img class="transition-default" src="<?= $image_link; ?>" alt="<?= $image_alt; ?>">
                                <?php } ?>
                            </div>
                        <?php }
                    } ?>
                </div>
            </div>
            <div class="info__main__col2">
                <h1 class="info__main-title font-32-45 fw-600"><?= get_the_title(); ?></h1>
                <div class="info__main-subtitle d-flex justify-content-between">
                    <div class="rating d-flex align-items-center">
                        <div class="rating__stars">
                            <div class="rating__stars-bg"></div>
                            <div class="rating__stars-val"></div>
                        </div>
                        <span class="rating__value font-13-16 fw-400"><?php
                            echo $rev_count = rand(1, 999);
                            echo ' ';
                            echo true_wordform($rev_count, 'Відгук', 'Відгуки', 'Відгуків');
                        ?></span>
                    </div>
                    <p class="sku font-13-16 fw-400"><span>Артикул: </span><?= $product->get_sku(); ?></p>
                </div>
                <?php if ($product->is_in_stock()) { ?>
                    <p class="info__main-in-stock font-13-16 fw-400">В наявності</p>
                <?php } else { ?>
                    <p class="info__main-out-stock font-13-16 fw-400">Немає в наявності</p>
                <?php } ?>
                <div class="info__main__price d-flex">
                    <p class="info__main__price-value font-18-22 fw-500"><?= $sale_price ? $sale_price : $price; ?> грн</p>
                    <?php if ($sale_price) { ?>
                        <p class="info__main__price-disc font-13-16 fw-400 text-decoration-line-through"><?= $price; ?> грн</p>
                    <?php } ?>
                </div>
                <div class="info__main__buttons d-flex">
                    <?php if ($product->is_in_stock()) { ?>
                        <button class="info__main__buy-btn std-btn purple-btn font-16-22 fw-600 transition-default">Купити</button>
                    <?php } else { ?>
                        <button class="info__main__buy-btn std-btn purple-btn font-16-22 fw-600 transition-default">Повідомити про появу</button>
                    <?php } ?>
                    <button class="single-product-fav std-btn d-flex justify-content-center align-items-center transition-default">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none"><path stroke-linecap="round" stroke-width="2" d="M22.166 10.24a5.188 5.188 0 0 0-1.336-2.175c-.522-.517-1.063-.859-1.606-1.065m-7.092-2.163c-1.952-1.239-5.106-2.41-7.829.367C-2.162 11.797 8.924 24.5 14 24.5c5.075 0 16.16-12.703 9.696-19.296-2.723-2.777-5.876-1.606-7.829-.367-1.103.7-2.632.7-3.735 0Z"/></svg>
                    </button>
                </div>
                <h4 class="info__main__specs-title font-16-22 fw-500">Характеристики:</h4>
                <div class="info__main__specs__items">
                    <?php $attributes = $product->get_attributes();
                    foreach ($attributes as $attribute) {
                        $attr_id = $attribute->get_id();
                        $attr_name = wc_get_attribute($attr_id)->name; ?>
                        <p class="info__main__specs__item font-13-16 fw-400">
                            <span class="info__main__specs__item-title"><?= $attr_name; ?>: </span>
                            <?php foreach ($attribute['options'] as $option_id) {
                                $term_name = get_term($option_id)->name;
                                $term_slug = get_term($option_id)->slug;
                                $term_tax = get_term($option_id)->taxonomy; ?>
                                <a href="<?= site_url(); ?>/?s&<?= $term_tax . '=' . $term_slug ?>" class="info__main__specs__item-value"><?= $term_name; ?></a>
                            <?php } ?>
                        </p>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="info__advanced d-flex justify-content-between align-items-start">
            <div class="info__advanced__col1">
                <div class="info__advanced__col1__heading d-flex">
                    <button id="about" class="tab-button active font-14-20 fw-500 transition-default">Про товар</button>
                    <button id="reviews" class="tab-button font-14-20 fw-500 transition-default">Відгуки</button>
                    <button id="questions" class="tab-button font-14-20 fw-500 transition-default">Питання</button>
                    <div class="tab-button--border transition-default"></div>
                </div>
                <div class="info__advanced__description active">
                    <?php $description = $product->get_description();
                    $how_to_use = $product->get_short_description();
                    if ($description || $how_to_use) {
                        if ($description) { ?>
                            <h3 class="info__advanced__description-title font-18-22 fw-500">Опис:</h3>
                            <p class="info__advanced__description-text font-13-16 fw-400"><?= $description; ?></p>
                        <?php }
                        if ($how_to_use) { ?>
                            <h3 class="info__advanced__description-title font-18-22 fw-500">Спосіб застосування:</h3>
                            <p class="info__advanced__description-text font-13-16 fw-400"><?= $how_to_use; ?></p>
                        <?php }
                    } else { ?>
                        <div class="no-info__image img-wrapper-cover">
                            <img src="<?php bloginfo('template_url'); ?>/images/noinfo.png" alt="no info">
                        </div>
                        <h3 class="no-info__title font-20-24 fw-600 text-center">Нажаль більш детальної інформації по цьому товару немає</h3>
                    <?php } ?>
                </div>
            </div>
            <div class="info__advanced__col2 info__rating">
                <h2 class="info__rating-title font-36-44 fw-500">4.9</h2>
                <p class="info__rating-subtitle font-16-22 fw-400">Рейтинг товару</p>
                <div class="rating__stars">
                    <div class="rating__stars-bg"></div>
                    <div class="rating__stars-val"></div>
                </div>
                <div class="info__rating__percents d-flex justify-content-center align-items-center">
                    <p class="info__rating__percents-value fw-500">98%</p>
                    <p class="info__rating__percents-text font-14-20 fw-400">покупців рекомендують цей товар</p>
                </div>
                <button class="info__advanced-make-review std-btn purple-btn font-16-22 fw-600">Залишити відгук</button>
                <button class="info__advanced-make-question std-btn pale-purple-btn font-16-22 fw-600">Запитати</button>
            </div>
        </div>
    </main>
    <section class="top products-slider">
        <h2 class="section-title">Вас також можуть зацікавити</h2>
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
</div>
<?php get_footer();