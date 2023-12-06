<?php $title = get_the_title();
$content = get_the_content();
$id = get_the_ID();
$image = get_the_post_thumbnail_url();
$thumbnail_id = get_post_thumbnail_id($id);
$alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
$link = get_field('promo_url'); ?>
<a href="<?= $link ?>" class="promo__item img-wrapper-cover transition-default">
    <?php if ($image) { ?>
        <img src="<?= $image; ?>" alt="<?= $alt; ?>" loading="lazy">
    <?php } else { ?>
        <img src="<?php bloginfo('template_url'); ?>/images/logo-min.svg" alt="no image" class="no-image" loading="lazy">
    <?php } ?>
    <div class="promo__item__content">
        <h4 class="promo__item-title font-22-26 fw-600"><?= $title; ?></h4>
        <p class="promo__item-text font-14-20 fw-500"><?= $content; ?></p>
    </div>
</a>