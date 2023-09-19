<?php
//change checkout titles
add_filter('gettext', 'wc_billing_ua_titles', 20, 3);
function wc_billing_ua_titles($translated_text, $text, $domain)
{
    switch ($translated_text) {
        case 'Billing & Shipping':
        case 'Оплата та доставка' :
            $translated_text = __('Контактні дані', 'woocommerce');
            break;
        case 'Your order':
        case 'Ваше замовлення' :
            $translated_text = __('Оберіть спосіб оплати', 'woocommerce');
            break;
    }
    return $translated_text;
}

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

// register shipping methods
add_filter( 'woocommerce_shipping_methods', 'register_new_shipping_methods' );
function register_new_shipping_methods( $methods ) {
    $methods[ 'nova_poshta_depart' ] = 'WC_Shipping_Nova_Poshta_Depart';
    $methods[ 'nova_poshta_postomat' ] = 'WC_Shipping_Nova_Poshta_Postomat';
    $methods[ 'nova_poshta_courier' ] = 'WC_Shipping_Nova_Poshta_Courier';
    $methods[ 'ukrposhta_depart' ] = 'WC_Shipping_Ukrposhta_Depart';

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

/**
 * WC_Shipping_Ukrposhta_Depart class.
 *
 * @class WC_Shipping_Ukrposhta_Depart
 * @version 1.0.0
 * @package Shipping-for-WooCommerce/Classes
 * @category Class
 * @author BRiNPL
 */
class WC_Shipping_Ukrposhta_Depart extends WC_Shipping_Method {
    public function __construct( $instance_id = 0 ) {
        $this->id = 'ukrposhta_depart';
        $this->instance_id = absint( $instance_id );
        $this->method_title = __( 'Укрпошта (відділення)' );
        $this->method_description = __( 'Доставка Укрпошта до відділення.' );
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
                'default' => __( 'Укрпошта (відділення)' ),
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