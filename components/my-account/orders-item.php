<?php if (isset($args['customer_orders'])) {
    $customer_orders = $args['customer_orders'];
}
foreach ($customer_orders as $customer_order) {
    $order = wc_get_order($customer_order); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
    $order_items = $order->get_items();
    $items_count = count($order_items);
    $order_status = match ($order->get_status()) {
        'processing' => [
            'title' => 'У процесі',
            'class' => 'purple'
        ],
        'completed' => [
            'title' => 'Виконано',
            'class' => 'green'
        ],
        'pending' => [
            'title' => 'Очікує оплати',
            'class' => 'red'
        ],
        'cancelled' => [
            'title' => 'Скасовано',
            'class' => 'red'
        ],
        default => ['title' => $order->get_status(),
            'class' => 'purple'
        ],
    }; ?>
    <div class="account-page__orders__item transition-default">
        <div class="account-page__orders__item__head">
            <p class="item__info__row1 item__info__number font-13-16 fw-400">Замовлення
                №<?= $order->get_order_number(); ?></p>
            <p class="item__info__row1 item__info__date-title font-13-16 fw-400">Дата замовлення</p>
            <p class="item__info__row1 item__info__total-title font-13-16 fw-400">Усього</p>
            <p class="item__info__status font-13-16 fw-400">Статус: <span
                class="<?= $order_status['class']; ?>"><?= $order_status['title']; ?></span></p>
            <time class="item__info__date font-13-16 fw-500"
                datetime="<?php echo esc_attr($order->get_date_created()->date('c')); ?>"><?php echo esc_html(wc_format_datetime($order->get_date_created())); ?></time>
            <p class="item__info__total font-13-16 fw-500"><?= $order->get_total(); ?> грн</p>
            <div class="item__thumbs d-flex align-items-center">
                <p class="item__count<?= $items_count < 4 ? ' --empty' : null; ?> font-12-16 fw-400"><?= $items_count > 3 ? '+' . $items_count - 3 : null; ?></p>
                <?php $items_preview_arr = array_slice($order_items, 0, 3);
                foreach ($items_preview_arr as $item_thumb) {
                    $product_id = $item_thumb->get_product_id();
                    $thumb = get_the_post_thumbnail_url($product_id, "medium");
                    $thumbID = get_post_thumbnail_id($product_id);
                    $alt = get_post_meta($thumbID, '_wp_attachment_image_alt', true); ?>
                    <div class="item__thumbs-image img-wrapper-contain">
                        <?php if ($thumb) { ?>
                            <img src="<?= $thumb; ?>" alt="<?= $alt; ?>">
                        <?php } else { ?>
                            <img src="<?php bloginfo('template_url'); ?>/images/eye-slash.svg" alt="no image" class="no-image">
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
            <div class="item__arrow">
                <svg class="transition-default" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                     viewBox="0 0 20 20" fill="none">
                    <path d="M3.91602 6.95703L10 13.041L16.084 6.95703" stroke="#5E5E62" stroke-width="1.6"
                          stroke-linecap="round"/>
                </svg>
            </div>
        </div>
        <div class="account-page__orders__item__body">
            <div class="item__products">
                <?php foreach ($order_items as $order_item) {
                    $product_id = $order_item->get_product_id();
                    $product = $order_item->get_product();
                    $link = get_permalink($product_id);
                    $thumb = get_the_post_thumbnail_url($product_id, "medium");
                    $thumbID = get_post_thumbnail_id($product_id);
                    $alt = get_post_meta($thumbID, '_wp_attachment_image_alt', true); ?>
                    <div data-id="prod-<?= $product_id ?>" class="item__product">
                        <a href="<?= $link ?>" class="item__product-image img-wrapper-contain d-block">
                            <?php if ($thumb) { ?>
                                <img src="<?= $thumb; ?>" alt="<?= $alt; ?>">
                            <?php } else { ?>
                                <img src="<?php bloginfo('template_url'); ?>/images/eye-slash.svg" alt="no image" class="no-image">
                            <?php } ?>
                        </a>
                        <div class="item__product__info">
                            <?php $brand_name = $product->get_attribute('pa_brand');
                            $brand_link = wc_get_page_permalink('shop') . '?pa_brand=' . get_term_by('name', $brand_name, 'pa_brand')->slug; ?>
                            <a href="<?= $link ?>" class="item__product__info-title font-14-20 fw-500 transition-default d-block"><?= get_the_title($product_id); ?></a>
                            <a href="<?= $brand_link ?>" class="item__product__info-subtitle font-14-20 fw-500 transition-default d-block"><?= $brand_name ?></a>
                        </div>
                        <div class="item__product__price">
                            <p class="font-14-20 fw-500"><?= $product->get_price(); ?> грн</p>
                        </div>
                        <div class="item__product__qty">
                            <p class="font-14-20 fw-500"><?= $order_item->get_quantity(); ?> шт.</p>
                        </div>
                        <div class="item__product__total">
                            <p class="font-14-20 fw-500"><?= $order_item->get_total(); ?> грн</p>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="item__footer">
                <div class="item__footer__totals">
                    <p class="totals-qty font-14-20 fw-400"><?= $items_count . ' ' . true_wordform($items_count, 'товар', 'товари', 'товарів') ?> на суму</p>
                    <p class="totals-price font-16-22 fw-500"><?= $order->get_total(); ?> грн</p>
                </div>
                <button class="order-repeat std-btn purple-btn font-16-22 fw-600">Повторити замовлення</button>
            </div>
        </div>
    </div>
<?php }