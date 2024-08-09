<?php
/**
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.1.4
 */
get_header();
$page   = get_query_var( 'page', 1 );
$search = fetch_data( 16 ); ?>
    <div class="shop-page wrapper filler">
		<?php
        woocommerce_breadcrumb();
		require "components/banner.php";
		require 'shop.php';
        ?>
    </div>
<?php get_footer();