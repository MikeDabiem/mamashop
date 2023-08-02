<?php
    $id = get_the_ID();
    $title = get_the_title();
    $product = wc_get_product();
    $price = $product->get_regular_price();
    $salePrice = $product->get_sale_price();
    $link = get_permalink();
    $thumb = get_the_post_thumbnail_url($id, "medium_large");
    $thumbID = get_post_thumbnail_id($id);
    $alt = get_post_meta($thumbID, '_wp_attachment_image_alt', true);
?>
<div class="product-item card-hover transition-default d-flex flex-column">
    <button class="product-item__heart">
        <svg class="transition-default" xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none"><path stroke-linecap="round" stroke-width="2" d="M22.166 10.24a5.188 5.188 0 0 0-1.336-2.175c-.522-.517-1.063-.859-1.606-1.065m-7.092-2.163c-1.952-1.239-5.106-2.41-7.829.367C-2.162 11.797 8.924 24.5 14 24.5c5.075 0 16.16-12.703 9.696-19.296-2.723-2.777-5.876-1.606-7.829-.367-1.103.7-2.632.7-3.735 0Z"></path></svg>
    </button>
    <a href="<?= $link; ?>" class="product-item__image img-wrapper-contain d-block">
        <?php if($thumb) { ?>
            <img src="<?= $thumb; ?>" alt="<?= $alt; ?>">
        <?php } else { ?>
            <img src="<?php bloginfo('template_url'); ?>/images/eye-slash.svg" alt="no image" class="no-image">
        <?php } ?>
    </a>
    <a href="<?= $link; ?>" class="product-item__title font-14-20 fw-500"><?= $title; ?></a>
    <div class="rating d-flex align-items-center">
        <div class="rating__stars">
            <div class="rating__stars-bg"></div>
            <div class="rating__stars-val"></div>
        </div>
        <span class="rating__value font-13-16 fw-500"><?= rand(1, 999); ?></span>
    </div>
    <div class="product-item__price d-flex">
        <p class="product-item__price-value font-15-24 fw-500"><?= $salePrice ? $salePrice : $price; ?> грн</p>
        <?php if ($salePrice) { ?>
            <p class="product-item__price-disc font-12-16 fw-500"><?= $price; ?> грн</p>
        <?php } ?>
    </div>
    <button type="button" class="product-item__button std-btn font-16-22 fw-600 transition-default d-block">Купити</button>
</div>