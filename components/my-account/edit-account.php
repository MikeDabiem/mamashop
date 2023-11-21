<h2 class="account-page-title font-28-36 fw-600">Персональні данні</h2>
<form id="edit-account" class="woocommerce-EditAccountForm edit-account" method="post" <?php do_action('woocommerce_edit_account_form_tag'); ?> >
    <fieldset class="edit-account__personal">
        <legend class="font-16-22 fw-600 w-100">Особиста інформація</legend>
        <div class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first input__wrapper">
            <label for="account_first_name"><?php esc_html_e('Ім’я', 'woocommerce'); ?><abbr class="text-decoration-none" title="Обов'язкове поле">*</abbr></label>
            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text transition-default required" name="account_first_name" id="account_first_name" autocomplete="given-name" value="<?= esc_attr($user->first_name); ?>" />
            <p class="input--error-text font-9-11 fw-400">Заповніть будь ласка поле</p>
        </div>
        <div class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last input__wrapper">
            <label for="account_last_name"><?php esc_html_e('Прізвище', 'woocommerce'); ?><abbr class="text-decoration-none" title="Обов'язкове поле">*</abbr></label>
            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text transition-default required" name="account_last_name" id="account_last_name" autocomplete="family-name" value="<?= esc_attr($user->last_name); ?>" />
            <p class="input--error-text font-9-11 fw-400">Заповніть будь ласка поле</p>
        </div>
        <div class="woocommerce-form-row woocommerce-form-row--middle form-row form-row-middle input__wrapper">
            <label for="account_middle_name"><?php esc_html_e('По-батькові', 'woocommerce'); ?></label>
            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text transition-default" name="account_middle_name" id="account_middle_name" value="<?= esc_attr($user->middle_name); ?>" />
        </div>
        <div class="woocommerce-form-row woocommerce-form-row--phone form-row form-row-phone input__wrapper">
            <label for="account_phone"><?php esc_html_e('Телефон', 'woocommerce'); ?><abbr class="text-decoration-none" title="Обов'язкове поле">*</abbr></label>
            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text transition-default required" name="billing_phone" id="account_phone" autocomplete="phone" value="<?= get_user_meta( $user_id, 'billing_phone', true ) ?>" />
            <p class="input--error-text font-9-11 fw-400">Заповніть будь ласка поле</p>
        </div>
        <input type="hidden" class="woocommerce-Input woocommerce-Input--text input-text" name="account_display_name" id="account_display_name" value="<?= esc_attr($user->last_name . ' ' . $user->first_name); ?>" />
        <div class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide input__wrapper">
            <label for="account_email"><?php esc_html_e('Електронна пошта', 'woocommerce'); ?><abbr class="text-decoration-none" title="Обов'язкове поле">*</abbr></label>
            <input type="email" class="woocommerce-Input woocommerce-Input--email input-text transition-default required" name="account_email" id="account_email" autocomplete="email" value="<?= esc_attr($user->user_email); ?>" />
            <p class="input--error-text font-9-11 fw-400">Заповніть будь ласка поле</p>
        </div>
    </fieldset>
    <fieldset class="edit-account__birthday">
        <legend class="font-16-22 fw-600 w-100 m-0">Дата народження</legend>
        <p class="edit-account__birthday-subtitle font-13-16 fw-400">Ми хочемо вас привітати!</p>
        <div class="input__wrapper">
            <?php $type = esc_attr($user->birthday) ? 'date' : 'text'; ?>
            <input type="<?= $type; ?>" class="edit-account__birthday-input woocommerce-Input woocommerce-Input--text input-text font-13-16 fw-400 transition-default" name="birthday" id="birthday" value="<?= esc_attr($user->birthday); ?>" placeholder="ДД.ММ.РРРР" />
        </div>
    </fieldset>
    <p>
        <?php wp_nonce_field('save_account_details', 'save-account-details-nonce'); ?>
        <button type="submit" class="std-btn purple-btn font-16-22 fw-600 transition-default woocommerce-Button button<?= esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>" name="save_account_details" value="<?php esc_attr_e('Зберегти зміни', 'woocommerce'); ?>"><?php esc_html_e('Зберегти зміни', 'woocommerce'); ?></button>
        <input type="hidden" name="action" value="save_account_details" />
    </p>
</form>