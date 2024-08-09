<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
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

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_checkout_form', $checkout );

?>

<section class="checkout-page wrapper filler">
    <h1 class="checkout-page-title font-28-36 fw-600">Оформлення замовлення</h1>
    <div class="checkout-page__body">
        <form name="checkout" method="post" class="checkout-page__body__form checkout__form checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

            <?php if ( $checkout->get_checkout_fields() ) : ?>

                <?php do_action( 'woocommerce_checkout_before_customer_details' );

                do_action( 'woocommerce_checkout_billing' );


                do_action( 'woocommerce_checkout_after_customer_details' ); ?>

            <?php endif; ?>

            <?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>

            <?php do_action( 'woocommerce_checkout_order_review' );

            do_action( 'woocommerce_checkout_shipping' ); ?>

        </form>
    </div>
</section>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
