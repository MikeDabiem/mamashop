<?php $attributes_arr = [];
while ($filters->have_posts()): $filters->the_post();
    $product = wc_get_product();
    $attributes = $product->get_attributes();
    foreach ($attributes as $attribute) {
        $attr_id = $attribute->get_id();
        foreach ($attribute['options'] as $option_id) {
            if (!in_array($option_id, $attributes_arr)) {
                $attributes_arr[$attr_id][] = $option_id;
            }
        }
    }
endwhile;
ksort($attributes_arr, SORT_NATURAL);
foreach ($attributes_arr as $attr_id => $options) {
    $attr_name = wc_get_attribute($attr_id)->name;
    $attr_slug = wc_get_attribute($attr_id)->slug; ?>
    <div class="product-filter__spoiler transition-default d-flex justify-content-between align-items-center  <?php $attr_name !== 'Бренд' ? print 'hide' : null ?>" data-name="<?= $attr_slug; ?>">
        <h5 class="product-filter__spoiler-title font-14-20 fw-500"><?= $attr_name; ?></h5>
        <svg class="transition-default" xmlns="http://www.w3.org/2000/svg" width="13" height="8" fill="none"><path stroke="#3F383A" stroke-width="2" d="m11.3 1.1-5 5-5-5"/></svg>
    </div>
    <div class="product-filter__spoiler__content" data-name="<?= $attr_slug; ?>" <?php $attr_name !== 'Бренд' ? print 'style="display: none;"' : null ?>>
        <?php if ($attr_name === 'Бренд') { ?>
            <div class="product-filter__brand-filter d-flex">
                <input type="text" class="brand-filter__input font-12-16 fw-400" placeholder="Назва бренду">
                <button type="button" class="brand-filter__button">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="search"><path id="search_2" d="M21.6007 20.3993L17.8243 16.6229C19.0877 15.0928 19.85 13.1347 19.85 11C19.85 6.11977 15.8802 2.15 11 2.15C6.11977 2.15 2.15 6.11977 2.15 11C2.15 15.8802 6.11977 19.85 11 19.85C13.1347 19.85 15.0929 19.0877 16.6229 17.8243L20.3993 21.6007C20.5646 21.7661 20.7824 21.85 21 21.85C21.2173 21.85 21.4352 21.7673 21.6008 21.6006C21.9329 21.2695 21.9327 20.7312 21.6007 20.3993ZM3.85 11C3.85 7.05723 7.05723 3.85 11 3.85C14.9428 3.85 18.15 7.05723 18.15 11C18.15 14.9428 14.9428 18.15 11 18.15C7.05723 18.15 3.85 14.9428 3.85 11Z" fill="white" stroke="white" stroke-width="0.2"/></g></svg>
                </button>
            </div>
        <?php }
        $count = array_count_values($options);
        foreach (array_unique($options) as $option_id) {
            $term_name = get_term($option_id)->name;
            $term_slug = get_term($option_id)->slug;
            $term_tax = get_term($option_id)->taxonomy; ?>
            <div class="product-filter__check align-items-center">
                <input type="checkbox" name="<?= $term_tax; ?>" id="<?= $term_tax . '_' . $term_slug; ?>" value="<?= $term_slug; ?>" class="product-filter__check-checkbox checkbox transition-default">
                <label for="<?= $term_tax . '_' . $term_slug; ?>" class="product-filter__check-label option-label font-14-20 fw-400">
                    <span class="product-filter__check-label-title"><?= $term_name; ?></span>
                    <span class="product-filter__check-label-quant"><?= $count[$option_id]; ?></span>
                </label>
            </div>
        <?php }
        if (count($count) > 7) { ?>
            <div class="product-filter__spoiler__content__more--pad"></div>
            <div class="product-filter__spoiler__content__more d-flex align-items-center">
                <svg class="transition-default" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M12.5 5.75L8 10.25L3.5 5.75" stroke="#6757A9" stroke-width="1.5"/></svg>
                <p class="product-filter__spoiler__content__more-text font-13-16 fw-500">Показати ще <?= count($count) - 7; ?></p>
            </div>
        <?php } ?>
    </div>
<?php }