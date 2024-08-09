<?php
function post_products_slider() {
	static $row_index = 0;

	if ( have_rows( 'post_sliders' ) && ! is_admin() ) {
		$row_count = count( get_field( 'post_sliders' ) );

		if ( $row_index < $row_count ) {
			the_row();

			$post_products_ids = get_sub_field( 'post_products' );

			$row_index ++;

			if ( ! empty( $post_products_ids ) ) :
				ob_start();
				?>

                <section class="post__products">
                    <hr>
                    <section class="post__products__slider">
                        <h4 class="font-16-22 fw-600">Рекомендовані продукти</h4>
                        <div class="post__products__items products-slider">
							<?php
							foreach ( $post_products_ids as $product_id ) {
								global $post;
								$post = get_post( $product_id );
								setup_postdata( $post );
								get_template_part( "components/product-item" );
								wp_reset_postdata();
							}
							?>
                        </div>
                        <button type="button"
                                class="post__products__prev products-slider__prev slider-arrow transition-default"
                                aria-label="Попередні товари">
                            <svg xmlns="http://www.w3.org/2000/svg" width="9" height="14" fill="none">
                                <path stroke="#363D44" stroke-linecap="round" stroke-width="2" d="M8 13 2 7l6-6"/>
                            </svg>
                        </button>
                        <button type="button"
                                class="post__products__next products-slider__next slider-arrow transition-default"
                                aria-label="Ще товари">
                            <svg xmlns="http://www.w3.org/2000/svg" width="9" height="14" fill="none">
                                <path stroke="#363D44" stroke-linecap="round" stroke-width="2" d="m1 1 6 6-6 6"/>
                            </svg>
                        </button>
                    </section>
                    <hr>
                </section>

				<?php
				return ob_get_clean();

			endif;
		}
	}

	return '';
}

add_shortcode( 'prod_slider', 'post_products_slider' );