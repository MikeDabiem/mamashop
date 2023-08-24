<?php /* Template Name: Checkout Template */
// setcookie('username', 'Mike', time() + 60);
// set cookie for 60 seconds
get_header(); ?>
<section class="checkout-page wrapper filler">
    <h1 class="checkout-page-title font-28-36 fw-600">Оформлення замовлення</h1>
    <div class="checkout-page__body d-flex">
        <div class="checkout-page__body__col1">
            <section class="checkout-page__section checkout-page__contacts active">
                <div class="checkout-page__section__head d-flex justify-content-between">
                    <h4 class="checkout-page__section-title font-18-22 fw-500 d-flex align-items-center"><span class="font-14-20 fw-500 d-flex justify-content-center align-items-center">1</span>Контактні дані</h4>
                    <button type="button" class="checkout-change-button transparent-btn font-14-20 fw-500">Змінити</button>
                </div>
                <div class="checkout-page__section__body contacts__body">
                    <div class="checkout__inputs d-flex flex-wrap">
                        <?php $user_name = $_COOKIE['user_name'] ?? '';
                        $user_lastname = $_COOKIE['user_lastname'] ?? '';
                        $user_email = $_COOKIE['user_email'] ?? wp_get_current_user()->user_email;
                        $user_phone = $_COOKIE['user_phone'] ?? ''; ?>
                        <div class="checkout__input input__wrapper">
                            <label for="customer-name" class="font-13-16 fw-500 d-block">Ім’я*</label>
                            <input type="text" name="customer-name" id="customer-name" class="checkout__input-item font-13-16 fw-400 transition-default" placeholder="Введіть своє ім’я" value="<?= $user_name; ?>" required>
                            <p class="input--error-text font-9-11 fw-400">Заповніть будь ласка поле</p>
                        </div>
                        <div class="checkout__input input__wrapper">
                            <label for="customer-lastname" class="font-13-16 fw-500 d-block">Прізвище*</label>
                            <input type="text" name="customer-lastname" id="customer-lastname" class="checkout__input-item font-13-16 fw-400 transition-default" placeholder="Введіть своє прізвище" value="<?= $user_lastname; ?>" required>
                            <p class="input--error-text font-9-11 fw-400">Заповніть будь ласка поле</p>
                        </div>
                        <div class="checkout__input input__wrapper">
                            <label for="customer-phone" class="font-13-16 fw-500 d-block">Телефон*</label>
                            <input type="text" name="customer-phone" id="customer-phone" class="checkout__input-item font-13-16 fw-400 transition-default" placeholder="Введіть номер телефону" value="<?= $user_phone; ?>" required>
                            <p class="input--error-text font-9-11 fw-400">Заповніть будь ласка поле</p>
                        </div>
                        <div class="checkout__input input__wrapper">
                            <label for="customer-email" class="font-13-16 fw-500 d-block">Електронна пошта</label>
                            <input type="text" name="customer-email" id="customer-email" class="checkout__input-item font-13-16 fw-400 transition-default" placeholder="Введіть електронну пошту" value="<?= $user_email; ?>">
                            <p class="input--error-text font-9-11 fw-400">Невірний формат адреси електронної пошти</p>
                        </div>
                    </div>
                    <button type="button" id="contacts-next" class="checkout-next-button std-btn purple-btn">Продовжити</button>
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
                            <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                                $prod_num = 1;
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
                    <button type="button" id="contacts-next" class="checkout-next-button std-btn purple-btn">Продовжити</button>
                </div>
            </section>
            <section class="checkout-page__section checkout-page__delivery">
                <h4 class="checkout-page__section-title font-18-22 fw-500 d-flex align-items-center"><span class="font-14-20 fw-500 d-flex justify-content-center align-items-center">3</span>Доставка</h4>
                <div class="checkout-page__section__body delivery__body">
                    <?php the_content(); ?>
                </div>
            </section>
            <section class="checkout-page__section checkout-page__payment">
                <h4 class="checkout-page__section-title font-18-22 fw-500 d-flex align-items-center"><span class="font-14-20 fw-500 d-flex justify-content-center align-items-center">4</span>Оплата</h4>
            </section>
            <section class="checkout-page__section checkout-page__comment">
                <h5 class="comment-title font-14-20 fw-500 transition-default">Додати коментар до замовлення</h5>
                <div class="checkout-page__section__body comment__body">
                    <textarea name="checkout-comment" id="checkout-comment" class="comment-textarea font-13-16 fw-400 d-block" placeholder="Наприклад: відправте, будь ласка, завтра"></textarea>
                    <button type="button" class="comment-button std-btn purple-btn">Додати</button>
                </div>
                <div class="checkout-page__section__ready comment__ready">
                    <p class="comment__ready-text font-14-20 fw-500"></p>
                </div>
            </section>
        </div>
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
                        <p class="total__body__item-value font-14-20 fw-500"><?= WC()->cart->get_cart_subtotal(); ?> грн</p>
                    </div>
                    <div class="total__body__item d-flex justify-content-between">
                        <p class="total__body__item-title font-14-20 fw-400">Знижка:</p>
                        <p class="total__body__item-value font-14-20 fw-500"><?= array_sum(WC()->cart->get_coupon_discount_totals()); ?> грн</p>
                    </div>
                </div>
                <div class="total__to_pay d-flex justify-content-between align-items-center">
                    <p class="total__to_pay-title font-15-24 fw-600">До сплати:</p>
                    <p class="total__to_pay-value font-18-22 fw-600"><?= WC()->cart->get_cart_total(); ?> грн</p>
                </div>
            </div>
            <div class="checkout-page__section checkout-page__coupon">
                <div class="coupon__head d-flex justify-content-between">
                    <h4 class="coupon-title font-14-20 fw-500">Промокод</h4>
                    <button type="button" class="coupon__head-button transparent-btn font-14-20 fw-500">Додати</button>
                </div>
                <div class="coupon__body">
                    <input type="text" class="coupon-input checkout__input-item font-13-16 fw-400" placeholder="Введіть промокод">
                    <button type="button" class="coupon-button font-15-18 fw-600">Застосувати</button>
                </div>
            </div>
        </div>
    </div>
</section>
<?php get_footer();
