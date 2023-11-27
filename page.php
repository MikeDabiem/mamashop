<?php get_header();
$page_id = get_the_ID(); ?>
<div class="info-page wrapper filler">
    <?php woocommerce_breadcrumb(); ?>
    <div class="info-page__content">
        <h1 class="info-page-title section-title"><?php the_title() ?></h1>
        <div class="info-page__content__col1">
            <h4 class="info-page__content__col1-title font-16-22 fw-500">Оберіть тему питання:</h4>
            <div class="info-page__menu__select">
                <span class="font-16-22 fw-500"><?php the_title() ?></span>
                <svg class="transition-default" xmlns="http://www.w3.org/2000/svg" width="12" height="8" viewBox="0 0 12 8" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M6 0.515625L12 6.51563L10.5953 7.92037L6 3.32512L1.40475 7.92037L0 6.51562L6 0.515625Z" fill="#35237C"/>
                </svg>
            </div>
            <?php wp_nav_menu([
                'menu' => 'Info Page Menu',
                'container' => 'nav',
                'container_class' => 'info-page__menu'
            ]); ?>
        </div>
        <div class="info-page__content__col2">
            <?php if(is_page('Доставка')) {
                require "components/info-page/delivery.php";
            } elseif (is_page('Оплата')) {
                require "components/info-page/payment.php";
            } elseif (is_page('Повернення та гарантія')) {
                require "components/info-page/return.php";
            } elseif (is_page('Про нас')) {
                require "components/info-page/about.php";
            } elseif (is_page('Умови використання')) {
                require "components/info-page/terms.php";
            } elseif (is_page('Контакти')) {
                require "components/info-page/contacts.php";
            } else {
                wp_redirect(site_url() . '/404', 404);
                exit;
            } ?>
        </div>
    </div>
</div>
<?php get_footer();