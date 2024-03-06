<div class="catalog-menu header-menu transition-default">
    <div class="catalog__head d-flex justify-content-between position-relative">
        <h4 class="catalog__title font-20-24 fw-600 transition-default">Каталог товарів</h4>
        <button class="catalog__back font-20-24 fw-600 transition-default" aria-label="Повернутись до категорій">
            <svg class="catalog__back-arrow transition-default" xmlns="http://www.w3.org/2000/svg" width="9" height="14" fill="none"><path stroke="#494558" stroke-linecap="round" stroke-width="2" d="m1 1 6 6-6 6"/></svg>
            <h4 class="catalog__back-title font-20-24 fw-600"></h4>
        </button>
        <button class="catalog__close close-menu" aria-label="Закрити меню">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none"><path stroke="#B4ADAD" stroke-width="2" d="m1.367 1.248 12.767 12.767M14.134 1.248 1.367 14.015"/></svg>
        </button>
    </div>
    <div class="catalog__content">
        <div class="catalog__categories transition-default">
            <?php
            $categories = get_terms('product_cat', ['parent' => 0, 'hide_empty' => false, 'exclude' => 15, 'orderby' => 'id']);
            foreach ($categories as $cat) {
                $catName = $cat->name;
                $catLink = get_term_link($cat);
                $thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
                $image = wp_get_attachment_url( $thumbnail_id );
                $alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true); ?>
                <a href="<?= $catLink; ?>" class="catalog__category catalog__category--parent transition-default d-flex align-items-center" data-cat="<?= $cat->term_id; ?>">
                    <div class="catalog__category-image img-wrapper-contain">
                        <img src="<?= $image; ?>" alt="<?= $alt; ?>">
                    </div>
                    <p class="catalog__category-title font-14-20 fw-500"><?= $catName; ?></p>
                    <svg class="catalog__category-arrow transition-default" xmlns="http://www.w3.org/2000/svg" width="9" height="14" fill="none"><path stroke-linecap="round" stroke-width="2" d="m1 1 6 6-6 6"/></svg>
                </a>
            <?php } ?>
        </div>
        <div class="catalog__categories__children transition-default">
            <?php
            foreach ($categories as $cat) {
                $childrenID = get_term_children($cat->term_id, 'product_cat');
                if (!empty($childrenID)) { ?>
                    <div class="catalog__categories__child" data-cat-child="<?= $cat->term_id; ?>">
                        <?php foreach ($childrenID as $childID) {
                            $child = get_term_by('id', $childID, 'product_cat');
                            $childName = $child->name;
                            $childLink = get_term_link($child); ?>
                            <a href="<?= $childLink; ?>" class="catalog__category catalog__category__child-item transition-default d-flex align-items-center">
                                <p class="catalog__category-title font-14-20 fw-500 transition-default"><?= $childName; ?></p>
                            </a>
                        <?php } ?>
                    </div>
                <?php }
            } ?>
        </div>
    </div>
</div>
