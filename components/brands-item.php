<?php
if (isset($args['brand'])) {
    $brand = $args['brand'];
    $brand_logo = get_field('logo', $brand);
    $brand_name = $brand->name;
    $brand_link = wc_get_page_permalink('shop') . '?pa_brand=' . $brand->slug;
    if (isset($brand_logo)) { ?>
        <a href="<?= $brand_link ?>" class="brands-item img-wrapper-contain transition-default d-block">
            <img src="<?= $brand_logo ?>" alt="<?= $brand_name ?>" loading="lazy">
        </a>
    <?php }
}?>
