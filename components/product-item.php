<?php
    $id = get_the_ID();
    $title = get_the_title();
    $product = wc_get_product();
    $rating = get_product_rating($product);
    $price = $product->get_regular_price();
    $salePrice = $product->get_sale_price();
    $link = get_permalink();
    $thumb = get_the_post_thumbnail_url($id, "medium_large");
    $thumbID = get_post_thumbnail_id($id);
    $alt = get_post_meta($thumbID, '_wp_attachment_image_alt', true);
    $rev_count = get_count_of_reviews($id) ?: '';
?>
<div class="product-item card-hover transition-default">
    <?php $fav_btn_classes = 'product-item__heart';
    require 'fav-button.php'; ?>
    <a href="<?= $link; ?>" class="product-item__image img-wrapper-contain d-block" aria-label="Фото товару">
        <?php if($thumb) { ?>
            <img src="<?= $thumb; ?>" alt="<?= $alt; ?>">
        <?php } else { ?>
            <img src="<?php bloginfo('template_url'); ?>/images/logo-min.svg" alt="no image" class="no-image">
        <?php } ?>
    </a>
    <a href="<?= $link; ?>" class="product-item__title font-14-20 fw-500 two-str" title="<?= $title; ?>" aria-label="<?= $title; ?>"><?= $title; ?></a>
    <div class="rating d-flex align-items-center">
        <div class="rating__stars">
            <div class="rating__stars-bg"></div>
            <div class="rating__stars-val"></div>
            <p class="rating-value d-none"><?= $rating ?></p>
        </div>
        <span class="rating__value font-13-16 fw-500"><?= $rev_count ?></span>
    </div>
    <div class="product-item__price d-flex">
        <p class="product-item__price-value font-15-24 fw-500"><?= $salePrice ?: $price; ?> грн</p>
        <?php if ($salePrice) { ?>
            <p class="product-item__price-disc font-12-16 fw-500"><?= $price; ?> грн</p>
        <?php } ?>
    </div>
    <?php require 'buy-button.php'; ?>
</div>