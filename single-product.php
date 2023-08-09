<?php get_header();
the_post();
$id = get_the_ID();
$product = wc_get_product();
$price = $product->get_regular_price();
$sale_price = $product->get_sale_price();
$sale_val = get_post_meta($id, '_discount_value', true);
?>
<div class="single-product-page wrapper filler">
    <?php woocommerce_breadcrumb(); ?>
    <main class="single-product__info">
        <div class="info__main d-flex justify-content-between">
            <div class="info__main__col1">
                <div class="info__main__image">
                    <?php if ($sale_val) { ?>
                        <span class="sale-val font-16-22 fw-600">-<?= $sale_val; ?>%</span>
                    <?php } ?>
                    <div class="info__main__image-main img-wrapper-contain">
                        <?php
                        $thumb = get_the_post_thumbnail_url($id, "medium_large");
                        if ($thumb) {
                            $thumb_id = get_post_thumbnail_id($id);
                            $alt = get_post_meta($thumb_id, '_wp_attachment_image_alt', true); ?>
                            <img src="<?= $thumb; ?>" alt="<?= $alt; ?>">
                        <?php } else { ?>
                            <img src="<?php bloginfo('template_url'); ?>/images/eye-slash.svg" alt="no image" class="no-image">
                        <?php } ?>
                    </div>
                    <?php if ($thumb) {
                        $gallery_ids = $product->get_gallery_image_ids();
                        if (!empty($gallery_ids)) { ?>
                            <div class="info__main__image__gallery d-flex">
                                <img class="info__main__image-main--mini transition-default d-none" src="<?= $thumb; ?>" alt="<?= $alt; ?>">
                                <?php foreach($gallery_ids as $gallery_id) {
                                    $image_link = wp_get_attachment_url($gallery_id);
                                    $image_alt = get_post_meta($gallery_id, '_wp_attachment_image_alt', TRUE); ?>
                                    <img class="transition-default" src="<?= $image_link; ?>" alt="<?= $image_alt; ?>">
                                <?php } ?>
                            </div>
                        <?php }
                    } ?>
                </div>
            </div>
            <div class="info__main__col2">
                <h1 class="info__main-title font-32-45 fw-600"><?= get_the_title(); ?></h1>
                <div class="info__main-subtitle d-flex justify-content-between">
                    <div class="rating d-flex align-items-center">
                        <div class="rating__stars">
                            <div class="rating__stars-bg"></div>
                            <div class="rating__stars-val"></div>
                        </div>
                        <span class="rating__value font-13-16 fw-400"><?php
                            echo $rev_count = rand(1, 999);
                            echo ' ';
                            echo true_wordform($rev_count, 'Відгук', 'Відгуки', 'Відгуків');
                        ?></span>
                    </div>
                    <p class="sku font-13-16 fw-400"><span>Артикул: </span><?= $product->get_sku(); ?></p>
                </div>
                <?php if ($product->is_in_stock()) { ?>
                    <p class="info__main-in-stock font-13-16 fw-400">В наявності</p>
                <?php } else { ?>
                    <p class="info__main-out-stock font-13-16 fw-400">Немає в наявності</p>
                <?php } ?>
                <div class="info__main__price d-flex">
                    <p class="info__main__price-value font-18-22 fw-500"><?= $sale_price ? $sale_price : $price; ?> грн</p>
                    <?php if ($sale_price) { ?>
                        <p class="info__main__price-disc font-13-16 fw-400 text-decoration-line-through"><?= $price; ?> грн</p>
                    <?php } ?>
                </div>
                <div class="info__main__buttons d-flex">
                    <?php if ($product->is_in_stock()) { ?>
                        <button class="info__main__buy-btn std-btn purple-btn font-16-22 fw-600 transition-default">Купити</button>
                    <?php } else { ?>
                        <button class="info__main__buy-btn std-btn purple-btn font-16-22 fw-600 transition-default">Повідомити про появу</button>
                    <?php } ?>
                    <button class="single-product-fav std-btn d-flex justify-content-center align-items-center transition-default">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none"><path stroke-linecap="round" stroke-width="2" d="M22.166 10.24a5.188 5.188 0 0 0-1.336-2.175c-.522-.517-1.063-.859-1.606-1.065m-7.092-2.163c-1.952-1.239-5.106-2.41-7.829.367C-2.162 11.797 8.924 24.5 14 24.5c5.075 0 16.16-12.703 9.696-19.296-2.723-2.777-5.876-1.606-7.829-.367-1.103.7-2.632.7-3.735 0Z"/></svg>
                    </button>
                </div>
                <h4 class="info__main__specs-title font-16-22 fw-500">Характеристики:</h4>
                <div class="info__main__specs__items">
                    <?php $attributes = $product->get_attributes();
                    foreach ($attributes as $attribute) {
                        $attr_id = $attribute->get_id();
                        $attr_name = wc_get_attribute($attr_id)->name; ?>
                        <p class="info__main__specs__item font-13-16 fw-400">
                            <span class="info__main__specs__item-title"><?= $attr_name; ?>: </span>
                            <?php foreach ($attribute['options'] as $option_id) {
                                $term_name = get_term($option_id)->name;
                                $term_slug = get_term($option_id)->slug;
                                $term_tax = get_term($option_id)->taxonomy; ?>
                                <a href="<?= site_url(); ?>/?s&<?= $term_tax . '=' . $term_slug ?>" class="info__main__specs__item-value"><?= $term_name; ?></a>
                            <?php } ?>
                        </p>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="info__advanced d-flex justify-content-between align-items-start">
            <div class="info__advanced__col1">
                <div class="info__advanced__col1__heading d-flex">
                    <button id="about" class="tab-button active font-14-20 fw-500 transition-default">Про товар</button>
                    <button id="reviews" class="tab-button font-14-20 fw-500 transition-default">Відгуки</button>
                    <button id="questions" class="tab-button font-14-20 fw-500 transition-default">Питання</button>
                    <div class="tab-button--border transition-default"></div>
                </div>
                <div class="info__advanced__description info__advanced__tab active" data-name="about">
                    <?php $description = get_the_content();
                    if ($description) { ?>
                        <div class="description-text wysiwyg-styles"><?php the_content(); ?></div>
                    <?php } else { ?>
                        <div class="no-info__image img-wrapper-cover">
                            <img src="<?php bloginfo('template_url'); ?>/images/noinfo.png" alt="no info">
                        </div>
                        <h3 class="no-info__title font-20-24 fw-600 text-center">Нажаль більш детальної інформації по цьому товару немає</h3>
                    <?php } ?>
                </div>
                <div class="info__advanced__reviews info__advanced__tab" data-name="reviews">
                    <?php $reviews = [
                        [
                            'name' => 'Наталля Шевченко',
                            'date' => '10.06.2023',
                            'stars' => 4,
                            'text' => 'Нещодавно купляла цей засіб. Дуже задоволена. Вистачає його на довго, миє посуд дуже гарно. Що ще потрібно від гелю? :)'
                        ]
                    ];
                    if (!empty($reviews)) { ?>
                        <h3 class="reviews-title font-18-22 fw-500">Відгуки про товар</h3>
                        <div class="reviews__items">
                            <?php foreach ($reviews as $review) { ?>
                                <div class="reviews__item">
                                    <div class="reviews__item-head d-flex justify-content-between">
                                        <h4 class="reviews__item-name font-15-18 fw-500"><?= $review['name']; ?></h4>
                                        <time class="reviews__item-date font-11-13 fw-400"><?= $review['date']; ?></time>
                                    </div>
                                    <div class="reviews__item__stars">
                                        <?php $stars = $review['stars'];
                                        for ($i = 0; $i < 5; $i++) {
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
                                    <p class="reviews__item-text font-13-16 fw-400"><?= $review['text']; ?></p>
                                </div>
                            <?php } ?>
                        </div>
                        <button class="reviews__more std-btn pale-purple-btn font-16-22 fw-600">Показати ще</button>
                    <?php } else { ?>
                        <div class="no-info__image img-wrapper-cover">
                            <img src="<?php bloginfo('template_url'); ?>/images/noinfo.png" alt="no info">
                        </div>
                        <h3 class="no-info__title font-20-24 fw-600 text-center">У цього товару поки що немає відгуків</h3>
                        <p class="no-info__text font-14-20 fw-400 text-center">Станьте першим та поділіться своїм враженням!</p>
                    <?php } ?>
                </div>
                <div class="info__advanced__questions info__advanced__tab" data-name="questions">
                    <?php $questions = [
                        [
                            'q' => [
                                'name' => 'Наталля Шевченко',
                                'date' => '10.06.2023',
                                'status' => 'Покупець',
                                'q' => 'Чи можна замовити 1 штуку?'
                            ],
                            'a' => [
                                'name' => 'Представник Mamashop',
                                'date' => '11.06.2023',
                                'status' => 'Відповідь',
                                'a' => 'Так, звичайно!'
                            ]
                        ]
                    ];
                    if (!empty($questions)) { ?>
                        <h3 class="questions-title font-18-22 fw-500">Запитання про товар</h3>
                        <div class="questions__items">
                            <?php foreach ($questions as $question_arr) {
                                $question = $question_arr['q'];
                                $answer = $question_arr['a']; ?>
                                <div class="questions__item">
                                    <div class="questions__item-head d-flex justify-content-between">
                                        <h4 class="questions__item-name font-15-18 fw-500"><?= $question['name']; ?></h4>
                                        <time class="questions__item-date font-11-13 fw-400"><?= $question['date']; ?></time>
                                    </div>
                                    <p class="questions__item-status font-11-13 fw-400"><?= $question['status']; ?></p>
                                    <p class="questions__item-text font-13-16 fw-400"><?= $question['q']; ?></p>
                                    <div class="questions__item__answer">
                                        <div class="answer__head d-flex justify-content-between">
                                            <div class="answer__head__text d-flex align-items-baseline">
                                                <h5 class="answer-name font-13-16 fw-500"><?= $answer['name']; ?></h5>
                                                <span class="answer-status font-11-13 fw-400"><?= $answer['status']; ?></span>
                                            </div>
                                            <time class="questions__item-date font-11-13 fw-400"><?= $answer['date']; ?></time>
                                        </div>
                                        <p class="answer-text font-13-16 fw-400"><?= $answer['a']; ?></p>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } else { ?>
                        <div class="no-info__image img-wrapper-cover">
                            <img src="<?php bloginfo('template_url'); ?>/images/noinfo.png" alt="no info">
                        </div>
                        <h3 class="no-info__title font-20-24 fw-600 text-center">Питань поки що немає</h3>
                        <p class="no-info__text font-14-20 fw-400 text-center">Станьте першим та отримайте відповідь</p>
                    <?php } ?>
                </div>
            </div>
            <div class="info__advanced__col2 info__rating">
                <h2 class="info__rating-title font-36-44 fw-500">4.9</h2>
                <p class="info__rating-subtitle font-16-22 fw-400">Рейтинг товару</p>
                <div class="rating__stars">
                    <div class="rating__stars-bg"></div>
                    <div class="rating__stars-val"></div>
                </div>
                <div class="info__rating__percents d-flex justify-content-center align-items-center">
                    <p class="info__rating__percents-value fw-500">98%</p>
                    <p class="info__rating__percents-text font-14-20 fw-400">покупців рекомендують цей товар</p>
                </div>
                <button id="make-review__btn" class="info__rating-make-review std-btn purple-btn font-16-22 fw-600">Залишити відгук</button>
                <button id="ask-question__btn" class="info__rating-make-question std-btn pale-purple-btn font-16-22 fw-600">Запитати</button>
            </div>
        </div>
    </main>
    <section class="top products-slider">
        <h2 class="section-title">Вас також можуть зацікавити</h2>
        <div class="top__items products-slider__items">
            <?php $topProducts = new WP_Query(['post_type' => 'product', 'posts_per_page' => 10]);
            if ($topProducts->have_posts()): while ($topProducts->have_posts()): $topProducts->the_post();
                require "components/product-item.php";
            endwhile; endif;
            wp_reset_postdata(); ?>
        </div>
        <button type="button" class="top__prev products-slider__prev slider-arrow transition-default">
            <svg xmlns="http://www.w3.org/2000/svg" width="9" height="14" fill="none"><path stroke="#363D44" stroke-linecap="round" stroke-width="2" d="M8 13 2 7l6-6"/></svg>
        </button>
        <button type="button" class="top__next products-slider__next slider-arrow transition-default">
            <svg xmlns="http://www.w3.org/2000/svg" width="9" height="14" fill="none"><path stroke="#363D44" stroke-linecap="round" stroke-width="2" d="m1 1 6 6-6 6"/></svg>
        </button>
    </section>
    <div class="make-review blur-bg d-flex justify-content-center align-items-center">
        <form action="" id="review-form" class="review__form std-form">
            <svg class="std-form__close close-menu transition-default" xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none"><path d="M7 6L21.9993 21" stroke="#D9D9D9" stroke-width="2"/><path d="M22 6L7 20.9993" stroke="#D9D9D9" stroke-width="2"/></svg>
            <h2 class="std-form__main-title font-20-24 fw-600">Залиште свій відгук</h2>
            <h4 class="std-form__title font-16-22 fw-500">Оцініть товар</h4>
            <div class="std-form__stars d-flex">
                <input type="radio" id="0-stars" name="stars" class="d-none" value="0" checked>
                <?php for ($i = 0; $i < 5; $i++) { ?>
                    <label for="<?= ($i + 1); ?>-stars" class="std-form__stars-image transition-default" data-star="<?= ($i + 1); ?>">
                        <svg class="transition-default" xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21" fill="none">
                            <path d="M1.94537 9.33606C1.68433 9.09465 1.82613 8.65824 2.17921 8.61637L7.18223 8.0232C7.32613 8.00614 7.45113 7.91547 7.51182 7.78388L9.62203 3.20897C9.77095 2.8861 10.2299 2.88606 10.3789 3.20893L12.4891 7.78395C12.5498 7.91554 12.674 8.00615 12.8179 8.02321L17.8211 8.61637C18.1742 8.65824 18.3159 9.09468 18.0549 9.33608L14.3563 12.7567C14.2499 12.8551 14.2024 13.0018 14.2306 13.1439L15.2123 18.0854C15.2816 18.4342 14.9105 18.7039 14.6002 18.5302L10.204 16.0694C10.0776 15.9986 9.92356 15.9985 9.79711 16.0693L5.40051 18.5302C5.09025 18.7039 4.71871 18.4342 4.78801 18.0855L5.76991 13.1438C5.79816 13.0017 5.75072 12.8552 5.64433 12.7568L1.94537 9.33606Z"/>
                        </svg>
                    </label>
                    <input type="radio" id="<?= ($i + 1); ?>-stars" name="stars" class="form-stars d-none" value="<?= ($i + 1); ?>">
                <?php } ?>
            </div>
            <h4 class="std-form__title font-16-22 fw-500">Ваш відгук</h4>
            <textarea name="review-text" id="review-text" class="std-form__textarea font-12-16 fw-500 transition-default d-block" placeholder="Наприклад: Мені дуже сподобався цей товар!"></textarea>
            <button type="submit" class="std-form__submit std-btn purple-btn">Надіслати відгук</button>
        </form>
        <div class="std-form__success review-success d-none">
            <svg class="std-form__close close-menu transition-default" xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none"><path d="M7 6L21.9993 21" stroke="#D9D9D9" stroke-width="2"/><path d="M22 6L7 20.9993" stroke="#D9D9D9" stroke-width="2"/></svg>
            <div class="img-wrapper-contain">
                <img src="<?php bloginfo('template_url'); ?>/images/shield.png" alt="success">
            </div>
            <h2 class="success-title font-20-24 fw-600">Дякуємо за відгук!</h2>
            <p class="success-text font-14-20 fw-400">Ваш відгук буде опублікований одразу після проходження модерації.</p>
            <button class="success-button std-btn purple-btn">Зрозуміло</button>
        </div>
    </div>
    <div class="ask-question blur-bg d-flex justify-content-center align-items-center">
        <form action="" id="question-form" class="question__form std-form">
            <svg class="std-form__close close-menu transition-default" xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none"><path d="M7 6L21.9993 21" stroke="#D9D9D9" stroke-width="2"/><path d="M22 6L7 20.9993" stroke="#D9D9D9" stroke-width="2"/></svg>
            <h2 class="std-form__main-title font-20-24 fw-600">Напишіть своє питання</h2>
            <p class="std-form__main-subtitle font-14-20 fw-400">Ми відповімо вам найближчим часом</p>
            <h4 class="std-form__title font-16-22 fw-500">Ваше питання</h4>
            <textarea name="question-text" id="question-text" class="std-form__textarea font-12-16 fw-500 transition-default d-block" placeholder="Наприклад: Можу я замовити 1 товар?"></textarea>
            <button type="submit" class="std-form__submit std-btn purple-btn">Надіслати питання</button>
        </form>
        <div class="std-form__success question-success d-none">
            <svg class="std-form__close close-menu transition-default" xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none"><path d="M7 6L21.9993 21" stroke="#D9D9D9" stroke-width="2"/><path d="M22 6L7 20.9993" stroke="#D9D9D9" stroke-width="2"/></svg>
            <div class="img-wrapper-contain">
                <img src="<?php bloginfo('template_url'); ?>/images/shield.png" alt="success">
            </div>
            <h2 class="success-title font-20-24 fw-600">Дякуємо!</h2>
            <p class="success-text font-14-20 fw-400">Ваше питання опубліковано. Ми якомога швидше дамо на нього відповідь.</p>
            <button class="success-button std-btn purple-btn">Зрозуміло</button>
        </div>
    </div>
</div>
<?php get_footer();