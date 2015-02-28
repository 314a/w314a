<?php
/**
 * The template used for displaying featured page content in page-templates/front-page.php
 *
 * @package w314a
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php w314a_post_thumbnail(); ?>
	<?php the_title( sprintf( '<header class="entry-header"><h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1></header>' ); ?>

	<div class="entry-summary">
		<?php the_excerpt(); ?>
		<p><a class="more-link" href="<?php the_permalink(); ?>" rel="bookmark">
			<?php
				/* translators: %s: Name of page */
				printf( __( 'Read more %s', 'w314a' ), the_title( '<span class="screen-reader-text">', '</span>', false ) );
			?>
		</a></p>
	</div><!-- .entry-summary -->

	<?php edit_post_link( __( 'Edit', 'w314a' ), '<footer class="entry-footer"><span class="edit-link">', '</span></footer>' ); ?>
</article><!-- #post-## -->
