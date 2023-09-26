<?php get_header(); ?>
<div class="404page wrapper filler d-flex flex-column align-items-center justify-content-center">
    <?php if (isset($_REQUEST['error'])) {
        if ($_REQUEST['error'] === 'expiredkey') { ?>
            <h5>Термін дії цього посилання закінчився</h5>
        <?php } elseif ($_REQUEST['error'] === 'invalidkey') { ?>
            <h5>Посилання не дійсне</h5>
        <?php } ?>
    <?php } else { ?>
        <h1>404</h1>
        <h5>Сторінку не знайдено</h5>
    <?php } ?>
    <div class="text-center mt-3">
        <a href="<?= home_url(); ?>">Повернутись на головну</a>
    </div>
</div>
<?php get_footer();
