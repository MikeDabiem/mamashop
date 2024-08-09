<?php
$id        = $args['id'] ?? get_the_ID();
$title     = get_the_title( $id );
$link      = get_permalink( $id );
$thumb     = get_the_post_thumbnail_url( $id, "medium_large" );
$thumbID   = get_post_thumbnail_id( $id );
$alt       = get_post_meta( $thumbID, '_wp_attachment_image_alt', true );
$rev_count = get_count_of_reviews( $id ) ?: '';
?>
<div class="blog-item transition-default">
    <a href="<?= $link; ?>" class="blog-item__image img-wrapper-cover transition-default d-block" aria-label="Ілюстрація">
		<?php if ( $thumb ) { ?>
            <img src="<?= $thumb; ?>" alt="<?= $alt; ?>">
		<?php } else { ?>
            <img src="<?php bloginfo( 'template_url' ); ?>/images/logo-min.svg" alt="no image" class="no-image">
		<?php } ?>
    </a>
    <?php if (!empty(get_categories())) { ?>
        <div class="blog-item__categories">
            <?php get_template_part('components/category-labels', null, array('id' => $id)); ?>
        </div>
    <?php } ?>
    <a href="<?= $link; ?>" class="blog-item__title font-20-24 fw-500 two-str transition-default" title="<?= $title; ?>"
       aria-label="<?= $title; ?>"><?= $title; ?></a>
    <?php
    if (isset($args['excerpt'])) { ?>
        <div class="blog-item__excerpt">
            <?php the_excerpt(); ?>
        </div>
    <?php } ?>
</div>