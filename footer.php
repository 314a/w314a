<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package w314a
 */
?>

	</div><!-- #content -->
		<?php get_sidebar( 'footer' ); ?>
	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-footer-wrapper">
			<div class="site-info">
				<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'w314a' ) ); ?>"><?php printf( __( ' %s', 'w314a' ), 'WordPress' ); ?></a>
				<span class="sep"> | </span>
				<?php printf( __( 'Theme: %1$s', 'w314a' ), '<a href="http://3.14a.ch" rel="designer">w314a</a>' ); ?>
			</div><!-- .site-info -->
			<?php if ( has_nav_menu( 'social' ) ) : ?>
				<nav id="social-navigation" class="social-navigation" role="navigation">
					<?php
						// Social links navigation menu.
						wp_nav_menu( array(
							'theme_location' => 'social',
							'depth'          => 1,
							'link_before'    => '<span class="screen-reader-text">',
							'link_after'     => '</span>',
						) );
					?>
				</nav><!-- .social-navigation -->
			<?php endif; ?>
			<?php if ( has_nav_menu( 'footer' ) ) : ?>
					<nav class="footer-navigation" role="navigation">
						<?php
							wp_nav_menu( array(
								'theme_location'  => 'footer',
								'menu_class'      => 'clear',
								'depth'           => 1,
							) );
						?>
					</nav><!-- .footer-navigation -->
			<?php endif; ?>
		</div> <!-- site-footer-wrapper -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
