<?php
$id = get_the_ID();
$title = get_the_title();
$product = wc_get_product();
$price = $product->get_regular_price();
$salePrice = $product->get_sale_price();
$productLink = get_permalink();
$thumb = get_the_post_thumbnail_url($id, "medium_large");
$thumbID = get_post_thumbnail_id($id);
$alt = get_post_meta($thumbID, '_wp_attachment_image_alt', true); ?>
<a href="<?= $productLink; ?>" class="search-popular__item d-flex">
    <div class="search-popular__item-image img-wrapper-contain">
        <?php if ($thumb) { ?>
            <img src="<?= $thumb; ?>" alt="<?= $alt; ?>">
        <?php } else { ?>
            <img src="<?php bloginfo("template_url") ?>/images/logo-min.svg" class="no-image" alt="no image">
        <?php } ?>
    </div>
    <div class="search-popular__item__info">
        <h6 class="search-popular__item__info-title font-13-16 fw-400 two-str"><?= $title; ?></h6>
        <?php if ($salePrice) { ?>
            <div class="search-popular__item__info__disc">
                <span class="search-popular__item__info__disc-value font-12-16 fw-400"><?= $price; ?> грн</span>
                <span class="search-popular__item__info__disc-perc font-12-16 fw-600">
                    <?= '-' . get_post_meta($id, '_discount_value', true) . '%' ?>
                </span>
            </div>
        <?php } ?>
        <p class="search-popular__item__info-price font-14-20 fw-500"><?= $salePrice ?: $price; ?> грн</p>
    </div>
</a>