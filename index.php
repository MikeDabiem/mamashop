<?php /* Template Name: Home Template */
get_header(); ?>
    <div class="homepage wrapper filler">
		<?php require "components/banner.php"; ?>
        <button class="header__catalog header__catalog--body std-btn blue-btn font-15-24 fw-600 transition-default">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none">
                <path stroke-width="2"
                      d="M3.53 7.458c0-1.22 0-1.83.2-2.31A2.617 2.617 0 0 1 5.146 3.73c.481-.2 1.09-.2 2.31-.2s1.83 0 2.311.2c.641.265 1.15.775 1.417 1.416.199.481.199 1.09.199 2.31s0 1.83-.2 2.311a2.618 2.618 0 0 1-1.416 1.416c-.481.2-1.09.2-2.31.2s-1.83 0-2.31-.2A2.617 2.617 0 0 1 3.73 9.768c-.2-.481-.2-1.09-.2-2.31ZM16.618 7.458c0-1.22 0-1.83.2-2.31a2.617 2.617 0 0 1 1.416-1.417c.48-.2 1.09-.2 2.31-.2s1.83 0 2.31.2a2.617 2.617 0 0 1 1.417 1.416c.2.481.2 1.09.2 2.31s0 1.83-.2 2.311a2.617 2.617 0 0 1-1.416 1.416c-.482.2-1.091.2-2.31.2-1.22 0-1.83 0-2.311-.2a2.617 2.617 0 0 1-1.417-1.416c-.2-.481-.2-1.09-.2-2.31ZM3.53 20.545c0-1.22 0-1.83.2-2.31a2.617 2.617 0 0 1 1.416-1.417c.481-.2 1.09-.2 2.31-.2s1.83 0 2.311.2c.641.266 1.15.775 1.417 1.417.199.48.199 1.09.199 2.31s0 1.83-.2 2.31a2.618 2.618 0 0 1-1.416 1.417c-.481.2-1.09.2-2.31.2s-1.83 0-2.31-.2a2.618 2.618 0 0 1-1.417-1.416c-.2-.482-.2-1.091-.2-2.31ZM16.618 20.545c0-1.22 0-1.83.2-2.31a2.617 2.617 0 0 1 1.416-1.417c.48-.2 1.09-.2 2.31-.2s1.83 0 2.31.2a2.617 2.617 0 0 1 1.417 1.417c.2.48.2 1.09.2 2.31s0 1.83-.2 2.31a2.617 2.617 0 0 1-1.416 1.417c-.482.2-1.091.2-2.31.2-1.22 0-1.83 0-2.311-.2a2.617 2.617 0 0 1-1.417-1.416c-.2-.482-.2-1.091-.2-2.31Z"/>
            </svg>
            Каталог
        </button>
		<?php
		// products with max rating
		//    $top_products = new WP_Query([
		//        'post_type' => 'product',
		//        'posts_per_page' => 10,
		//        'orderby' => 'meta_value_num',
		//        'order' => 'DESC',
		//        'meta_key' => '_wc_average_rating',
		//        'meta_query' => [
		//            [
		//                'key' => '_stock_status',
		//                'value' => 'instock',
		//                'compare' => 'IN'
		//            ]
		//        ]
		//    ]);

		// top products from admin selection
		$top_products_ids = get_field( 'top_products' );
		$top_products     = new WP_Query( [
			'post_type'      => 'product',
			'posts_per_page' => - 1,
			'post__in'       => $top_products_ids ?: array( 0 )
		] );
		if ( $top_products->have_posts() ):
			?>
            <section class="top products-slider">
                <h2 class="section-title">Топ товари</h2>
                <div class="top__items products-slider__items">
					<?php
					while ( $top_products->have_posts() ): $top_products->the_post();
						get_template_part( "components/product-item" );
					endwhile;
					wp_reset_postdata();
					?>
                </div>
                <button type="button" class="top__prev products-slider__prev slider-arrow transition-default"
                        aria-label="Попередні товари">
                    <svg xmlns="http://www.w3.org/2000/svg" width="9" height="14" fill="none">
                        <path stroke="#363D44" stroke-linecap="round" stroke-width="2" d="M8 13 2 7l6-6"/>
                    </svg>
                </button>
                <button type="button" class="top__next products-slider__next slider-arrow transition-default"
                        aria-label="Ще товари">
                    <svg xmlns="http://www.w3.org/2000/svg" width="9" height="14" fill="none">
                        <path stroke="#363D44" stroke-linecap="round" stroke-width="2" d="m1 1 6 6-6 6"/>
                    </svg>
                </button>
            </section>
		<?php
		endif;

		require 'components/categories.php';

		// products with max sales rating
		//            $hit_products = new WP_Query([
		//                'post_type' => 'product',
		//                'posts_per_page' => 10,
		//                'meta_query' => [
		//                    'relation' => 'AND',
		//	                'stock_status' => [
		//		                'key' => '_stock_status',
		//		                'value' => 'instock',
		//		                'compare' => 'IN'
		//	                ],
		//                    'total_sales' => [
		//                        'key' => 'total_sales',
		//                        'type' => 'NUMERIC'
		//                    ]
		//                ],
		//                'orderby' => [
		//                    'total_sales' => 'DESC'
		//                ]
		//            ]);

		// hits products from admin selection
		$hit_products_ids = get_field( 'hit_products' );
		$hit_products     = new WP_Query( [
			'post_type'      => 'product',
			'posts_per_page' => - 1,
			'post__in'       => $hit_products_ids ?: array( 0 )
		] );

		if ( $hit_products->have_posts() ):
			?>
            <section class="hits products-slider">
                <h2 class="section-title">Хіти продажів</h2>
                <div class="hits__items products-slider__items">
					<?php
					while ( $hit_products->have_posts() ): $hit_products->the_post();
						get_template_part( "components/product-item" );
					endwhile;
					wp_reset_postdata();
					?>
                </div>
                <button type="button" class="hits__prev products-slider__prev slider-arrow transition-default"
                        aria-label="Попередні товари">
                    <svg xmlns="http://www.w3.org/2000/svg" width="9" height="14" fill="none">
                        <path stroke="#363D44" stroke-linecap="round" stroke-width="2" d="M8 13 2 7l6-6"/>
                    </svg>
                </button>
                <button type="button" class="hits__next products-slider__next slider-arrow transition-default"
                        aria-label="Ще товари">
                    <svg xmlns="http://www.w3.org/2000/svg" width="9" height="14" fill="none">
                        <path stroke="#363D44" stroke-linecap="round" stroke-width="2" d="m1 1 6 6-6 6"/>
                    </svg>
                </button>
            </section>
		<?php
		endif;
		$promos      = new WP_Query( [ 'post_type' => 'promo', 'posts_per_page' => 3 ] );
		$promos_link = get_field( 'promos_page', 'options' );
		if ( $promos->have_posts() && $promos->found_posts > 2 ): ?>
            <section class="promo">
                <h2 class="section-title">Акції</h2>
                <div class="promo__items">
					<?php while ( $promos->have_posts() ): $promos->the_post();
						require 'components/promo-item.php';
					endwhile;
					wp_reset_postdata(); ?>
                    <a href="<?= $promos_link; ?>"
                       class="promo__item promo__item__all transition-default d-flex justify-content-center align-items-center">
                        <p class="promo__item__all-text font-15-24 fw-600">Усі акції</p>
						<?php require "components/link-arrow.php"; ?>
                    </a>
                </div>
            </section>
		<?php endif; ?>
        <section class="brands">
            <h2 class="section-title">Бренди</h2>
            <div class="brands__items d-flex flex-wrap">
				<?php
				$brands_page_link = get_field( 'brands_page', 'options' );
				$brands           = get_terms( [ 'taxonomy' => 'pa_brand' ] );
				$brands_count     = 0;
				foreach ( $brands as $brand ) {
					$brand_logo = get_field( 'logo', $brand );

					if ( isset( $brand_logo ) ) {
						get_template_part( 'components/brands-item', null, [ 'brand' => $brand ] );

						$brands_count ++;
					}

					if ( $brands_count === 11 ) {
						break;
					}
				} ?>
                <a href="<?= $brands_page_link; ?>"
                   class="brands-item brands__link transition-default d-flex justify-content-center align-items-center">
                    <p class="brands__link-all font-15-24 fw-600">Усі бренди</p>
					<?php require "components/link-arrow.php"; ?>
                </a>
            </div>
        </section>
		<?php
		$blog_on = get_field( 'home_blog' );
		$blog     = new WP_Query( [
			'post_type'      => 'post',
            'post_status'    => 'publish',
			'posts_per_page' => 3,
		] );
		if ( $blog->have_posts() && $blog_on ): ?>
            <section class="blog">
                <h2 class="section-title">Блог</h2>
                <div class="blog__items">
                    <?php
                    while ( $blog->have_posts() ): $blog->the_post();
                        get_template_part( 'components/blog-item' );
                    endwhile;
                    ?>
                </div>
                <a href="<?php echo esc_url( get_home_url( null, '/blog' ) ); ?>"
                   class="blog__button transition-default">
                    <p class="promo__item__all-text font-15-24 fw-600">Усі статті</p>
                    <?php get_template_part('components/link-arrow'); ?>
                </a>
            </section>
			<?php endif;
		wp_reset_postdata();
		?>
    </div>
<?php get_footer();