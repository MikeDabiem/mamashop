<?php get_header();
$page = get_query_var('page', 1);
$search = new WP_Query([
    's' => get_search_query(),
    'post_type'      => 'product',
    'posts_per_page' => 16,
    'paged'          => $page,
    'orderby'        => 'meta_value_num',
    'order'          => 'DESC',
    'meta_key'       => '_total_views_count',
]); ?>
<section class="search-page wrapper filler">
    <div class="breadcrumbs font-11-13 fw-400">
        <?php if ( function_exists('yoast_breadcrumb') ) {
            yoast_breadcrumb();
        } ?>
    </div>
    <h2 class="search-page-title section-title">Результати пошуку «<?= get_search_query(); ?>»</h2>
    <?php if ($search->have_posts()):
        require 'components/product-filter-head.php'; ?>
        <div class="search-page__content d-flex align-items-start">
            <div class="search-page__filter">
                <?php $filters = new WP_Query(['s' => get_search_query(), 'post_type' => 'product', 'posts_per_page' => -1, 'paged' => $page]);
                require 'components/product-filter.php';
                wp_reset_postdata(); ?>
            </div>
            <div class="search-page__results d-flex flex-column">
                <div class="search-page__results__items d-flex flex-wrap">
                    <?php while ($search->have_posts()): $search->the_post();
                        require "components/product-item.php";
                    endwhile;
                    wp_reset_postdata(); ?>
                </div>
                <div class="pagination">
                    <?php $pagArrow = '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="8" fill="none"><path stroke-width="2" d="m11.3 1.1-5 5-5-5"/></svg>';
                    echo paginate_links([
                        'format' => '?page=%#%',
                        'prev_text' => $pagArrow,
                        'next_text' => $pagArrow,
                        'total' => $search->max_num_pages,
                        'current' => $page
                    ]); ?>
                </div>
            </div>
        </div>
    <?php else: ?>
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