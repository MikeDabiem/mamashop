<div class="product-filter__head d-flex justify-content-between">
    <section class="product-filter__chosen transition-default d-flex align-items-center">
        <h6 class="product-filter__chosen-title font-13-16 fw-500">Обрані фільтри</h6>
        <div class="product-filter__chosen__items d-flex flex-wrap"></div>
    </section>
    <section class="product-filter__sort">
        <h6 class="d-none">Сортувати</h6>
        <div class="sort__select transition-default d-flex justify-content-between align-items-center">
            <p class="sort__select-chosen font-14-20 fw-500">За популярністю</p>
            <svg class="sort__select-arrow transition-default" xmlns="http://www.w3.org/2000/svg" width="13" height="8" fill="none"><path stroke-width="2" d="m11.3 1.1-5 5-5-5"/></svg>
            <?php $order_by = $_GET['sort'] ?? ''; ?>
            <input type="hidden" value="<?= $order_by; ?>" class="sort__select-input">
        </div>
        <div class="sort__menu">
            <?php $sortMenuItems = ['За популярністю' => 'popular',
                'Спочатку нові' => 'new',
                'За рейтингом' => 'rating',
                'Від дешевих до дорогих' => 'price-asc',
                'Від дорогих до дешевих' => 'price-desc',
                'Із найбільшою знижкою' => 'price-disc'
            ];
            foreach ($sortMenuItems as $name => $value) { ?>
                <div class="sort__menu__item transition-default d-flex justify-content-between align-items-center <?php $value === 'popular' ? print 'active' : null ?>" data-value="<?= $value; ?>">
                    <p class="sort__menu__item-title font-13-16 fw-500"><?= $name; ?></p>
                    <svg class="sort__menu__item-check transition-default" xmlns="http://www.w3.org/2000/svg" width="14" height="10" fill="none"><path stroke-width="2" d="M1.686 4.516 5.55 8.382l6.764-6.765"/></svg>
                </div>
            <?php } ?>
        </div>
    </section>
</div>