<?php get_header();
$page = get_query_var('page', 1);
$search = fetch_data(16); ?>
<section class="search-page wrapper filler">
    <div class="breadcrumbs font-11-13 fw-400">
        <?php if ( function_exists('yoast_breadcrumb') ) {
            yoast_breadcrumb();
        } ?>
    </div>
    <h2 class="search-page-title section-title">Результати пошуку «<?= get_search_query(); ?>»</h2>
    <?php if ($search->have_posts()):
        require 'shop.php';
    else: ?>
        <div class="search-page__not-found d-flex justify-content-between">
            <div class="search-page__not-found__col1 d-flex">
                <div class="search-page__not-found-image img-wrapper-contain">
                    <img src="<?php bloginfo('template_url'); ?>/images/not-found.png" alt="not found">
                </div>
                <div class="search-page__not-found__col1__content">
                    <h3 class="col1__content-title font-20-24 fw-600">За запитом «<?= get_search_query(); ?>» нічого не знайдено</h3>
                    <p class="col1__content-help font-14-20 fw-400">Популярні запити:</p>
                    <div class="col1__content-help-variants">
                        <?php $popSearches = ['Порошок для прання', 'Шампунь для волосся', 'Плямовивідник', 'Гель для прання'];
                        foreach($popSearches as $popSearch) { ?>
                            <a href="<?= home_url(); ?>/?s=<?= str_replace(' ', '+', $popSearch); ?>" class="font-15-24 fw-500"><?= $popSearch; ?></a>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="search-page__not-found__col2">
                <h4 class="col2__advice-title">Поради для успішного пошуку:</h4>
                <ul class="col2__advice__list">
                    <li class="col2__advice__list-item">Розширте пошуковий запит, використовуючи більше або менше загальних слів</li>
                    <li class="col2__advice__list-item">Спробуйте шукати за типом продукту, брендом, номером моделі або функцією продукту</li>
                    <li class="col2__advice__list-item">Перевірте правопис ключових слів</li>
                </ul>
            </div>
        </div>
        <?php require 'components/categories.php';
    endif; ?>
</section>
<?php wp_reset_postdata();
get_footer();