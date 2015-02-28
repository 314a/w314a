<?php
/**
 * Sidebar with the footer widget areas.
 *
 * @package w314a
 */
?>

<?php if ( is_active_sidebar( 'sidebar-5' ) || is_active_sidebar( 'sidebar-6' ) || is_active_sidebar( 'sidebar-7' ) ) : ?>

	<div id="quinary" class="front-page-widget-area" role="complementary">
		<div class="front-page-widget-wrapper clear">
			<?php if ( is_active_sidebar( 'sidebar-6' ) ) : ?>
				<div class="front-page-widget">
					<?php dynamic_sidebar( 'sidebar-6' ); ?>
				</div><!-- .front-page-widget -->
			<?php endif; ?>

			<?php if ( is_active_sidebar( 'sidebar-7' ) ) : ?>
				<div class="front-page-widget">
					<?php dynamic_sidebar( 'sidebar-7' ); ?>
				</div><!-- .front-page-widget -->
			<?php endif; ?>

			<?php if ( is_active_sidebar( 'sidebar-8' ) ) : ?>
				<div class="front-page-widget">
					<?php dynamic_sidebar( 'sidebar-8' ); ?>
				</div><!-- .front-page-widget -->
			<?php endif; ?>
		</div><!-- .front-page-widget-wrapper -->
	</div><!-- #quinary -->

<?php endif; ?>