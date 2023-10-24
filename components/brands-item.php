<?php if (isset($brand)) {
    $brand_name = $brand->name;
    $brand_link = wc_get_page_permalink('shop') . '?pa_brand=' . $brand->slug; ?>
    <a href="<?= $brand_link ?>" class="brands-item img-wrapper-contain transition-default d-block">
        <img src="<?= $logo['brand_logo']; ?>" alt="<?= $brand_name; ?>" loading="lazy">
    </a>
<?php } ?>
