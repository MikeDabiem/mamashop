<?php if (isset($args['review'])) {
    $review = $args['review'];
} ?>
<div class="account-page__reviews__item">
    <?php $product_id = $review->comment_post_ID;
    $title = get_the_title($product_id);
    $link = get_permalink($product_id);
    $product = wc_get_product($product_id);
    $brand = $product->get_attribute('pa_brand');
    $brand_slug = wc_get_product_terms($product_id, 'pa_brand')[0]->slug;
    ?>
    <div class="account-page__reviews__item__product">
        <a  href="<?= $link; ?>" class="product__image img-wrapper-contain d-block">
            <?php $thumb = get_the_post_thumbnail_url($product_id, "medium");
            if ($thumb) {
                $thumb_id = get_post_thumbnail_id($product_id);
                $alt = get_post_meta($thumb_id, '_wp_attachment_image_alt', true); ?>
                <img src="<?= $thumb; ?>" alt="<?= $alt; ?>">
            <?php } else { ?>
                <img src="<?php bloginfo('template_url'); ?>/images/logo-min.svg" alt="no image" class="no-image">
            <?php } ?>
        </a>
        <a href="<?= $link; ?>" class="product__title font-13-16 fw-400 transition-default text-decoration-none"><?= $title; ?></a>
        <a href="<?= wc_get_page_permalink('shop') . '?pa_brand=' . $brand_slug ?>" class="product__brand font-13-16 fw-400 transition-default text-decoration-none"><?= $brand; ?></a>
    </div>
    <?php get_template_part('components/questions-item', null, ['question' => $review, 'prod_id' => $product_id]); ?>
</div>
