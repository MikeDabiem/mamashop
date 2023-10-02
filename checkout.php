<?php /* Template Name: Checkout Template */
get_header(); ?>
<section class="checkout-page wrapper filler">
    <h1 class="checkout-page-title font-28-36 fw-600">Оформлення замовлення</h1>
    <div class="checkout-page__body d-flex">
        <form name="checkout" method="post" id="checkout-form" class="checkout-page__body__col1 checkout__form checkout woocommerce-checkout" action="https://www.mamashop.brinpl.com/checkout/" enctype="multipart/form-data" novalidate="novalidate">
            <section class="checkout-page__section checkout-page__contacts active">
                <div class="checkout-page__section__head d-flex justify-content-between">
                    <h4 class="checkout-page__section-title font-18-22 fw-500 d-flex align-items-center"><span class="font-14-20 fw-500 d-flex justify-content-center align-items-center">1</span>Контактні дані</h4>
                    <button type="button" class="checkout-change-button transparent-btn font-14-20 fw-500">Змінити</button>
                </div>
                <div class="checkout-page__section__body contacts__body">
                    <div class="checkout__inputs d-flex flex-wrap">
                        <?php $checkout = WC()->checkout();
                        $fields = $checkout->get_checkout_fields('billing');
                        foreach ( $fields as $key => $field ) {
                            $hide = $key === 'billing_country' || $key === 'billing_address_1' || $key === 'billing_address_2' || $key === 'billing_city' ? 'd-none' : ''; ?>
                            <div id="<?= $key; ?>_field" class="checkout__input input__wrapper <?= $hide; ?>">
                                <label for="<?= $key; ?>" class="d-block"><?= $field['label']; if ($field['required'] ): ?><abbr class="text-decoration-none" title="Обов'язкове поле">*</abbr><?php endif; ?></label>
                                <input type="text" name="<?= $key; ?>" id="<?= $key; ?>" class="checkout__input-item" placeholder="<?php isset($field['placeholder']) ? print $field['placeholder'] : print ''; ?>" value="<?= $checkout->get_value($key); ?>" <?php if ($field['required']): ?>required<?php endif; ?>>
                                <?php if ($key === 'billing_email') { ?>
                                    <p class="input--error-text font-9-11 fw-400">Невірний формат адреси електронної пошти</p>
                                <?php } else { ?>
                                    <p class="input--error-text font-9-11 fw-400">Заповніть будь ласка поле</p>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                    <button type="button" class="checkout-next-button std-btn purple-btn">Продовжити</button>
                </div>
                <div class="checkout-page__section__ready">
                    <div class="ready__item d-flex align-items-center">
                        <div class="ready__item-icon icon-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="18" viewBox="0 0 19 18" fill="none">
                                <path d="M6.25227 4.52693C6.25227 2.73283 7.71129 1.2738 9.50539 1.2738C11.2995 1.2738 12.7585 2.73283 12.7585 4.52693C12.7585 6.32103 11.2995 7.78005 9.50539 7.78005C7.71129 7.78005 6.25227 6.32103 6.25227 4.52693ZM11.1246 9.40662H7.87148C4.56956 9.40662 3.39844 11.8245 3.39844 13.8952C3.39844 15.747 4.38336 16.7261 6.2474 16.7261H12.7487C14.6127 16.7261 15.5977 15.747 15.5977 13.8952C15.5977 11.8245 14.4265 9.40662 11.1246 9.40662Z" fill="#494558"/>
                            </svg>
                        </div>
                        <p class="ready__item-text ready__item--name font-14-20 fw-500"></p>
                    </div>
                    <div class="ready__item d-flex align-items-center">
                        <div class="ready__item-icon icon-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="16" viewBox="0 0 17 16" fill="none">
                                <path d="M16.4303 12.7051V12.8011C16.4175 12.8331 16.4047 12.865 16.3983 12.9034C16.3727 13.2936 16.2128 13.6198 15.9442 13.8948C15.4773 14.3745 14.9976 14.8478 14.5242 15.3211C14.294 15.5513 14.0253 15.7176 13.7119 15.8136C13.0467 16.0183 12.3815 15.9479 11.7291 15.788C10.5394 15.5002 9.46478 14.9373 8.44138 14.2849C7.22609 13.5046 6.11314 12.5836 5.08974 11.5667C3.625 10.1148 2.35214 8.51578 1.43108 6.66095C0.970548 5.73353 0.612357 4.76774 0.573979 3.7124C0.541998 2.98966 0.714697 2.33727 1.27117 1.8192C1.63576 1.48021 1.98116 1.12843 2.32656 0.770256C2.63997 0.437665 2.97258 0.149846 3.4395 0.0603027H3.90643C4.19426 0.14345 4.4757 0.232994 4.71236 0.431269C4.75074 0.463249 4.78272 0.488833 4.8147 0.520813C5.53108 1.23716 6.24746 1.94711 6.96384 2.66986C7.48834 3.20073 7.57789 3.92987 7.2069 4.54388C7.0406 4.81251 6.81033 5.00439 6.51611 5.11312C6.07476 5.27302 5.72937 5.53525 5.53748 5.97658C5.41595 6.2644 5.39036 6.55222 5.47352 6.85283C5.70378 7.72268 6.1899 8.43263 6.78475 9.08502C7.39879 9.7566 8.08959 10.3322 8.9147 10.7352C9.28569 10.9143 9.66946 11.0742 10.098 11.0102C10.6289 10.9335 11.0255 10.6712 11.2685 10.1851C11.3773 9.96127 11.4732 9.71183 11.6331 9.53274C12.1576 8.93791 13.0723 8.88675 13.6799 9.41122C13.9166 9.61589 14.1341 9.84614 14.3579 10.07C14.8696 10.5753 15.3685 11.087 15.8802 11.5922C16.1745 11.8865 16.3855 12.2127 16.4047 12.6412C16.4047 12.6604 16.4175 12.686 16.4303 12.7051Z" fill="#494558"/>
                            </svg>
                        </div>
                        <p class="ready__item-text ready__item--phone font-14-20 fw-500"></p>
                    </div>
                    <div class="ready__item ready__item__email d-flex align-items-center">
                        <div class="ready__item-icon icon-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="14" viewBox="0 0 17 14" fill="none">
                                <path d="M1.2942 0.932791L1.2941 0.932691C1.16986 0.808463 1.25991 0.594084 1.43315 0.594084H15.543C15.721 0.594084 15.808 0.80672 15.682 0.932691L10.6438 5.97058L8.60527 8.00903C8.58329 8.03102 8.54628 8.06801 8.51138 8.10029C8.50206 8.10891 8.49322 8.11688 8.48513 8.12394C8.47768 8.11774 8.46957 8.1107 8.46099 8.103C8.42761 8.07305 8.39289 8.03836 8.37084 8.01631L8.37014 8.01561C6.01145 5.65706 3.65282 3.29856 1.2942 0.932791Z" fill="#494558" stroke="#F7F7F8" stroke-width="0.183286"/>
                                <path d="M6.49138 7.86932C6.48475 7.87552 6.47724 7.88277 6.46878 7.89122L6.40399 7.82642L6.46895 7.89106C5.04914 9.31807 3.60749 10.7596 2.20963 12.1574L1.29956 13.0674C1.17358 13.1934 1.26055 13.406 1.43861 13.406H15.5339C15.7165 13.406 15.8007 13.1926 15.6682 13.0699L15.6656 13.0675L15.6656 13.0674L15.0177 12.4195C13.5033 10.9052 11.9888 9.39085 10.4744 7.86939C10.1615 8.19553 9.82583 8.53097 9.38806 8.96166C9.38797 8.96175 9.38787 8.96184 9.38778 8.96194L9.32351 8.89661C8.79202 9.42806 8.17317 9.42806 7.64169 8.89661L6.49138 7.86932ZM6.49138 7.86932C6.49959 7.87714 6.50919 7.88651 6.52036 7.89767L6.49138 7.86932Z" fill="#494558" stroke="#F7F7F8" stroke-width="0.183286"/>
                                <path d="M5.63295 7.0073C4.10259 8.53038 2.55801 10.0749 1.05686 11.5759L1.05641 11.5764L0.430281 12.2025C0.306029 12.3267 0.0916428 12.2366 0.0916428 12.0634V1.94397C0.0916428 1.76594 0.304285 1.67894 0.430281 1.80493L2.77464 4.14915L5.61407 6.98842L5.67887 6.92362L5.61407 6.98842L5.62863 7.00298L5.63295 7.0073Z" fill="#494558" stroke="#F7F7F8" stroke-width="0.183286"/>
                                <path d="M14.2473 9.88006L11.3563 6.98919C12.9172 5.43545 14.492 3.86071 16.0238 2.32907L16.5691 1.78378C16.6952 1.66366 16.9084 1.75145 16.9084 1.92938V12.0634C16.9084 12.2414 16.6958 12.3284 16.5698 12.2024L14.2473 9.88006Z" fill="#494558" stroke="#F7F7F8" stroke-width="0.183286"/>
                            </svg>
                        </div>
                        <p class="ready__item-text ready__item--email font-14-20 fw-500"></p>
                    </div>
                </div>
            </section>
            <section class="checkout-page__section checkout-page__products">
                <div class="checkout-page__section__head d-flex justify-content-between">
                    <h4 class="checkout-page__section-title font-18-22 fw-500 d-flex align-items-center"><span class="font-14-20 fw-500 d-flex justify-content-center align-items-center">2</span>Товари для оформлення</h4>
                    <button type="button" class="checkout-change-button transparent-btn font-14-20 fw-500">Змінити</button>
                </div>
                <div class="checkout-page__section__body products__body">
                    <table class="products__table caption-top">
                        <caption class="products-title font-15-24 fw-600 p-0">Ваше замовлення</caption>
                        <thead>
                            <tr class="products__table__head font-12-16 fw-400">
                                <th class="table-num"></th>
                                <th class="table-name">Товар</th>
                                <th class="table-col">Вартість</th>
                                <th class="table-col">Кількість</th>
                                <th class="table-col">Сума</th>
                            </tr>
                        </thead>
                        <tbody>
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
                                <tr class="products__table__item font-13-16 fw-500">
                                    <td class="products__table__item-count"><?= $prod_num; ?></td>
                                    <td class="products__table__item-info d-flex align-items-center">
                                        <div class="products__table__item-image img-wrapper-contain">
                                            <?php if ($image_url) { ?>
                                                <img src="<?= $image_url; ?>" alt="<?= $alt; ?>">
                                            <?php } else { ?>
                                                <img src="<?php bloginfo('template_url'); ?>/images/eye-slash.svg" alt="no image">
                                            <?php } ?>
                                        </div>
                                        <div class="products__table__item__text">
                                            <p class="products__table__item-name"><?= $name; ?></p>
                                            <p class="products__table__item-brand font-12-16"><?= $brand; ?></p>
                                        </div>
                                    </td>
                                    <td><?= $sale_price ?: $price; ?> грн</td>
                                    <td><?= $quantity; ?> шт.</td>
                                    <td><?= $sale_price ? $sale_price * $quantity : $price * $quantity; ?> грн</td>
                                </tr>
                                <?php $prod_num++;
                            } ?>
                        </tbody>
                    </table>
                    <button type="button" class="checkout-next-button std-btn purple-btn">Продовжити</button>
                </div>
            </section>
            <section class="checkout-page__section checkout-page__delivery active">
                <div class="checkout-page__section__head d-flex justify-content-between">
                    <h4 class="checkout-page__section-title font-18-22 fw-500 d-flex align-items-center"><span class="font-14-20 fw-500 d-flex justify-content-center align-items-center">3</span>Доставка</h4>
                    <button type="button" class="checkout-change-button transparent-btn font-14-20 fw-500">Змінити</button>
                </div>
                <div class="checkout-page__section__body delivery__body d-block">
                    <div class="delivery__place d-flex">
                        <div id="delivery_region" class="delivery__place__item">
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
                        <div id="delivery_city" class="delivery__place__item">
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
                                        printf( '<label for="shipping_method_%1$s_%2$s">%3$s</label>', $index, esc_attr( sanitize_title( $method->id ) ), wc_cart_totals_shipping_method_label( $method ) );
                                        ?>
                                    </div>
                                    <div class="item__select">
                                        <?php $delivery_item = match($method->method_id) {
                                        'nova_poshta_depart', 'ukrposhta_depart' => ['title' => 'Оберіть відділення', 'select' => 'Оберіть відділення'],
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
                    <button type="button" class="checkout-next-button std-btn purple-btn" <?= $is_disabled ?>>Продовжити</button>
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
                            <div class="payment__item wc_payment_method payment_method_<?= esc_attr($gateway->id); ?> d-flex align-items-center">
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
                    <button type="button" class="checkout-next-button std-btn purple-btn">Продовжити</button>
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
            <section class="checkout-page__section checkout-page__comment">
                <h5 class="comment-title font-14-20 fw-500 transition-default">Додати коментар до замовлення</h5>
                <div class="checkout-page__section__body comment__body">
                    <textarea name="order_comments" id="order_comments" class="comment-textarea font-13-16 fw-400 d-block" placeholder="Наприклад: відправте, будь ласка, завтра"></textarea>
                    <button type="button" class="comment-button std-btn purple-btn">Додати</button>
                </div>
                <div class="checkout-page__section__ready comment__ready">
                    <p class="comment__ready-text font-14-20 fw-500"></p>
                </div>
            </section>
            <?php wp_nonce_field('woocommerce-process_checkout'); ?>
        </form>
        <div class="checkout-page__body__col2">
            <div class="checkout-page__section checkout-page__total">
                <div class="total__head d-flex justify-content-between align-items-center">
                    <h3 class="total-title font-20-24 fw-600">Підсумок</h3>
                    <?php $cart_items_count = absint(WC()->cart->get_cart_contents_count()); ?>
                    <p class="total-items font-14-20 fw-500"><?= $cart_items_count . ' ' . true_wordform($cart_items_count, 'товар', 'товари', 'товарів') ?></p>
                </div>
                <div class="total__body">
                    <div class="total__body__item d-flex justify-content-between">
                        <p class="total__body__item-title font-14-20 fw-400">Всього:</p>
                        <p class="total__body__item-value font-14-20 fw-500"><?= WC()->cart->get_subtotal(); ?> грн</p>
                    </div>
                    <div class="total__body__item d-flex justify-content-between">
                        <p class="total__body__item-title font-14-20 fw-400">Знижка:</p>
                        <p id="discount_value" class="total__body__item-value font-14-20 fw-500"><?= array_sum(WC()->cart->get_coupon_discount_totals()); ?> грн</p>
                    </div>
                </div>
                <div class="total__to_pay d-flex justify-content-between align-items-center">
                    <p class="total__to_pay-title font-15-24 fw-600">До сплати:</p>
                    <p class="total__to_pay-value font-18-22 fw-600"><?= WC()->cart->get_cart_contents_total(); ?> грн</p>
                </div>
            </div>
            <div class="checkout-page__section checkout-page__coupon">
                <div class="coupon__head d-flex justify-content-between">
                    <h4 class="coupon-title font-14-20 fw-500">Промокод</h4>
                    <button class="coupon__head-button transparent-btn font-14-20 fw-500">Додати</button>
                </div>
                <div class="coupon__body">
                    <div class="input__wrapper">
                        <label for="coupon_code" class="screen-reader-text"><?php esc_html_e('Coupon:', 'woocommerce'); ?></label>
                        <input type="text" name="coupon_code" class="coupon-input checkout__input-item" placeholder="<?php esc_attr_e('Введіть промокод', 'woocommerce'); ?>" id="coupon_code" value="" />
                        <p class="input--error-text font-9-11 fw-400">Заповніть будь ласка поле</p>
                    </div>
                    <button type="button" class="coupon-button std-btn purple-btn font-15-18 fw-600 button<?= esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>" name="apply_coupon" value="<?php esc_attr_e('Застосувати', 'woocommerce'); ?>"><?php esc_html_e('Застосувати', 'woocommerce'); ?></button>
                </div>
            </div>
            <div class="checkout-page__confirm">
                <button type="submit" form="checkout-form" name="woocommerce_checkout_place_order" id="place_order" class="confirm-button std-btn purple-btn font-15-18 fw-600 w-100" data-value="Замовлення підтверджую">Замовлення підтверджую</button>
                <p class="confirm-text font-11-13 fw-400">Підтверджуючи замовлення я приймаю <a href="<?= get_privacy_policy_url(); ?>">умови сайту</a> та надаю згоду на <a href="<?= get_privacy_policy_url(); ?>">обробку моїх персональних даних.</a></p>
            </div>
        </div>
    </div>
</section>
<?php get_footer();