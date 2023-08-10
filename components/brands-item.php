<?php if (isset($brand)) {
    $brand_name = $brand['brand_name'];
    $brand_logo = $brand['brand_logo'];
    if (isset($brand_logo) && isset($brand_name)) { ?>
        <a href="<?php site_url(); ?>/brand/<?= strtolower($brand_name); ?>" class="brands-item transition-default d-block">
            <img src="<?= $brand_logo; ?>" alt="<?= $brand_name; ?>">
        </a>
    <?php }
} ?>
