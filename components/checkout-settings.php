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