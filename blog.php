<?php /* Template Name: Blog Template */
get_header();

$posts = new WP_Query( array(
	'post_type'      => 'post',
	'posts_per_page' => 12,
	'paged'          => $_GET['blogpage'] ?? 1,
) );
?>
    <div class="blog-page filler wrapper">
        <div class="blog__header">
            <h1 class="blog__title section-title"><?php echo esc_html( get_page_by_path( 'blog' )->post_title ); ?></h1>
            <div class="info-page__menu__select">
                <span class="font-16-22 fw-500">Оберіть рубрику</span>
                <svg class="transition-default" xmlns="http://www.w3.org/2000/svg" width="12" height="8"
                     viewBox="0 0 12 8" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M6 0.515625L12 6.51563L10.5953 7.92037L6 3.32512L1.40475 7.92037L0 6.51562L6 0.515625Z"
                          fill="#35237C"/>
                </svg>
            </div>
            <div class="blog__categories">
				<?php
				foreach ( get_categories() as $category ) {
					$name = $category->name;
					$link = get_term_link( $category->term_id, $category->taxonomy );
					?>
                    <a href="<?php echo esc_url( $link ); ?>"
                       class="blog__categories__item font-16-22 fw-400 transition-default"><?php echo esc_html( $name ); ?></a>
				<?php } ?>
            </div>
        </div>
		<?php woocommerce_breadcrumb(); ?>
        <div class="blog__items">
			<?php
			if ( $posts->have_posts() ): while ( $posts->have_posts() ): $posts->the_post();
				get_template_part( 'components/blog-item', null, array( 'excerpt' => true ) );
			endwhile; endif;
			wp_reset_postdata();
			?>
        </div>
		<?php
		$pagArrow   = '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="8" fill="none"><path stroke-width="2" d="m11.3 1.1-5 5-5-5"/></svg>';
		$pagination = paginate_links( [
			'format'    => '?blogpage=%#%',
			'prev_text' => $pagArrow,
			'next_text' => $pagArrow,
			'total'     => $posts->max_num_pages,
			'current'   => $_GET['blogpage'] ?? 1
		] );
		if ( $pagination ) { ?>
            <div class="pagination">
				<?php echo $pagination ?>
            </div>
		<?php } ?>
    </div>
<?php get_footer();