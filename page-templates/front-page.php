<?php
/**
 * Template Name: Front Page
 *
 * @package w314a
 */

get_header(); ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<?php get_template_part( 'content', 'hero' ); ?>

	<?php endwhile; ?>

	<?php rewind_posts(); ?>

	<?php if ( is_active_sidebar( 'sidebar-5' ) ) : ?>
		<div class="front-page-widget-index">
			<?php dynamic_sidebar( 'sidebar-5' ); ?>
		</div><!-- .front-page-index-widget -->
	<?php endif; ?>
	
<?php w314a_featured_pages(); ?>
<?php get_sidebar( 'front-page' ); ?>
<?php get_footer(); ?>