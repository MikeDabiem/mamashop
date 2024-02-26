<?php /* Template Name: Brands Template */
get_header();
$brands = get_terms(['taxonomy' => 'pa_brand']);
$brands_logos = get_field('brands', 'options');
$brands_count = count($brands); ?>
<div class="brands-page wrapper filler">
    <?php woocommerce_breadcrumb(); ?>
    <h1 class="section-title">Бренди</h1>
    <p class="products-count font-14-20 fw-400"><?= $brands_count . ' ' . true_wordform($brands_count, 'Бренд', 'Бренди', 'Брендів'); ?></p>
    <section class="brands">
        <div class="brands__items d-flex flex-wrap">
            <?php foreach ($brands as $brand) {
                get_template_part('components/brands-item', null, ['brand' => $brand]);
            } ?>
        </div>
    </section>
</div>
<?php get_footer();
