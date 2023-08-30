<?php /* Template Name: Account Template */
if (is_user_logged_in()) {
get_header();
$user = get_userdata(get_current_user_id()); ?>
<div class="account-page wrapper filler">
    <?php woocommerce_breadcrumb(); ?>
    <div class="account-page__content d-flex">
        <div class="account-page__col1">
            <div class="account__avatar d-flex">
                <div class="account__avatar-image img-wrapper-contain"></div>
                <div class="account__avatar__info">
                    <p class="account__avatar-name font-15-24 fw-600"><?= esc_attr($user->last_name) . ' ' . esc_attr($user->first_name) ?></p>
                    <p class="account__avatar-email font-14-20 fw-400"><?= esc_attr($user->user_email); ?></p>
                </div>
            </div>
            <a href="<?= esc_url(wc_get_account_endpoint_url('dashboard')); ?>" class="d-block">Персональні дані</a>
            <a href="<?= esc_url(wc_get_account_endpoint_url('orders')); ?>" class="d-block">Мої замовлення</a>
            <a href="<?= esc_url(wc_get_account_endpoint_url('favorites')); ?>" class="d-block">Улюблене</a>
            <a href="<?= esc_url(wc_get_account_endpoint_url('qna')); ?>" class="d-block">Мої відгуки та питання</a>
            <a href="<?= esc_url(wc_get_account_endpoint_url('security')); ?>" class="d-block">Безпека</a>
            <a href="<?= esc_url(wc_get_account_endpoint_url('customer-logout')); ?>" class="d-block">Вихід</a>
        </div>
        <div class="account-page__col2">
            <?php global $wp;
            if (is_account_page()) {
                if (is_wc_endpoint_url('orders')) { ?>
                    <h1>Мої замовлення</h1>
                <?php } elseif (isset($wp->query_vars['favorites'])) { ?>
                    <h1>Улюблене</h1>
                <?php } elseif (isset($wp->query_vars['qna'])) { ?>
                    <h1>Мої відгуки та питання</h1>
                <?php } elseif (isset($wp->query_vars['security'])) { ?>
                    <h1>Безпека</h1>
                    <form class="woocommerce-EditAccountForm edit-account" action="" method="post" <?php do_action('woocommerce_edit_account_form_tag'); ?> >
                        <legend><?php esc_html_e('Password change', 'woocommerce'); ?></legend>
                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                            <label for="account_display_name"><?php esc_html_e('Display name', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
                            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_display_name" id="account_display_name" value="<?= esc_attr($user->display_name); ?>" />
                        </p>
                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                            <label for="password_current"><?php esc_html_e('Current password (leave blank to leave unchanged)', 'woocommerce'); ?></label>
                            <input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_current" id="password_current" autocomplete="off" />
                        </p>
                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                            <label for="password_1"><?php esc_html_e('New password (leave blank to leave unchanged)', 'woocommerce'); ?></label>
                            <input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_1" id="password_1" autocomplete="off" />
                        </p>
                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                            <label for="password_2"><?php esc_html_e('Confirm new password', 'woocommerce'); ?></label>
                            <input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_2" id="password_2" autocomplete="off" />
                        </p>
                        <p>
                            <?php wp_nonce_field('save_account_details', 'save-account-details-nonce'); ?>
                            <button type="submit" class="woocommerce-Button button<?= esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>" name="save_account_details" value="<?php esc_attr_e('Save changes', 'woocommerce'); ?>"><?php esc_html_e('Save changes', 'woocommerce'); ?></button>
                            <input type="hidden" name="action" value="save_account_details" />
                        </p>
                    </form>
                <?php } else { ?>
                    <h1>Персональні данні</h1>
                    <form class="woocommerce-EditAccountForm edit-account" action="" method="post" <?php do_action('woocommerce_edit_account_form_tag'); ?> >
                        <fieldset class="edit-account__personal">
                            <legend class="font-16-22 fw-600">Особиста інформація</legend>
                            <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
                                <label for="account_first_name"><?php esc_html_e('Ім’я', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
                                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_first_name" id="account_first_name" autocomplete="given-name" value="<?= esc_attr($user->first_name); ?>" />
                            </p>
                            <p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
                                <label for="account_last_name"><?php esc_html_e('Прізвище', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
                                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_last_name" id="account_last_name" autocomplete="family-name" value="<?= esc_attr($user->last_name); ?>" />
                            </p>
                            <p class="woocommerce-form-row woocommerce-form-row--middle form-row form-row-middle">
                                <label for="account_middle_name"><?php esc_html_e('По-батькові', 'woocommerce'); ?></label>
                                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_middle_name" id="account_middle_name" autocomplete="middle-name" value="<?= esc_attr($user->middle_name); ?>" />
                            </p>
                            <p class="woocommerce-form-row woocommerce-form-row--phone form-row form-row-phone">
                                <label for="account_phone_name"><?php esc_html_e('Телефон', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
                                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_phone_name" id="account_phone_name" autocomplete="phone" value="<?= get_user_meta( get_current_user_id(), 'billing_phone', true ) ?>" />
                            </p>
                            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                <label for="account_display_name"><?php esc_html_e('Display name', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
                                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_display_name" id="account_display_name" value="<?= esc_attr($user->display_name); ?>" />
                            </p>
                            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                <label for="account_email"><?php esc_html_e('Email address', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
                                <input type="email" class="woocommerce-Input woocommerce-Input--email input-text" name="account_email" id="account_email" autocomplete="email" value="<?= esc_attr($user->user_email); ?>" />
                            </p>
                        </fieldset>
                        <filedset class="edit-account__birthday">
                            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                <label for="birthday"><?php esc_html_e('Date of birth', 'your-text-domain'); ?></label>
                                <input type="date" class="woocommerce-Input woocommerce-Input--text input-text" name="birthday" id="birthday" value="<?= esc_attr($user->birthday); ?>" />
                            </p>
                        </filedset>
                        <p>
                            <?php wp_nonce_field('save_account_details', 'save-account-details-nonce'); ?>
                            <button type="submit" class="woocommerce-Button button<?= esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>" name="save_account_details" value="<?php esc_attr_e('Save changes', 'woocommerce'); ?>"><?php esc_html_e('Save changes', 'woocommerce'); ?></button>
                            <input type="hidden" name="action" value="save_account_details" />
                        </p>
                    </form>
                <?php }
            } ?>
<!--            --><?php //the_content(); ?>
        </div>
    </div>
</div>
<?php get_footer();
} else {
    wp_redirect(get_home_url());
}