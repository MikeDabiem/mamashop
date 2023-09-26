<?php if (isset($args['input_id']) || isset($args['options']) || isset($args['select_type'])) {
    $options = $args['options'] ?? null;
    $chosen_option = $args['chosen_option'] ?? null;
    $input_id = $args['input_id'] ?? null;
    $select_type = $args['select_type'] ?? null;
    $chosen_name = array_keys($chosen_option)[0];
?>
    <div class="checkout-select">
        <div class="checkout-select__chosen transition-default d-flex justify-content-between align-items-center">
            <p class="checkout-select__chosen-title font-13-16 fw-400"><?= $chosen_name ?></p>
            <svg class="checkout-select-arrow transition-default" xmlns="http://www.w3.org/2000/svg" width="13" height="8" fill="none"><path stroke-width="2" d="m11.3 1.1-5 5-5-5"/></svg>
            <input type="hidden" value="<?= $chosen_name ?>" id="<?= $input_id ?? ''; ?>" class="checkout-select-input">
            <input type="hidden" value="<?= $chosen_option[$chosen_name] ?>" id="<?= $input_id ?? ''; ?>-ref" class="checkout-select-ref">
        </div>
        <div class="checkout-select__menu">
            <?php if (isset($select_type)) {
                $name = $select_type === 'city' ? 'cty-srch' : $select_type . '-search';
                $placeholder = $select_type === 'ukrposhta_depart' ? 'Введіть поштовий індекс відділення' : 'Пошук'; ?>
                <div class="input__wrapper">
                    <input name="<?= $name ?>" id="<?= $name ?>" class="select-search-input checkout__input-item" type="text" placeholder="<?= $placeholder ?>">
                </div>
                <div class="checkout-select__menu__items"></div>
            <?php } else { ?>
                <div class="checkout-select__menu__items">
                    <?php foreach ($options as $name => $ref) {
                        get_template_part('components/checkout/checkout-select-option', null, ['name' => $name, 'ref' => $ref, 'chosen_name' => $chosen_name]);
                    } ?>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } else {
    echo 'Need more arguments';
}