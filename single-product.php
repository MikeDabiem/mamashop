<?php get_header();
the_post();
$id = get_the_ID();
$product = wc_get_product();
$price = $product->get_regular_price();
$salePrice = $product->get_sale_price();
?>
<div class="single-product-page wrapper filler">
    <div class="breadcrumbs font-11-13 fw-400">
        <?php if ( function_exists('yoast_breadcrumb') ) {
            yoast_breadcrumb();
        } ?>
    </div>
    <main class="single-product__info">
        <div class="info__main d-flex justify-content-between">
            <div class="info__main__col1">
                <div class="single-product-image img-wrapper-contain">
                    <?php
                    $thumb = get_the_post_thumbnail_url($id, "medium_large");
                    $thumb_id = get_post_thumbnail_id($id);
                    $alt = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);
                    $gallery_ids = $product->get_gallery_image_ids(); ?>
                    <img src="<?= $thumb; ?>" alt="<?= $alt; ?>">
                    <?php
//                    if (!empty($gallery_ids)) {
//                        foreach($gallery_ids as $gallery_id) {
//                            $image_link = wp_get_attachment_url($gallery_id);
//                            print_r($gallery_id);
//                            echo $image_html = wp_get_attachment_image($gallery_id, 'thumbnail');
//                        }
//                    }



//                    $columns = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
//                    $post_thumbnail_id = $product->get_image_id();
//                    $wrapper_classes   = apply_filters(
//                    'woocommerce_single_product_image_gallery_classes',
//                    array(
//                    'woocommerce-product-gallery',
//                    'woocommerce-product-gallery--' . ( $post_thumbnail_id ? 'with-images' : 'without-images' ),
//                    'woocommerce-product-gallery--columns-' . absint( $columns ),
//                    'images',
//                    )
//                    );
                    ?>
<!--                    <div class="--><?php //echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?><!--" data-columns="--><?php //echo esc_attr( $columns ); ?><!--" style="opacity: 0; transition: opacity .25s ease-in-out;">-->
<!--                        <figure class="woocommerce-product-gallery__wrapper">-->
<!--                            --><?php
//                            if ( $post_thumbnail_id ) {
//                                $html = wc_get_gallery_image_html( $post_thumbnail_id, true );
//                            } else {
//                                $html  = '<div class="woocommerce-product-gallery__image--placeholder">';
//                                $html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'woocommerce' ) );
//                                $html .= '</div>';
//                            }
//                            echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id );
//                            do_action( 'woocommerce_product_thumbnails' );
//                            ?>
<!--                        </figure>-->
<!--                    </div>-->
                </div>
            </div>
            <div class="info__main__col2">
                <h1 class="info__main-title"><?= get_the_title(); ?></h1>
                <?php if ($product->is_in_stock()) { ?>
                    <p class="info__main-in-stock font-13-16 fw-400">В наявності</p>
                <?php } else { ?>
                    <p class="info__main-out-stock font-13-16 fw-400">Немає в наявності</p>
                <?php } ?>
                <div class="info__main__price d-flex">
                    <p class="info__main__price-value font-18-22 fw-500"><?= $salePrice ? $salePrice : $price; ?> грн</p>
                    <?php if ($salePrice) { ?>
                        <p class="info__main__price-disc font-13-16 fw-400 text-decoration-line-through"><?= $price; ?> грн</p>
                    <?php } ?>
                </div>
                <div class="info__main__buttons d-flex">
                    <button class="info__main__add-to-cart">Купити</button>
                    <button class="header__fav header__btn std-btn d-flex justify-content-center align-items-center transition-default">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none"><path stroke-linecap="round" stroke-width="2" d="M22.166 10.24a5.188 5.188 0 0 0-1.336-2.175c-.522-.517-1.063-.859-1.606-1.065m-7.092-2.163c-1.952-1.239-5.106-2.41-7.829.367C-2.162 11.797 8.924 24.5 14 24.5c5.075 0 16.16-12.703 9.696-19.296-2.723-2.777-5.876-1.606-7.829-.367-1.103.7-2.632.7-3.735 0Z"/></svg>
                    </button>
                </div>
                <h4 class="info__main__specs-title font-16-22 fw-500">Характеристики:</h4>
                <?php $attributes = $product->get_attributes();
                foreach ($attributes as $attribute) {
                    $attr_id = $attribute->get_id();
                    $attr_name = wc_get_attribute($attr_id)->name; ?>
                    <p class="info__main__specs__item">
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
        <div class="info__advanced d-flex justify-content-between align-items-start">
            <div class="info__advanced__col1">
                <div class="info__advanced__col1__heading">
                    <button id="about" class="info__advanced__col1__heading-button active">Про товар</button>
                    <button id="reviews" class="info__advanced__col1__heading-button">Відгуки</button>
                    <button id="questions" class="info__advanced__col1__heading-button">Питання</button>
                </div>
                <div class="info__advanced__description active">
                    <h3 class="info__advanced__description-title">Опис:</h3>
                    <p class="info__advanced__description-text"><?= $product->get_description(); ?></p>
                    <h3 class="info__advanced__description-title">Спосіб застосування:</h3>
                    <p class="info__advanced__description-text"><?= $product->get_short_description(); ?></p>
                </div>
            </div>
            <div class="info__advanced__col2 info__rating">
                <h2 class="info__rating-title">4.9</h2>
                <p class="info__rating-subtitle font-16-22">Рейтинг товару</p>
                <div class="rating__stars">
                    <div class="rating__stars-bg"></div>
                    <div class="rating__stars-val"></div>
                </div>
                <div class="info__rating__percents d-flex align-items-center">
                    <p class="info__rating__percents-value">98%</p>
                    <p class="info__rating__percents-text font-14-20 fw-400">покупців рекомендують цей товар</p>
                </div>
                <button class="info__rating-make-review">Залишити відгук</button>
                <button class="info__rating-make-question">Запитати</button>
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