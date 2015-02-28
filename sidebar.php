<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package w314a
 */
?>


	<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
	<div id="secondary" class="widget-area" role="complementary">
		<?php dynamic_sidebar( 'sidebar-1' );?>
	</div><!-- #secondary -->
	<?php endif; ?>

</div><!-- .content-wrapper -->
