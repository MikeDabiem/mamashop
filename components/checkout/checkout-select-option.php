<?php if (isset($args['name']) || isset($args['ref']) || isset($args['chosen_name'])) {
    $name = $args['name'];
    $ref = $args['ref'] ?? '';
    $chosen_name = $args['chosen_name'] ?? '';
?>
    <div class="checkout-select__menu__item transition-default d-flex justify-content-between align-items-center<?= $name === $chosen_name ? ' active' : ''; ?>" data-value="<?= esc_html($name); ?>" data-ref="<?= $ref ?>">
        <p class="checkout-select__menu__item-title font-13-16 fw-400"><?= $name; ?></p>
        <svg class="checkout-select__menu__item-check transition-default" xmlns="http://www.w3.org/2000/svg" width="14" height="10" fill="none"><path stroke-width="2" d="M1.686 4.516 5.55 8.382l6.764-6.765"/></svg>
    </div>
<?php }