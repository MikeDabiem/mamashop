<section class="product-filter__chosen transition-default">
    <h6 class="product-filter__chosen-title font-13-16 fw-500">Обрані фільтри</h6>
    <div class="product-filter__chosen__items d-flex flex-wrap">
        <?php foreach ($_GET as $key => $value_arr) {
            if (str_contains($key, 'pa_')) {
                foreach (explode(',', $value_arr) as $value) {
                    $filter_item_name = get_term_by('slug', $value, $key)->name; ?>
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