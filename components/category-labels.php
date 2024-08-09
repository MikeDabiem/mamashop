<?php
$id = $args['id'] ?? get_the_ID();
$categories  = get_the_category( $id );
if ( ! empty( $categories ) ) {
	foreach ( $categories as $category ) { ?>
		<a href="<?php echo get_term_link( $category->term_id, $category->taxonomy ); ?>"
		   class="blog-cat-label transition-default">
			<?php echo $category->name; ?>
		</a>
	<?php }
}