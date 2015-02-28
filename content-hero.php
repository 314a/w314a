<?php
/**
 * The template used for displaying hero content in page.php and page-templates.
 *
 * @package w314a
 */
?>
<div class="hero <?php echo w314a_additional_class(); ?>">
	<?php if ( ! is_page_template( 'page-templates/front-page.php' ) ) : ?>

		<?php the_title( '<div class="hero-wrapper"><h1 class="page-title">', '</h1></div>' ); ?>

	<?php else : ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php the_title( '<div class="hero-wrapper"><h1 class="page-title">', '</h1></div>' ); ?>
			<div class="entry-content">
				<?php the_content(); ?>
				<?php
					wp_link_pages( array(
						'before'      => '<div class="page-links">' . __( 'Pages:', 'w314a' ),
						'after'       => '</div>',
						'link_before' => '<span>',
						'link_after'  => '</span>',
					) );
				?>
			</div><!-- .entry-content -->
			<?php edit_post_link( __( 'Edit', 'w314a' ), '<footer class="entry-footer"><span class="edit-link">', '</span></footer>' ); ?>
		</article><!-- #post-## -->

	<?php endif; ?>
</div><!-- .hero -->
<?php
	if ( ! function_exists( 'jetpack_breadcrumbs' ) || 0 == get_theme_mod( 'w314a_breadcrumbs' ) || ! is_page() || is_page_template( 'page-templates/front-page.php' ) || is_front_page() ) {
		return;
	}
?>

<div class="breadcrumbs-wrapper">
	<?php jetpack_breadcrumbs(); ?>
</div><!-- .breadcrumbs-wrapper -->
