<?php $filters = fetch_data(-1);
require 'components/product-filter-head.php'; ?>
<div class="search-page__content d-flex align-items-start">
    <div class="search-page__filter">
        <?php require 'components/product-filter.php';
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