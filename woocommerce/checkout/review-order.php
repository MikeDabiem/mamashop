<?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

defined( 'ABSPATH' ) || exit;
do_action( 'woocommerce_checkout_before_order_review' ); ?>

<section class="checkout-page__section checkout-page__products">
    <div class="checkout-page__section__head d-flex justify-content-between">
        <h4 class="checkout-page__section-title font-18-22 fw-500 d-flex align-items-center"><span class="font-14-20 fw-500 d-flex justify-content-center align-items-center">2</span>Товари для оформлення</h4>
        <button type="button" class="checkout-change-button transparent-btn font-14-20 fw-500">Переглянути</button>
    </div>
    <section class="checkout-page__section__body products__body">
        <h4 class="products__list-title font-15-24 fw-600">Ваше замовлення</h4>
        <div class="products__list">
            <div class="products__list__head font-12-16 fw-400">
                <p class="list-name">Товар</p>
                <p class="list-col text-end">Вартість</p>
                <p class="list-col text-end">Кількість</p>
                <p class="list-col text-end">Сума</p>
            </div>

            <?php do_action( 'woocommerce_review_order_before_cart_contents' ); ?>

            <div class="products__list__body">
                <?php $prod_num = 1;
                foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                    $id = $cart_item['data']->id;
                    $product = wc_get_product($id);
                    $product_url = get_permalink($id);
                    $name = $cart_item['data']->name;
                    $brand = $product->get_attribute('pa_brand');
                    $quantity = $cart_item['quantity'];
                    $price = $cart_item['data']->regular_price;
                    $sale_price = $cart_item['data']->sale_price;
                    $sale_val = get_post_meta($id, '_discount_value', true);
                    $image_id = $cart_item['data']->image_id;
                    $image_url = wp_get_attachment_image_url($image_id);
                    $alt = get_post_meta($image_id, '_wp_attachment_image_alt', true); ?>
                    <div class="products__list__item font-13-16 fw-500">
                        <p class="products__list__item-count"><?= $prod_num; ?></p>
                        <div class="products__list__item-info d-flex align-items-center">
                            <div class="products__list__item-image img-wrapper-contain">
                                <?php if ($image_url) { ?>
                                    <img src="<?= $image_url; ?>" alt="<?= $alt; ?>">
                                <?php } else { ?>
                                    <img src="<?php bloginfo('template_url'); ?>/images/logo-min.svg" alt="no image">
                                <?php } ?>
                            </div>
                            <div class="products__list__item__text">
                                <p class="products__list__item-name"><?= $name; ?></p>
                                <p class="products__list__item-brand font-12-16"><?= $brand; ?></p>
                            </div>
                        </div>
                        <p class="text-end"><?= $sale_price ?: $price; ?> грн</p>
                        <p class="text-end products__list__item-qty"><?= $quantity; ?> шт.</p>
                        <p class="text-end products__list__item-eq"><?= $sale_price ? $sale_price * $quantity : $price * $quantity; ?> грн</p>
                    </div>
                    <?php $prod_num++;
                } ?>
            </div>

            <?php do_action( 'woocommerce_review_order_after_cart_contents' ); ?>

        </div>
        <button type="button" class="checkout-next-button std-btn purple-btn font-15-24 fw-600">Продовжити</button>
    </section>
</section>
<section class="checkout-page__section checkout-page__delivery">
    <div class="checkout-page__section__head d-flex justify-content-between">
        <h4 class="checkout-page__section-title font-18-22 fw-500 d-flex align-items-center"><span class="font-14-20 fw-500 d-flex justify-content-center align-items-center">3</span>Доставка</h4>
        <button type="button" class="checkout-change-button transparent-btn font-14-20 fw-500">Змінити</button>
    </div>

    <?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

    <div class="checkout-page__section__body delivery__body">
        <div class="delivery__place">
            <div id="delivery_region" class="delivery__place__item d-flex flex-column">
                <h6 class="delivery__place__item-title font-13-16 fw-500">Оберіть область</h6>
                <?php global $wpdb;
                $areas = [];
                $areas_data = $wpdb->get_results("
                                SELECT ref, description
                                FROM wp_nova_poshta_areas
                            ");
                foreach ($areas_data as $item) {
                    $areas[$item->description] = $item->ref;
                }
                $city_arr = explode(', ', $checkout->get_value('billing_city'));
                $chosen_option = empty($city_arr[0]) ? ['Київська' => $areas['Київська']] : [$city_arr[0] => $areas[$city_arr[0]]];
                get_template_part('components/checkout/checkout-select', null, ['options' => $areas, 'chosen_option' => $chosen_option, 'input_id' => 'delivery_region-input']); ?>
            </div>
            <div id="delivery_city" class="delivery__place__item d-flex flex-column">
                <h6 class="delivery__place__item-title font-13-16 fw-500">Оберіть населений пункт</h6>
                <?php if (empty($city_arr[0]) || $city_arr[0] === 'Київська' && !isset($city_arr[1])) {
                    $option = ['Київ' => '8d5a980d-391c-11dd-90d9-001a92567626'];
                } elseif (isset($city_arr[1])) {
                    $city_name = $city_arr[1];
                    $area_ref = $areas[$city_arr[0]];
                    $cities_data = $wpdb->get_results("
                                    SELECT ref
                                    FROM wp_nova_poshta_cities
                                    WHERE area_ref = '$area_ref'
                                    AND description = '$city_name'
                                ");
                    $option = [$city_name => $cities_data[0]->ref];
                } else {
                    $option = ['Оберіть населений пункт' => ''];
                }
                get_template_part('components/checkout/checkout-select', null, ['chosen_option' => $option, 'input_id' => 'delivery_city-input', 'select_type' => 'city']); ?>
            </div>
        </div>
        <div class="delivery__type">
            <h4 class="delivery__type-title font-15-24 fw-500">Спосіб доставки</h4>
            <?php WC()->cart->calculate_shipping();
            $packages = WC()->shipping()->get_packages();
            $selected_delivery = '';
            foreach ($packages as $index => $package) {
                $available_methods = $package['rates'];
                $chosen_method = isset( WC()->session->chosen_shipping_methods[ $index ] ) ? WC()->session->chosen_shipping_methods[ $index ] : '';
                foreach ( $available_methods as $method ) { ?>
                    <div id="<?= $method->method_id ?>" class="delivery__type__item transition-default">
                        <div class="item__radio d-flex align-items-center">
                            <?php if ( 1 < count( $available_methods ) ) {
                                printf( '<input type="radio" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_method input-radio" %4$s />', $index, esc_attr( sanitize_title( $method->id ) ), esc_attr( $method->id ), checked( $method->id, $chosen_method, false ) );
                            } else {
                                printf( '<input type="hidden" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_method" />', $index, esc_attr( sanitize_title( $method->id ) ), esc_attr( $method->id ) );
                            }
                            printf( '<label for="shipping_method_%1$s_%2$s" class="font-14-20 fw-500">%3$s</label>', $index, esc_attr( sanitize_title( $method->id ) ), wc_cart_totals_shipping_method_label( $method ) );
                            ?>
                        </div>
                        <div class="item__select">
                            <?php $delivery_item = match($method->method_id) {
                                'nova_poshta_depart' => ['title' => 'Оберіть відділення', 'select' => 'Оберіть відділення'],
                                'nova_poshta_postomat' => ['title' => 'Поштомат', 'select' => 'Оберіть поштомат'],
                                'nova_poshta_courier' => ['title' => 'Вулиця', 'select' => 'Оберіть вулицю'],
                            }; ?>
                            <h5 class="item__select-title font-13-16 fw-500"><?= $delivery_item['title'] ?></h5>
                            <?php $address = $checkout->get_value('billing_address_1');
                            if ($method->id === $chosen_method && $address) {
                                $chosen_option = [$address => ''];
                                $selected_delivery = $method->method_id;
                            } else {
                                $chosen_option = [$delivery_item['select'] => ''];
                            }
                            get_template_part('components/checkout/checkout-select', null, ['chosen_option' => $chosen_option, 'input_id' => 'delivery_type-input', 'select_type' => $method->method_id]);
                            if ($method->method_id === 'nova_poshta_courier') {
                                $address_street = $checkout->get_value('billing_address_1');
                                $address_arr = explode(', ', $checkout->get_value('billing_address_2'));
                                $building_num = '';
                                $apartment_num = '';
                                if ($selected_delivery === 'nova_poshta_courier') {
                                    $building_num = !empty($address_arr[0]) ? str_replace('буд. ', '', $address_arr[0]) : '';
                                    $apartment_num = !empty($address_arr[1]) ? str_replace('кв. ', '', $address_arr[1]) : '';
                                } ?>
                                <div class="item__select__address d-flex justify-content-between">
                                    <div class="item__select__address__item input__wrapper">
                                        <label for="building-number" class="font-13-16 fw-500">Будинок</label>
                                        <input type="text" name="building-number" id="building-number" class="checkout__input-item font-13-16 fw-400" value="<?= $building_num ?>" placeholder="Номер будинку">
                                    </div>
                                    <div class="item__select__address__item input__wrapper">
                                        <label for="apartment-number" class="font-13-16 fw-500">Квартира</label>
                                        <input type="text" name="apartment-number" id="apartment-number" class="checkout__input-item font-13-16 fw-400" value="<?= $apartment_num ?>" placeholder="Номер квартири">
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php }
            } ?>
        </div>
        <?php if (isset($address)) {
            if ($selected_delivery === 'nova_poshta_courier' && empty($address_arr[0])) {
                $is_disabled = 'disabled';
            } else {
                $is_disabled = '';
            }
        } else {
            $is_disabled = 'disabled';
        } ?>
        <button type="button" class="checkout-next-button std-btn purple-btn font-15-24 fw-600" <?= $is_disabled ?>>Продовжити</button>
    </div>

    <?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

    <div class="checkout-page__section__ready">
        <div class="ready__delivery__logo">
            <div id="np-logo" class="ready__delivery__logo-image img-wrapper-contain">
                <img src="<?php bloginfo('template_url'); ?>/images/nova-poshta.png" alt="Нова Пошта">
            </div>
        </div>
        <div class="ready__item d-flex align-items-center">
            <div class="ready__item-icon icon-wrapper">
                <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 19 19" fill="none">
                    <path d="M9.50162 1.77734C5.44483 1.77734 2.14453 5.07765 2.14453 9.13443C2.14453 13.4474 6.15111 16.0942 8.80226 17.8452L9.26099 18.1499C9.3337 18.1984 9.41765 18.2226 9.50074 18.2226C9.58384 18.2226 9.6678 18.1984 9.7405 18.1499L10.1992 17.8452C12.8504 16.0942 16.857 13.4474 16.857 9.13443C16.8587 5.07765 13.5584 1.77734 9.50162 1.77734ZM9.50162 11.2983C8.3063 11.2983 7.33777 10.3297 7.33777 9.13443C7.33777 7.93912 8.3063 6.97058 9.50162 6.97058C10.6969 6.97058 11.6655 7.93912 11.6655 9.13443C11.6655 10.3297 10.6969 11.2983 9.50162 11.2983Z" fill="#29282C"/>
                </svg>
            </div>
            <p class="ready__item-text ready__item--city font-14-20 fw-500"></p>
        </div>
        <div class="ready__item d-flex align-items-center">
            <div class="ready__item-icon icon-wrapper">
                <svg xmlns="http://www.w3.org/2000/svg" width="19" height="18" viewBox="0 0 19 18" fill="none">
                    <path d="M18.066 15.7452H17.6378V7.82224C17.6378 6.77898 17.1564 6.21017 16.2005 6.12109C16.0532 6.10739 15.9247 6.23347 15.9247 6.38165V15.7452H14.6399V3.53957C14.6399 1.8265 13.7834 0.969971 12.0703 0.969971H6.9311C5.21804 0.969971 4.3615 1.8265 4.3615 3.53957V15.7452H3.0767V6.38165C3.0767 6.23347 2.9482 6.10739 2.80088 6.12109C1.84499 6.21017 1.36364 6.77898 1.36364 7.82224V15.7452H0.935369C0.580764 15.7452 0.292969 16.033 0.292969 16.3876C0.292969 16.7422 0.580764 17.03 0.935369 17.03H18.066C18.4206 17.03 18.7084 16.7422 18.7084 16.3876C18.7084 16.033 18.4206 15.7452 18.066 15.7452ZM7.5735 4.3961C7.5735 4.0415 7.8613 3.7537 8.2159 3.7537C8.57051 3.7537 8.8583 4.0415 8.8583 4.3961V5.46677H10.1431V4.3961C10.1431 4.0415 10.4309 3.7537 10.7855 3.7537C11.1401 3.7537 11.4279 4.0415 11.4279 4.3961V7.82224C11.4279 8.17684 11.1401 8.46464 10.7855 8.46464C10.4309 8.46464 10.1431 8.17684 10.1431 7.82224V6.75157H8.8583V7.82224C8.8583 8.17684 8.57051 8.46464 8.2159 8.46464C7.8613 8.46464 7.5735 8.17684 7.5735 7.82224V4.3961ZM7.78763 12.9614C7.78763 12.0158 8.55509 11.2484 9.5007 11.2484C10.4463 11.2484 11.2138 12.0158 11.2138 12.9614V15.7452H7.78763V12.9614Z" fill="#29282C"/>
                </svg>
            </div>
            <p class="ready__item-text ready__item--address font-14-20 fw-500"></p>
        </div>
    </div>
</section>
<section class="checkout-page__section checkout-page__payment">
    <div class="checkout-page__section__head d-flex justify-content-between">
        <h4 class="checkout-page__section-title font-18-22 fw-500 d-flex align-items-center"><span class="font-14-20 fw-500 d-flex justify-content-center align-items-center">4</span>Оплата</h4>
        <button type="button" class="checkout-change-button transparent-btn font-14-20 fw-500">Змінити</button>
    </div>
    <div class="checkout-page__section__body payment__body">
        <?php $available_gateways = WC()->payment_gateways()->get_available_payment_gateways();
        if (!empty($available_gateways)) {
            foreach ($available_gateways as $gateway) { ?>
                <div class="payment__item wc_payment_method payment_method_<?= esc_attr($gateway->id); ?> d-flex flex-wrap align-items-center">
                    <input id="payment_method_<?= esc_attr($gateway->id); ?>" type="radio" class="payment_method input-radio" name="payment_method" value="<?= esc_attr($gateway->id); ?>" <?php checked($gateway->chosen, true); ?> data-order_button_text="<?= esc_attr($gateway->order_button_text); ?>" />
                    <label for="payment_method_<?= esc_attr($gateway->id); ?>" class="payment__item-label font-14-20 fw-400">
                        <?= $gateway->get_title(); ?> <?= $gateway->get_icon(); ?>
                    </label>
                    <?php if (esc_attr($gateway->id) === 'cod') { ?>
                        <p class="payment__item-subtitle font-11-13 fw-400">Послуга оплачується окремо за тарифами перевізника</p>
                    <?php } ?>
                </div>
            <?php }
        } else { ?>
            <p><?php wc_print_notice(apply_filters('woocommerce_no_available_payment_methods_message', WC()->customer->get_billing_country() ? esc_html__('Sorry, it seems that there are no available payment methods for your state. Please contact us if you require assistance or wish to make alternate arrangements.', 'woocommerce') : esc_html__('Please fill in your details above to see available payment methods.', 'woocommerce')), 'notice'); ?></p>
        <?php } ?>
        <button type="button" class="checkout-next-button std-btn purple-btn font-15-24 fw-600">Продовжити</button>
    </div>
    <div class="checkout-page__section__ready">
        <div class="ready__item d-flex align-items-center">
            <div class="ready__item-icon icon-wrapper">
                <svg xmlns="http://www.w3.org/2000/svg" width="19" height="18" viewBox="0 0 19 18" fill="none">
                    <path d="M10.6111 11.7778C10.6111 13.3689 11.9089 14.6667 13.5 14.6667H17.5V15.3333C17.5 17.1111 16.6111 18 14.8333 18H4.16667C2.38889 18 1.5 17.1111 1.5 15.3333V3.77778C1.5 4.75556 2.3 5.55556 3.27778 5.55556H14.8333C16.6111 5.55556 17.5 6.44444 17.5 8.22222V8.88889H13.5C11.9089 8.88889 10.6111 10.1867 10.6111 11.7778ZM13.5 10.2222C12.6467 10.2222 11.9444 10.9244 11.9444 11.7778C11.9444 12.6311 12.6467 13.3333 13.5 13.3333H17.5V10.2222H13.5ZM13.9622 12.6667C13.4734 12.6667 13.0645 12.2667 13.0645 11.7778C13.0645 11.2889 13.4645 10.8889 13.9533 10.8889H13.9622C14.4511 10.8889 14.8511 11.2889 14.8511 11.7778C14.8511 12.2667 14.4511 12.6667 13.9622 12.6667ZM12.1667 2H3.94444C3.33111 2 2.83333 2.49778 2.83333 3.11111C2.83333 3.72444 3.33111 4.22222 3.94444 4.22222H14.8066C14.6733 2.73778 13.7933 2 12.1667 2Z" fill="#494558"/>
                </svg>
            </div>
            <p class="ready__item-text ready__item--payment font-14-20 fw-500"></p>
        </div>
    </div>
</section>


		<?php // do_action( 'woocommerce_review_order_before_order_total' ); ?>

		<?php // do_action( 'woocommerce_review_order_after_order_total' ); ?>

<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
