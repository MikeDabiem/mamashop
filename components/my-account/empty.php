<?php
$page_name = '';
if (isset($wp->query_vars['orders'])) {
    $page_name = 'замовлень';
} elseif (isset($wp->query_vars['favorites'])) {
    $page_name = 'улюблених товарів';
} ?>
<div class="account-page__empty d-flex justify-content-center align-items-center">
    <section class="account-page__empty__body">
        <h4 class="empty-title font-20-24 fw-600 text-center">
            Список <?= $page_name ?> порожній
            <img class="align-bottom" src="<?php bloginfo('template_url') ?>/images/monocle.png" alt="empty" width="28" height="28">
        </h4>
        <p class="empty-subtitle font-14-20 fw-400 text-center">Зробіть покупку прямо зараз!</p>
        <a href="<?= get_home_url(); ?>/shop/" class="empty-button std-btn purple-btn font-16-22 fw-600 transition-default d-block text-decoration-none">За покупками</a>
    </section>
</div>