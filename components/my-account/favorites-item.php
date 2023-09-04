<?php $id = $favorite;
$title = get_the_title($id);
$link = get_permalink($id);
$product = wc_get_product($id);
$brand = $product->get_attribute('pa_brand');
$price = $product->get_regular_price();
$salePrice = $product->get_sale_price();
$thumb = get_the_post_thumbnail_url($id, "medium");
$thumbID = get_post_thumbnail_id($id);
$alt = get_post_meta($thumbID, '_wp_attachment_image_alt', true); ?>
<div class="favorites__item d-flex">
    <a href="<?= $link ?>" class="favorites__item__col1 favorites__item__image img-wrapper-contain">
        <?php if($thumb) { ?>
            <img src="<?= $thumb; ?>" alt="<?= $alt; ?>">
        <?php } else { ?>
            <img src="<?php bloginfo('template_url'); ?>/images/eye-slash.svg" alt="no image" class="no-image">
        <?php } ?>
    </a>
    <div class="favorites__item__col2 w-100">
        <div class="favorites__item__info d-flex justify-content-between">
            <div class="favorites__item__info__col1">
                <a href="<?= $link ?>" class="favorites__item-title font-14-20 fw-500 d-block"><?= $title ?></a>
                <a href="<?= $link ?>" class="favorites__item-brand font-14-20 fw-400 d-block"><?= $brand ?></a>
                <div class="favorites__item__price d-flex align-items-start">
                    <p class="favorites__item__price-value font-15-24 fw-500"><?= $salePrice ?: $price; ?> грн</p>
                    <?php if ($salePrice) {
                        $total += $salePrice; ?>
                        <p class="favorites__item__price-disc font-12-16 fw-500 text-decoration-line-through"><?= $price; ?> грн</p>
                    <?php } else {
                        $total += $price;
                    } ?>
                </div>
            </div>
            <div class="favorites__item__info__col2">
                <button data-id="fav-<?= $id ?>" class="favorites__item-delete add-to-fav">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="24" viewBox="0 0 20 24" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.99967 0.351562C7.15771 0.351562 4.85384 2.65543 4.85384 5.4974V5.76823H1.33301C0.884276 5.76823 0.520508 6.132 0.520508 6.58073C0.520508 7.02946 0.884276 7.39323 1.33301 7.39323H18.6663C19.1151 7.39323 19.4788 7.02946 19.4788 6.58073C19.4788 6.132 19.1151 5.76823 18.6663 5.76823H15.1455V5.4974C15.1455 2.65543 12.8416 0.351562 9.99967 0.351562ZM9.99967 1.97656C11.9442 1.97656 13.5205 3.55289 13.5205 5.4974V5.76823H6.47884V5.4974C6.47884 3.55289 8.05517 1.97656 9.99967 1.97656Z" fill="#6757A9"/>
                        <path d="M3.2252 8.67054C3.18275 8.22382 2.78621 7.89609 2.33949 7.93854C1.89277 7.98098 1.56504 8.37753 1.60748 8.82425C1.70983 9.90139 1.89453 11.2286 2.13194 12.9345L2.43695 15.1262C2.72855 17.2222 2.89392 18.4109 3.25169 19.3846C3.91752 21.1968 5.10523 22.6496 6.63274 23.2942C7.46221 23.6442 8.41099 23.6439 9.82345 23.6433H10.1759C11.5884 23.6439 12.5371 23.6442 13.3666 23.2942C14.8941 22.6496 16.0818 21.1968 16.7477 19.3846C17.1054 18.4108 17.2708 17.2222 17.5624 15.1262L17.8674 12.9346C18.1048 11.2286 18.2895 9.90139 18.3919 8.82425C18.4343 8.37753 18.1066 7.98098 17.6599 7.93854C17.2131 7.89609 16.8166 8.22382 16.7741 8.67054C16.6755 9.70834 16.4959 11.0008 16.2552 12.7298L15.971 14.772C15.6563 17.0335 15.5122 18.0354 15.2223 18.8242C14.6635 20.3454 13.7341 21.3754 12.7348 21.7971C12.2471 22.0029 11.6563 22.0182 9.99967 22.0182C8.34308 22.0182 7.75223 22.0029 7.26451 21.7971C6.2652 21.3754 5.33588 20.3454 4.777 18.8242C4.4872 18.0354 4.34306 17.0336 4.02832 14.772L3.74412 12.7299C3.50349 11.0008 3.3238 9.70834 3.2252 8.67054Z" fill="#6757A9"/>
                        <path d="M8.64551 9.83073C8.64551 9.382 8.28174 9.01823 7.83301 9.01823C7.38428 9.01823 7.02051 9.382 7.02051 9.83073V18.4974C7.02051 18.9461 7.38428 19.3099 7.83301 19.3099C8.28174 19.3099 8.64551 18.9461 8.64551 18.4974V9.83073Z" fill="#6757A9"/>
                        <path d="M12.9788 9.83073C12.9788 9.382 12.6151 9.01823 12.1663 9.01823C11.7176 9.01823 11.3538 9.382 11.3538 9.83073V18.4974C11.3538 18.9461 11.7176 19.3099 12.1663 19.3099C12.6151 19.3099 12.9788 18.9461 12.9788 18.4974V9.83073Z" fill="#6757A9"/>
                    </svg>
                </button>
            </div>
        </div>
        <button class="favorites__item-buy std-btn purple-btn font-16-22 fw-600 w-100">Купити</button>
    </div>
</div>