<section class="account-page__reviews">
    <h2 class="account-page-title font-28-36 fw-600">Мої відгуки та питання</h2>
    <p class="account-page__reviews__subtitle font-14-20 fw-500">Переглядайте відповіді на Ваші питання та відгуки, які Ви залишали</p>
    <div class="account-page__reviews__sort d-flex">
        <button id="review" class="account-page__tab-button font-16-22 fw-500 transition-default active">Відгуки</button>
        <button id="question" class="account-page__tab-button font-16-22 fw-500 transition-default">Питання</button>
    </div>
    <div class="account-page__reviews__items">
        <?php $args = [
            'type' => 'review',
            'user_id' => $user_id,
            'meta_query' => [
                [
                    'key' => 'type',
                    'value' => 'review',
                ]
            ]
        ];
        $reviews = get_comments($args);
        if (!empty($reviews)) {
            foreach ($reviews as $review) {
                get_template_part('components/my-account/account-reviews-item', null, ['review' => $review]);
            }
        } else {
            get_template_part('components/my-account/reviews-empty', null, ['title' => 'Ви ще не залишали відгуки']);
        } ?>
    </div>
</section>
