<?php /* Template Name: Brands Template */
get_header();
$brands = get_field('brands', 'options'); ?>
<div class="brands-page wrapper filler">
    <?php woocommerce_breadcrumb(); ?>
    <h1 class="section-title">Бренди</h1>
    <?php $brands_count = count($brands); ?>
    <p class="products-count font-14-20 fw-400"><?= $brands_count . ' ' . true_wordform($brands_count, 'Бренд', 'Бренди', 'Брендів'); ?></p>
    <section class="brands">
    <div class="brands__items d-flex flex-wrap">
        <?php foreach ($brands as $brand) {
            require "components/brands-item.php";
        } ?>
    </div>
</div>
<?php get_footer();
