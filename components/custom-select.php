<div class="custom-select">
    <?php $selected_option = $options[0]; ?>
    <div class="custom-select__chosen transition-default d-flex justify-content-between align-items-center">
        <p class="custom-select__chosen-title font-13-16 fw-400"><?= $selected_option; ?></p>
        <svg class="custom-select-arrow transition-default" xmlns="http://www.w3.org/2000/svg" width="13" height="8" fill="none"><path stroke-width="2" d="m11.3 1.1-5 5-5-5"/></svg>
        <input type="hidden" value="<?= $selected_option; ?>" id="<?= $input_id ?? ''; ?>" class="custom-select-input">
    </div>
    <div class="custom-select__menu">
        <?php foreach ($options as $option) { ?>
            <div class="custom-select__menu__item transition-default d-flex justify-content-between align-items-center<?= $option === $selected_option ? ' active' : ''; ?>" data-value="<?= $option; ?>">
                <p class="custom-select__menu__item-title font-13-16 fw-400"><?= $option; ?></p>
                <svg class="custom-select__menu__item-check transition-default" xmlns="http://www.w3.org/2000/svg" width="14" height="10" fill="none"><path stroke-width="2" d="M1.686 4.516 5.55 8.382l6.764-6.765"/></svg>
            </div>
        <?php } ?>
    </div>
</div>
