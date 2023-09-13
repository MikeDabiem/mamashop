<?php if ($args['title']) {
    $title = $args['title'];
} else {
    $title = 'Нічого не знайдено';
} ?>
<div class="reviews-empty d-flex justify-content-center align-items-center">
    <div class="reviews-empty__content">
        <div class="reviews-empty__image img-wrapper-contain">
            <img src="<?php bloginfo('template_url') ?>/images/noinfo.png" alt="no info">
        </div>
        <h4 class="reviews-empty-title font-20-24 fw-600 text-center"><?= $title ?></h4>
        <p class="reviews-empty-subtitle font-14-20 fw-400 text-center">Але це ніколи не пізно виправити:)</p>
    </div>
</div>