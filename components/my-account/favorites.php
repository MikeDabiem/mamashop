<?php
if (isset($args['user_id'])) $user_id = $args['user_id'];

$favorites = get_user_meta($user_id, 'favorites');
$refresh = false;

foreach ($favorites as $favorite) {
    if (get_post_status($favorite) !== 'publish') {
        delete_user_meta($user_id, 'favorites', $favorite);
        $refresh = true;
    }
}

if ($refresh) $favorites = get_user_meta($user_id, 'favorites');

$total = 0;
$fav_count = count($favorites);
?>
<section class="account-page__favorites">
    <h2 class="account-page-title font-28-36 fw-600">Улюблене</h2>
    <?php if (!empty($favorites)) { ?>
        <p class="favorites-count font-14-20 fw-500"><?= $fav_count . ' ' . true_wordform($fav_count, 'товар', 'товари', 'товарів') ?></p>
        <div class="favorites__items d-flex flex-wrap">
            <?php
            foreach ( $favorites as $favorite ) {
                require 'favorites-item.php';
            } ?>
        </div>
        <div class="favorites__footer">
            <div class="favorites__footer__info">
                <p class="favorites__footer__info-count font-14-20 fw-400"><?= $fav_count . ' ' . true_wordform($fav_count, 'товар', 'товари', 'товарів') ?> на суму</p>
                <p class="favorites__footer__info-total font-16-22 fw-500"><?= $total ?> грн</p>
            </div>
            <button class="favorites__footer-button std-btn purple-btn font-16-22 fw-600">Купити всі одразу</button>
        </div>
    <?php } else {
        require 'empty.php';
    } ?>
</section>
