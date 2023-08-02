<section class="categories">
    <h2 class="section-title">Категорії</h2>
    <div class="categories__items d-flex">
        <?php $categories = get_terms('product_cat', ['parent' => 0, 'hide_empty' => false, 'exclude' => 15, 'orderby' => 'id']);
        foreach ($categories as $cat) {
            $catName = $cat->name;
            $catLink = get_term_link($cat);
            $thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
            $catImage = wp_get_attachment_url( $thumbnail_id );
            $alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true); ?>
            <a href="<?= $catLink; ?>" class="categories__item card-hover transition-default d-flex flex-column">
                <div class="img-wrapper-contain">
                    <img src="<?= $catImage; ?>" alt="<?= $alt; ?>">
                </div>
                <div class="categories__item-title transition-default d-flex justify-content-center align-items-center">
                    <h4 class="font-20-24 fw-600"><?= $catName; ?></h4>
                </div>
            </a>
        <?php } ?>
    </div>
</section>