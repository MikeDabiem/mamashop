<?php
/**
 * Checkout Payment Section
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/payment.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.1.4
 */

defined( 'ABSPATH' ) || exit;

if ( ! wp_doing_ajax() ) {
	do_action( 'woocommerce_review_order_before_payment' );
}
?>
<div id="payment" class="woocommerce-checkout-payment checkout-page__body__total">
	<div class="form-row place-order">
		<noscript>
			<?php
			/* translators: $1 and $2 opening and closing emphasis tags respectively */
			printf( esc_html__( 'Since your browser does not support JavaScript, or it is disabled, please ensure you click the %1$sUpdate Totals%2$s button before placing your order. You may be charged more than the amount stated above if you fail to do so.', 'woocommerce' ), '<em>', '</em>' );
			?>
			<br/><button type="submit" class="button alt<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="woocommerce_checkout_update_totals" value="<?php esc_attr_e( 'Update totals', 'woocommerce' ); ?>"><?php esc_html_e( 'Update totals', 'woocommerce' ); ?></button>
		</noscript>

		<?php // wc_get_template( 'checkout/terms.php' ); ?>

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

        <?php do_action( 'woocommerce_review_order_before_submit' ); ?>

        <div class="checkout-page__confirm">

            <?php
            $order_button_text = 'Замовлення підтверджую';
            echo apply_filters( 'woocommerce_order_button_html', '<button type="submit" class="confirm-button std-btn purple-btn font-15-18 fw-600 w-100" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr( $order_button_text ) . '" data-value="' . esc_attr( $order_button_text ) . '">' . esc_html( $order_button_text ) . '</button>' ); // @codingStandardsIgnoreLine ?>

            <?php do_action( 'woocommerce_review_order_after_submit' ); ?>

            <?php wp_nonce_field( 'woocommerce-process_checkout', 'woocommerce-process-checkout-nonce' ); ?>
            <p class="confirm-text font-11-13 fw-500">Підтверджуючи замовлення я приймаю <a href="<?= get_privacy_policy_url(); ?>" target="_blank">умови сайту</a> та надаю згоду на <a href="<?= get_privacy_policy_url(); ?>" target="_blank">обробку моїх персональних даних.</a></p>
        </div>
	</div>
</div>
<?php
if ( ! wp_doing_ajax() ) {
	do_action( 'woocommerce_review_order_after_payment' );
}
