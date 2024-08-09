<?php
/**
 * Checkout coupon form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-coupon.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.1.4
 */

defined( 'ABSPATH' ) || exit;

if ( ! wc_coupons_enabled() ) { // @codingStandardsIgnoreLine.
	return;
}

?>
<div class="checkout-page__section checkout-page__coupon">
    <div class="coupon__head d-flex justify-content-between">
        <h4 class="coupon-title font-14-20 fw-500">Промокод</h4>
        <button type="button" class="coupon__head-button transparent-btn font-14-20 fw-500">Додати</button>
    </div>
    <div class="coupon__body">
        <div class="input__wrapper">
            <label for="coupon_code" class="screen-reader-text"><?php esc_html_e('Coupon:', 'woocommerce'); ?></label>
            <input type="text" name="coupon_code" class="coupon-input checkout__input-item" placeholder="<?php esc_attr_e('Введіть промокод', 'woocommerce'); ?>" id="coupon_code" value="" />
            <p class="input--error-text font-9-11 fw-400">Заповніть будь ласка поле</p>
        </div>
        <button type="button" class="coupon-button std-btn purple-btn font-15-18 fw-600" name="apply_coupon" value="<?php esc_attr_e('Застосувати', 'woocommerce'); ?>"><?php esc_html_e('Застосувати', 'woocommerce'); ?></button>
    </div>
</div>

