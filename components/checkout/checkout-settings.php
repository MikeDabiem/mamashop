<?php
// move coupon form to total section
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form');
add_action( 'woocommerce_review_order_before_submit', 'woocommerce_checkout_coupon_form' );

// change checkout fields
add_filter('woocommerce_checkout_fields', 'brinpl_change_fields', 25);
function brinpl_change_fields($fields) {
    unset($fields['billing']['billing_state']);
    unset($fields['billing']['billing_postcode']);
    unset($fields['billing']['billing_company']);

    $fields['billing']['billing_first_name']['label'] = 'Ім’я';
    $fields['billing']['billing_first_name']['autocomplete'] = false;
    $fields['billing']['billing_first_name']['placeholder'] = 'Введіть своє ім’я';

    $fields['billing']['billing_last_name']['label'] = 'Прізвище';
    $fields['billing']['billing_last_name']['autocomplete'] = false;
    $fields['billing']['billing_last_name']['placeholder'] = 'Введіть своє прізвище';

    $fields['billing']['billing_phone']['label'] = 'Телефон';
    $fields['billing']['billing_phone']['autocomplete'] = false;
    $fields['billing']['billing_phone']['placeholder'] = 'Введіть номер телефону';

    $fields['billing']['billing_email']['label'] = 'Електронна пошта';
    $fields['billing']['billing_email']['autocomplete'] = false;
    $fields['billing']['billing_email']['placeholder'] = 'Введіть електронну пошту';
    $fields['billing']['billing_email']['required'] = false;

    $fields['billing']['billing_address_1']['required'] = false;

    $fields['billing']['billing_address_2']['required'] = false;

    $fields['billing']['billing_city']['required'] = false;

    return $fields;
}

// change admin panel fields
add_filter( 'woocommerce_admin_billing_fields' ,'change_admin_billing_fields');
function change_admin_billing_fields( $fields ) {
    $fields['first_name']['label'] = 'Ім’я';
    $fields['first_name']['show'] = true;
    $fields['last_name']['label'] = 'Прізвище';
    $fields['last_name']['show'] = true;
    $fields['address_1']['label'] = 'Адреса / Відділення';
    $fields['address_1']['show'] = true;
    $fields['address_2']['label'] = 'Буд./Кв.';
    $fields['address_2']['show'] = true;
    $fields['city']['label'] = 'Область, Місто';
    $fields['city']['show'] = true;
    return $fields;
}

// register shipping methods
add_filter( 'woocommerce_shipping_methods', 'register_new_shipping_methods' );
function register_new_shipping_methods( $methods ) {
    $methods[ 'nova_poshta_depart' ] = 'WC_Shipping_Nova_Poshta_Depart';
    $methods[ 'nova_poshta_postomat' ] = 'WC_Shipping_Nova_Poshta_Postomat';
    $methods[ 'nova_poshta_courier' ] = 'WC_Shipping_Nova_Poshta_Courier';

    return $methods;
}

/**
 * WC_Shipping_Nova_Poshta_Depart class.
 *
 * @class WC_Shipping_Nova_Poshta_Depart
 * @version 1.0.0
 * @package Shipping-for-WooCommerce/Classes
 * @category Class
 * @author BRiNPL
 */
class WC_Shipping_Nova_Poshta_Depart extends WC_Shipping_Method {
    public function __construct( $instance_id = 0 ) {
        $this->id = 'nova_poshta_depart';
        $this->instance_id = absint( $instance_id );
        $this->method_title = __( 'Нова Пошта (відділення)' );
        $this->method_description = __( 'Доставка Нова Пошта до відділення.' );
        $this->supports = array(
            'shipping-zones',
            'instance-settings',
        );
        $this->instance_form_fields = array(
            'enabled' => array(
                'title' => __( 'Enable/Disable' ),
                'type' => 'checkbox',
                'label' => __( 'Enable this shipping method' ),
                'default' => 'yes',
            ),
            'title' => array(
                'title' => __( 'Method Title' ),
                'type' => 'text',
                'description' => __( 'This controls the title which the user sees during checkout.' ),
                'default' => __( 'Нова Пошта (відділення)' ),
                'desc_tip' => true
            )
        );
        $this->enabled = $this->get_option( 'enabled' );
        $this->title = $this->get_option( 'title' );

        add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
    }

    /**
     * calculate_shipping function.
     * @param array $package (default: array())
     */
    public function calculate_shipping( $package = array() ) {
        $this->add_rate( array(
            'id' => $this->id . $this->instance_id,
            'label' => $this->title,
            'cost' => '',
        ) );
    }
}

/**
 * WC_Shipping_Nova_Poshta_Postomat class.
 *
 * @class WC_Shipping_Nova_Poshta_Postomat
 * @version 1.0.0
 * @package Shipping-for-WooCommerce/Classes
 * @category Class
 * @author BRiNPL
 */
class WC_Shipping_Nova_Poshta_Postomat extends WC_Shipping_Method {
    public function __construct( $instance_id = 0 ) {
        $this->id = 'nova_poshta_postomat';
        $this->instance_id = absint( $instance_id );
        $this->method_title = __( 'Нова Пошта (поштомат)' );
        $this->method_description = __( 'Доставка Нова Пошта до поштомату.' );
        $this->supports = array(
            'shipping-zones',
            'instance-settings',
        );
        $this->instance_form_fields = array(
            'enabled' => array(
                'title' => __( 'Enable/Disable' ),
                'type' => 'checkbox',
                'label' => __( 'Enable this shipping method' ),
                'default' => 'yes',
            ),
            'title' => array(
                'title' => __( 'Method Title' ),
                'type' => 'text',
                'description' => __( 'This controls the title which the user sees during checkout.' ),
                'default' => __( 'Нова Пошта (поштомат)' ),
                'desc_tip' => true
            )
        );
        $this->enabled = $this->get_option( 'enabled' );
        $this->title = $this->get_option( 'title' );

        add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
    }

    /**
     * calculate_shipping function.
     * @param array $package (default: array())
     */
    public function calculate_shipping( $package = array() ) {
        $this->add_rate( array(
            'id' => $this->id . $this->instance_id,
            'label' => $this->title,
            'cost' => '',
        ) );
    }
}

/**
 * WC_Shipping_Nova_Poshta_Courier class.
 *
 * @class WC_Shipping_Nova_Poshta_Courier
 * @version 1.0.0
 * @package Shipping-for-WooCommerce/Classes
 * @category Class
 * @author BRiNPL
 */
class WC_Shipping_Nova_Poshta_Courier extends WC_Shipping_Method {
    public function __construct( $instance_id = 0 ) {
        $this->id = 'nova_poshta_courier';
        $this->instance_id = absint( $instance_id );
        $this->method_title = __( 'Кур’єр Нової Пошти' );
        $this->method_description = __( 'Доставка Нова Пошта за адресою кур’єром.' );
        $this->supports = array(
            'shipping-zones',
            'instance-settings',
        );
        $this->instance_form_fields = array(
            'enabled' => array(
                'title' => __( 'Enable/Disable' ),
                'type' => 'checkbox',
                'label' => __( 'Enable this shipping method' ),
                'default' => 'yes',
            ),
            'title' => array(
                'title' => __( 'Method Title' ),
                'type' => 'text',
                'description' => __( 'This controls the title which the user sees during checkout.' ),
                'default' => __( 'Кур’єр Нової Пошти' ),
                'desc_tip' => true
            )
        );
        $this->enabled = $this->get_option( 'enabled' );
        $this->title = $this->get_option( 'title' );

        add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
    }

    /**
     * calculate_shipping function.
     * @param array $package (default: array())
     */
    public function calculate_shipping( $package = array() ) {
        $this->add_rate( array(
            'id' => $this->id . $this->instance_id,
            'label' => $this->title,
            'cost' => '',
        ) );
    }
}