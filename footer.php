<footer class="footer">
    <?php if (!is_page('lost-password')) { ?>
        <div class="footer__top wrapper">
            <a href="<?= home_url(); ?>" class="footer__logo d-block">
                <img src="<?php bloginfo("template_url"); ?>/images/logo.svg" alt="logo" class="logo-img">
            </a>
            <div class="footer__pay">
                <h6 class="footer__pay-title font-15-18 fw-500">Приймаємо до оплати</h6>
                <div class="footer__pay__items d-flex flex-wrap">
                    <div class="footer__pay-item">
                        <img src="<?php bloginfo("template_url"); ?>/images/visa.png" alt="visa">
                    </div>
                    <div class="footer__pay-item img-wrapper-contain">
                        <img src="<?php bloginfo("template_url"); ?>/images/mastercard.png" alt="master-card">
                    </div>
                    <div class="footer__pay-item img-wrapper-contain">
                        <img src="<?php bloginfo("template_url"); ?>/images/applepay.png" alt="apple pay">
                    </div>
                    <div class="footer__pay-item img-wrapper-contain">
                        <img src="<?php bloginfo("template_url"); ?>/images/gpay.svg" alt="google pay">
                    </div>
                </div>
            </div>
            <section class="footer__links">
                <h5 class="footer__links-title font-18-22 fw-600">Клієнтам</h5>
                <?php wp_nav_menu([
                    'menu' => 'Info Page Menu',
                    'container' => 'nav',
                    'container_class' => 'footer__links__items'
                ]); ?>
            </section>
            <section class="footer__contacts">
                <h5 class="footer__contacts-title font-18-22 fw-600">Контактна інформація</h5>
                <div class="footer__contacts__content">
                    <?php $phones = get_field('phones', 'options');
                    $email = get_field('email', 'options');
                    if (!empty($phones)) {
                        foreach ($phones as $phone) { ?>
                            <a href="tel:+<?= preg_replace('/\D+/', '', $phone['phone_number']); ?>" class="footer__contacts-phone font-14-20 fw-500 d-block"><?= $phone['phone_number']; ?></a>
                        <?php }
                    } ?>
                    <p class="footer__contacts-phone-subtitle font-11-13 fw-500">Дзвінки згідно тарифів вашого оператора</p>
                    <p class="footer__contacts-schedule font-11-13 fw-500">Пн-Нд: <time>9:00</time>-<time>21:00</time></p>
                    <?php if ($email) { ?>
                        <p class="footer__contacts-email font-13-16 fw-500">Email: <a href="mailto:<?= $email; ?>" class="transition-default"><?= $email; ?></a></p>
                    <?php } ?>
                </div>
            </section>
        </div>
    <?php } ?>
    <div class="footer__bottom wrapper">
        <p class="footer__copyright font-9-11 fw-500 text-center">© Mamash 2023</p>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>