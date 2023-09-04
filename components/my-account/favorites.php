<div class="account-page__favorites">
    <?php $favorites = get_user_meta($user_id, 'favorites');
    $fav_count = count($favorites);
    if (!empty($favorites)) { ?>
        <p class="favorites-count font-14-20 fw-500"><?= $fav_count . ' ' . true_wordform($fav_count, 'товар', 'товари', 'товарів') ?></p>
        <div class="favorites__items d-flex flex-wrap">
            <?php $total = 0;
            foreach ($favorites as $favorite) {
                require 'favorites-item.php';
            } ?>
        </div>
        <div class="favorites__footer d-flex justify-content-between align-items-center">
            <div class="favorites__footer__info">
                <p class="favorites__footer__info-count font-14-20 fw-400"><?= $fav_count . ' ' . true_wordform($fav_count, 'товар', 'товари', 'товарів') ?> на суму</p>
                <p class="favorites__footer__info-total font-16-22 fw-500"><?= $total ?> грн</p>
            </div>
            <button class="favorites__footer-button std-btn purple-btn font-16-22 fw-600">Купити всі одразу</button>
        </div>
    <?php } else {
        require 'empty.php';
    } ?>
</div>
