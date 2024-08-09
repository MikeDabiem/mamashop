<?php
get_header();
the_post();

add_filter( 'woocommerce_get_breadcrumb', 'add_blog_breadcrumbs', 20, 2 );
function add_blog_breadcrumbs( $crumbs, $breadcrumb ) {
	if ( ! empty( $crumbs ) ) {
		$blog_crumb = array( 'Блог', home_url( '/blog' ) );
		array_splice( $crumbs, 1, 0, array( $blog_crumb ) );
	}

	return $crumbs;
}

$id         = get_the_ID();
$categories = get_the_category();
$title      = get_the_title();
$image      = get_the_post_thumbnail_url( $id, "large" );
$likes = get_post_meta($id, 'likes', true);
$likes_count = $likes ? count($likes) : 0;
$was_like = $likes && isset($_COOKIE['session_id']) && in_array($_COOKIE['session_id'], $likes) ? ' active' : '';
?>
    <main class="single-post-page wrapper filler">
		<?php woocommerce_breadcrumb(); ?>
        <article class="single__post">
            <div class="post__header">
                <div class="post__header__col1">
                    <div class="post__categories">
						<?php get_template_part('components/category-labels', null, array('id' => $id)); ?>
                    </div>
                    <h1 class="post__title font-36-44 fw-600"><?php echo $title; ?></h1>
                    <div class="post__actions">
                        <div class="post__like">
                            <button type="button" class="post__like__button transition-default<?php echo $was_like; ?>" data-post-id="<?php echo $id; ?>" aria-label="Мені подобається" title="Мені подобається">
                                <svg class="transition-default" xmlns="http://www.w3.org/2000/svg" width="28"
                                     height="28" fill="none">
                                    <path stroke-linecap="round" stroke-width="2"
                                          d="M22.166 10.24a5.188 5.188 0 0 0-1.336-2.175c-.522-.517-1.063-.859-1.606-1.065m-7.092-2.163c-1.952-1.239-5.106-2.41-7.829.367C-2.162 11.797 8.924 24.5 14 24.5c5.075 0 16.16-12.703 9.696-19.296-2.723-2.777-5.876-1.606-7.829-.367-1.103.7-2.632.7-3.735 0Z"/>
                                </svg>
                            </button>
                            <span class="post__like__count"><?php echo $likes_count; ?></span>
                        </div>
                    </div>
                </div>
				<?php if ( $image ) {
					$image_id = get_post_thumbnail_id( $id );
					$alt      = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
					?>
                    <div class="post__header__col2 img-wrapper-cover">
                        <img src="<?php echo $image; ?>" alt="<?php echo $alt; ?>">
                    </div>
				<?php } ?>
            </div>
            <div class="post__body wysiwyg-styles">
				<?php the_content(); ?>
                <div class="post__actions">
                    <div class="post__like">
                        <button type="button" class="post__like__button transition-default<?php echo $was_like; ?>" data-post-id="<?php echo $id; ?>" aria-label="Мені подобається" title="Мені подобається">
                            <svg class="transition-default" xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                                 fill="none">
                                <path stroke-linecap="round" stroke-width="2"
                                      d="M22.166 10.24a5.188 5.188 0 0 0-1.336-2.175c-.522-.517-1.063-.859-1.606-1.065m-7.092-2.163c-1.952-1.239-5.106-2.41-7.829.367C-2.162 11.797 8.924 24.5 14 24.5c5.075 0 16.16-12.703 9.696-19.296-2.723-2.777-5.876-1.606-7.829-.367-1.103.7-2.632.7-3.735 0Z"/>
                            </svg>
                        </button>
                        <span class="post__like__count"><?php echo $likes_count; ?></span>
                    </div>
                </div>
            </div>
        </article>
		<?php
		$more_posts = get_field( 'more_posts' );
		if ( !empty($more_posts) ):
			?>
            <section class="more__posts">
                <section class="more__posts__slider">
                    <h2 class="section-title">Читайте також</h2>
                    <div class="more__posts__items products-slider">
						<?php
						foreach ( $more_posts as $post_id ) {
                            if (get_post_status($post_id) === 'publish') {
	                            get_template_part('components/blog-item', null, array('id' => $post_id));
                            }
                        }
						?>
                    </div>
                    <button type="button"
                            class="more__posts__prev products-slider__prev slider-arrow transition-default"
                            aria-label="Попередні товари">
                        <svg xmlns="http://www.w3.org/2000/svg" width="9" height="14" fill="none">
                            <path stroke="#363D44" stroke-linecap="round" stroke-width="2" d="M8 13 2 7l6-6"/>
                        </svg>
                    </button>
                    <button type="button"
                            class="more__posts__next products-slider__next slider-arrow transition-default"
                            aria-label="Ще товари">
                        <svg xmlns="http://www.w3.org/2000/svg" width="9" height="14" fill="none">
                            <path stroke="#363D44" stroke-linecap="round" stroke-width="2" d="m1 1 6 6-6 6"/>
                        </svg>
                    </button>
                </section>
            </section>
		<?php endif; ?>
    </main>
<?php get_footer();
