<search class="header-search">
    <form role="search" method="get" id="search" name="search" class="header-search__form d-flex" action="<?= home_url('/'); ?>">
        <input type="search" value="<?= get_search_query(); ?>" class="header-search__input font-14-20 transition-default" name="s" placeholder="Я шукаю..." autocomplete="off">
        <button class="header-search__button std-btn purple-btn transition-default font-15-24 fw-600">
            <span>Знайти</span>
            <i><svg xmlns="http://www.w3.org/2000/svg" width="20" height="18" viewBox="0 0 20 18" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.4526 3.71816C9.06429 1.751 5.53346 2.09246 3.5663 4.48081C1.59915 6.86916 1.9406 10.4 4.32895 12.3672C6.71731 14.3343 10.2481 13.9929 12.2153 11.6045C14.1825 9.21615 13.841 5.68531 11.4526 3.71816ZM2.40658 3.52561C4.90127 0.496758 9.37899 0.0637388 12.4078 2.55843C15.2407 4.89172 15.8028 8.95973 13.8226 11.9545L18.9405 16.1699C19.2607 16.4336 19.3065 16.9071 19.0427 17.2273C18.779 17.5476 18.3055 17.5934 17.9853 17.3296L12.8674 13.1143C10.3076 15.6323 6.20686 15.8603 3.37375 13.5269C0.344903 11.0322 -0.0881168 6.55446 2.40658 3.52561Z" fill="white"/></svg></i>
        </button>
        <div class="header-search__menu justify-content-between" style="display: none">
            <div class="header-search__menu__col1">
                <section class="search-try">
                    <h5 class="search-try__title font-13-16 fw-600">Можливо ви шукаєте</h5>
                    <div class="search-try__items"></div>
                </section>
                <section class="search-cat">
                    <h5 class="search-try__title font-13-16 fw-600">Популярні категорії</h5>
                    <?php $home_url = get_home_url(); ?>
                    <a href="<?= $home_url ?>/category/prannja/suhi-poroshki/" class="search-try__item search-try__link font-14-20 fw-400 d-block">Порошки для прання</a>
                    <a href="<?= $home_url ?>/category/prannja/pljamovividniki/" class="search-try__item search-try__link font-14-20 fw-400 d-block">Плямовивідники </a>
                    <a href="<?= $home_url ?>/category/prannja/geli-dla-prannia/" class="search-try__item search-try__link font-14-20 fw-400 d-block">Гелі для прання</a>
                </section>
            </div>
            <section class="header-search__menu__col2 search-popular">
                <div class="search-popular__title font-13-16 fw-600">Популярні товари</div>
                <div class="search-popular__items">
                    <?php $searchProducts = new WP_Query(['post_type' => 'product', 'posts_per_page' => 5]);
                    if ($searchProducts->have_posts()): while ($searchProducts->have_posts()): $searchProducts->the_post();
                        $id = get_the_ID();
                        $title = get_the_title();
                        $product = wc_get_product();
                        $brand = $product->get_attribute('brand');
                        $price = $product->get_regular_price();
                        $salePrice = $product->get_sale_price();
                        $productLink = get_permalink();
                        $thumb = get_the_post_thumbnail_url($id, "medium_large");
                        $thumbID = get_post_thumbnail_id($id);
                        $alt = get_post_meta($thumbID, '_wp_attachment_image_alt', true); ?>
                        <a href="<?= $productLink; ?>" class="search-popular__item d-flex align-items-start">
                            <div class="search-popular__item-image img-wrapper-contain">
                                <?php if ($thumb) { ?>
                                    <img src="<?= $thumb; ?>" alt="<?= $alt; ?>">
                                <?php } else { ?>
                                    <img src="<?php bloginfo("template_url") ?>/images/eye-slash.svg" alt="eye">
                                <?php } ?>
                            </div>
                            <div class="search-popular__item__info">
                                <h6 class="search-popular__item__info-title font-13-16 fw-400"><?= $title; ?></h6>
                                <?php if ($salePrice) { ?>
                                    <div class="search-popular__item__info__disc">
                                        <span class="search-popular__item__info__disc-value font-12-16 fw-400"><?= $price; ?> грн</span>
                                        <span class="search-popular__item__info__disc-perc font-12-16 fw-600">
                                            <?= '-' . get_post_meta($id, '_discount_value', true) . '%' ?>
                                        </span>
                                    </div>
                                <?php } ?>
                                <p class="search-popular__item__info-price font-14-20 fw-500"><?= $salePrice ? $salePrice : $price; ?> грн</p>
                            </div>
                        </a>
                    <?php endwhile; endif;
                    wp_reset_postdata(); ?>
                </div>
            </section>
        </div>
    </form>
</search>