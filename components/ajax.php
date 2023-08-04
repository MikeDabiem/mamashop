<?php if (wp_doing_ajax()) {
    add_action( 'wp_ajax_filter', 'products_filter' );
    add_action( 'wp_ajax_nopriv_filter', 'products_filter' );
    add_action( 'wp_ajax_hide_filters', 'hide_filters' );
    add_action( 'wp_ajax_nopriv_hide_filters', 'hide_filters' );
}

function fetch_data($posts_per_page, $tax_relation) {
    $sort_args = [];
    if ($_GET['sort']) {
        $orderby_value = wc_clean($_GET['sort']);
        $sort_args = match ($orderby_value) {
            'new' => [
                'orderby' => 'date',
                'order' => 'DESC',
            ],
            'price-asc' => [
                'orderby' => 'meta_value_num',
                'order' => 'ASC',
                'meta_key' => '_price',
            ],
            'price-desc' => [
                'orderby' => 'meta_value_num',
                'order' => 'DESC',
                'meta_key' => '_price',
            ],
            'rating' => [
                'orderby' => 'meta_value_num',
                'order' => 'DESC',
                'meta_key' => '_wc_average_rating',
            ],
            'price-disc' => [
                'orderby' => 'meta_value_num',
                'order' => 'DESC',
                'meta_key' => '_discount_value',
            ],
            default => [
                'orderby' => 'meta_value_num',
                'order' => 'DESC',
                'meta_key' => '_total_views_count',
            ],
        };
    }
    $price_args = [];
    if ($_GET['price']) {
        $price_args = [
            'meta_query' => [
                [
                    'key' => '_price',
                    'value' => wc_clean(explode('-', $_GET['price'])),
                    'type' => 'numeric',
                    'compare' => 'BETWEEN'
                ]
            ]
        ];
    }
    $filter_args = [
        'tax_query' => [
            'relation' => $tax_relation
        ]
    ];
    foreach (array_keys($_GET) as $key) {
        if (str_contains($key, 'pa_')) {
            $filter_args['tax_query'][] = [
                'taxonomy' => $key,
                'field' => 'slug',
                'terms' => explode(',', $_GET[$key])
            ];
        };
    }
    $args = [
        'post_type' => 'product',
        'posts_per_page' => $posts_per_page,
        'taxonomy' => 'product_cat',
        's' => $_GET['s'] ?: '',
        'paged' => $_GET['page'] ?: 1
    ];
    return new WP_Query(array_merge($args, $sort_args, $price_args, $filter_args));
}

function products_filter() {
    if ($_GET) {
        $query = fetch_data(16, 'AND');
        if ($query->have_posts()): ?>
            <div class="search-page__results__items d-flex flex-wrap">
                <?php while ($query->have_posts()): $query->the_post();
                    get_template_part('components/product-item');
                endwhile;
                wp_reset_postdata(); ?>
            </div>
            <div class="pagination">
                <?php $pagArrow = '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="8" fill="none"><path stroke-width="2" d="m11.3 1.1-5 5-5-5"/></svg>';
                echo paginate_links([
                    'base' => site_url() . '%_%',
                    'format' => '?page=%#%',
                    'prev_text' => $pagArrow,
                    'next_text' => $pagArrow,
                    'total' => $query->max_num_pages,
                    'current' => $_GET['page'] ?: 1
                ]); ?>
            </div>
        <?php else: ?>
            <div class="d-flex justify-content-center p-5">
                <h2>За заданими фільтрами нічого не знайдено</h2>
            </div>
        <?php endif;
        wp_reset_postdata();
    }
    wp_die();
}

function hide_filters() {
//    if (count(preg_grep("/pa_/", array_keys($_GET))) > 1) {
//        $filters = fetch_data(-1, 'AND');
//    } else {
        $filters = fetch_data(-1, 'AND');
//    }
    if ($filters->have_posts()):
        require "product-filter-content.php";
    else:
        $filters = new WP_Query([
            's' => get_search_query(),
            'post_type' => 'product',
            'posts_per_page' => -1,
            'paged' => $_GET['page'] ?: 1
        ]);
        require "product-filter-content.php";
    endif;
    wp_die();
}