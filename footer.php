<footer class="footer">
    <div class="footer__top wrapper d-flex justify-content-between">
        <div class="footer__top__col1">
            <a href="<?= home_url(); ?>" class="footer-logo d-block">
                <img src="<?php bloginfo("template_url"); ?>/images/logo.png" alt="logo" class="contain-img">
            </a>
            <div class="footer__socials">
                <h6 class="footer__socials-title font-15-24 fw-500">Ми у соціальних мережах</h6>
                <div class="footer__socials__items d-flex">
                    <?php for ($s = 0; $s < 4; $s++) { ?>
                        <a href="#" class="d-block img-wrapper-contain"></a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="footer__top__col2 d-flex justify-content-between">
            <section class="footer__links">
                <h5 class="footer__links-title font-18-22 fw-600">Клієнтам</h5>
                <ul class="footer__links__items list-unstyled mb-0">
                    <?php for ($s = 0; $s < 6; $s++) { ?>
                        <li class="footer__links-item">
                            <a href="#" class="transition-default font-13-16 fw-500 d-block">Питання та відповіді</a>
                        </li>
                    <?php } ?>
                </ul>
            </section>
            <section class="footer__contacts">
                <h5 class="footer__contacts-title font-18-22 fw-600">Контактна інформація</h5>
                <div class="footer__contacts__content">
                    <a href="tel:+380447840000" class="footer__contacts-phone font-14-20 fw-500 d-block">044 784 00 00</a>
                    <a href="tel:+380447840000" class="footer__contacts-phone font-14-20 fw-500 d-block">044 784 00 00</a>
                    <p class="footer__contacts-phone-subtitle font-11-13 fw-500">Дзвінки згідно тарифів вашого оператора</p>
                    <p class="footer__contacts-schedule font-11-13 fw-500">Пн-Нд: <time>9:00</time>-<time>21:00</time></p>
                    <p class="footer__contacts-email">Email: <a href="mailto:mamash@emaila.net" class="transition-default">mamash@emaila.net</a></p>
                </div>
            </section>
        </div>
        <div class="footer__top__col3">
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
    </div>
    <div class="footer__bottom wrapper">
        <p class="footer__copyright font-9-11 fw-500 text-center">© Mamash 2023</p>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>