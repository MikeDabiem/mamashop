<div class="product-filter__head d-flex justify-content-between">
    <section class="product-filter__chosen transition-default d-flex align-items-center">
        <h6 class="product-filter__chosen-title font-13-16 fw-500">Обрані фільтри</h6>
        <div class="product-filter__chosen__items d-flex flex-wrap">
            <?php foreach ($_GET as $key => $value_arr) {
                if (str_contains($key, 'pa_')) {
                    foreach (explode(',', $value_arr) as $value) {
                        $filter_item_name = get_term_by('slug', "$value", "$key")->name; ?>
                        <div class="product-filter__chosen-item d-flex align-items-center" data-name="<?= $key . '_' . $value; ?>">
                            <p class="font-12-16 fw-400"><?= $filter_item_name; ?></p>
                            <label for="<?= $key . '_' . $value; ?>" class="product-filter__chosen-item-close transition-default d-flex">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="cross"><rect width="16" height="16" rx="8" fill="#494558"/><g id="Group 2088"><path id="Vector 73" d="M4.80078 4.80078L11.2007 11.2013" stroke="#F5E4E7" stroke-width="1.5"/><path id="Vector 74" d="M11.1992 4.80078L4.79928 11.2012" stroke="#F5E4E7" stroke-width="1.5"/></g></g></svg>
                            </label>
                        </div>
                    <?php }
                }
            } ?>
        </div>
    </section>
    <section class="product-filter__sort">
        <h6 class="d-none">Сортувати</h6>
        <div class="sort__select transition-default d-flex justify-content-between align-items-center">
            <p class="sort__select-chosen font-14-20 fw-500">За популярністю</p>
            <svg class="sort__select-arrow transition-default" xmlns="http://www.w3.org/2000/svg" width="13" height="8" fill="none"><path stroke-width="2" d="m11.3 1.1-5 5-5-5"/></svg>
            <?php $order_by = $_GET['sort'] ?? 'popular'; ?>
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