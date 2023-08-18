<?php /* Template Name: Checkout Template */
// setcookie('username', 'Mike', time() + 60);
// set cookie for 60 seconds
get_header(); ?>
<section class="checkout-page wrapper filler">
    <h1 class="checkout-page-title font-28-36 fw-600">Оформлення замовлення</h1>
    <div class="checkout-page__body d-flex">
        <div class="checkout-page__body__col1">
            <section class="checkout-page__section checkout-page__contacts active">
                <h4 class="checkout-page__section-title font-18-22 fw-500 d-flex align-items-center"><span class="font-14-20 fw-500 d-flex justify-content-center align-items-center">1</span>Контактні дані</h4>
                <div class="checkout-page__section__body contacts__body">
                    <div class="checkout__inputs d-flex flex-wrap">
                        <?php $user_name = $_COOKIE['user_name'] ?? '';
                        $user_lastname = $_COOKIE['user_lastname'] ?? '';
                        $user_email = $_COOKIE['user_email'] ?? wp_get_current_user()->user_email;
                        $user_phone = $_COOKIE['user_phone'] ?? ''; ?>
                        <div class="checkout__input">
                            <label for="customer-name" class="font-13-16 fw-500 d-block">Ім’я*</label>
                            <input type="text" id="customer-name" class="checkout__input-item font-13-16 fw-400 transition-default" placeholder="Введіть своє ім’я" value="<?= $user_name; ?>">
                        </div>
                        <div class="checkout__input">
                            <label for="customer-lastname" class="font-13-16 fw-500 d-block">Прізвище*</label>
                            <input type="text" id="customer-lastname" class="checkout__input-item font-13-16 fw-400 transition-default" placeholder="Введіть своє прізвище" value="<?= $user_lastname; ?>">
                        </div>
                        <div class="checkout__input">
                            <label for="customer-phone" class="font-13-16 fw-500 d-block">Телефон*</label>
                            <input type="text" id="customer-phone" class="checkout__input-item font-13-16 fw-400 transition-default" placeholder="Введіть номер телефону" value="<?= $user_phone; ?>">
                        </div>
                        <div class="checkout__input">
                            <label for="customer-email" class="font-13-16 fw-500 d-block">Електронна пошта</label>
                            <input type="text" id="customer-email" class="checkout__input-item font-13-16 fw-400 transition-default" placeholder="Введіть електронну пошту" value="<?= $user_email; ?>">
                        </div>
                    </div>
                    <button id="contacts-next" class="checkout-next-button std-btn purple-btn">Продовжити</button>
                </div>
            </section>
            <section class="checkout-page__section checkout-page__products">
                <h4 class="checkout-page__section-title font-18-22 fw-500 d-flex align-items-center"><span class="font-14-20 fw-500 d-flex justify-content-center align-items-center">2</span>Товари для оформлення</h4>
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
                    <button class="coupon__head-button font-14-20 fw-500">Додати</button>
                </div>
                <div class="coupon__body">
                    <input type="text" class="coupon-input checkout__input-item font-13-16 fw-400" placeholder="Введіть промокод">
                    <button class="coupon-button font-15-18 fw-600">Застосувати</button>
                </div>
            </div>
        </div>
    </div>
</section>
<?php get_footer();
