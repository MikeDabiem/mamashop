<h2 class="account-page-title font-28-36 fw-600">Мої замовлення</h2>
<div class="account-page__orders">
    <?php if ($customer_orders) :
        $orders_count = wc_get_customer_order_count($user_id); ?>
        <p class="account-page__orders-count font-14-20 fw-500"><?= $orders_count . ' ' . true_wordform($orders_count, 'замовлення', 'замовлення', 'замовлень') ?></p>
        <div class="account-page__orders__sort d-flex">
            <button id="sort-all" class="account-page__orders__sort-button font-16-22 fw-500 transition-default active">Усі</button>
            <button id="sort-processing" class="account-page__orders__sort-button font-16-22 fw-500 transition-default">У процесі</button>
            <button id="sort-completed" class="account-page__orders__sort-button font-16-22 fw-500 transition-default">Виконані</button>
        </div>
        <div class="account-page__orders__items">
            <?php require 'orders-items.php'; ?>
        </div>
    <?php else:
        get_template_part('orders-empty.php');
    endif; ?>
</div>