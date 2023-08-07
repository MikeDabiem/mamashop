<form role="search" method="get" id="search" name="search" class="header-search d-flex" action="<?= home_url('/'); ?>">
    <input type="search" value="<?= get_search_query(); ?>" class="header-search__input font-14-20" name="s" placeholder="Я шукаю..." autocomplete="off">
    <button class="header-search__button std-btn purple-btn transition-default font-15-24 fw-600">Знайти</button>
    <div class="header-search__menu justify-content-between" style="display: none">
        <div class="header-search__menu__col1">
            <section class="search-try">
                <h5 class="search-try__title font-13-16 fw-600">Можливо ви шукаєте</h5>
                <div class="search-try__items"></div>
            </section>
            <section class="search-cat">
                <h5 class="search-try__title font-13-16 fw-600">Популярні категорії</h5>
                <a href="#" class="search-try__item search-try__link font-14-20 fw-400 d-block">Порошки для прання</a>
                <a href="#" class="search-try__item search-try__link font-14-20 fw-400 d-block">Засоби для миття посуду </a>
                <a href="#" class="search-try__item search-try__link font-14-20 fw-400 d-block">Порошки для підлоги</a>
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
                    $brand = $product->get_attribute('brend');
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
                <?php endwhile; endif; ?>
            </div>
        </section>
    </div>
</form>