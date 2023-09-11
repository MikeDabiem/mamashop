<?php if (isset($args['review']) && isset($args['prod_id'])) {
    $review = $args['review'];
    $product_id = $args['prod_id'];
}
$review_user = get_userdata($review->user_id);
$name = $review_user->display_name;
$date = get_comment_date('d.m.Y', $review->comment_ID);
$stars = get_comment_meta($review->comment_ID, 'rating', true);
$review_content = $review->comment_content; ?>
<div class="reviews__item">
    <div class="reviews__item-head d-flex justify-content-between">
        <h4 class="reviews__item-name font-15-18 fw-500"><?= $name; ?></h4>
        <time class="reviews__item-date font-11-13 fw-400"><?= $date; ?></time>
    </div>
    <?php if (wc_customer_bought_product('', $review->user_id, $product_id)) { ?>
        <p class="reviews__item-confirmed font-11-13 fw-400">Підтверджена покупка</p>
    <?php } ?>
    <div class="reviews__item__stars d-flex">
        <?php for ($i = 0; $i < 5; $i++) {
            if ($i < $stars) { ?>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21" fill="none">
                    <path d="M1.94498 9.33606C1.68393 9.09465 1.82573 8.65824 2.17882 8.61637L7.18183 8.0232C7.32574 8.00614 7.45073 7.91547 7.51143 7.78388L9.62163 3.20897C9.77055 2.8861 10.2295 2.88606 10.3785 3.20893L12.4887 7.78395C12.5494 7.91554 12.6736 8.00615 12.8175 8.02321L17.8207 8.61637C18.1738 8.65824 18.3155 9.09468 18.0545 9.33608L14.3559 12.7567C14.2495 12.8551 14.202 13.0018 14.2302 13.1439L15.2119 18.0854C15.2812 18.4342 14.9101 18.7039 14.5998 18.5302L10.2036 16.0694C10.0772 15.9986 9.92316 15.9985 9.79671 16.0693L5.40011 18.5302C5.08985 18.7039 4.71832 18.4342 4.78761 18.0855L5.76952 13.1438C5.79776 13.0017 5.75032 12.8552 5.64393 12.7568L1.94498 9.33606Z" fill="#F5C039"/>
                </svg>
            <?php } else { ?>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21" fill="none">
                    <path d="M1.94537 9.33606C1.68433 9.09465 1.82613 8.65824 2.17921 8.61637L7.18223 8.0232C7.32613 8.00614 7.45113 7.91547 7.51182 7.78388L9.62203 3.20897C9.77095 2.8861 10.2299 2.88606 10.3789 3.20893L12.4891 7.78395C12.5498 7.91554 12.674 8.00615 12.8179 8.02321L17.8211 8.61637C18.1742 8.65824 18.3159 9.09468 18.0549 9.33608L14.3563 12.7567C14.2499 12.8551 14.2024 13.0018 14.2306 13.1439L15.2123 18.0854C15.2816 18.4342 14.9105 18.7039 14.6002 18.5302L10.204 16.0694C10.0776 15.9986 9.92356 15.9985 9.79711 16.0693L5.40051 18.5302C5.09025 18.7039 4.71871 18.4342 4.78801 18.0855L5.76991 13.1438C5.79816 13.0017 5.75072 12.8552 5.64433 12.7568L1.94537 9.33606Z" fill="#E7E4DE"/>
                </svg>
            <?php }
        } ?>
    </div>
    <p class="reviews__item-text font-13-16 fw-400"><?= $review_content; ?></p>
</div>