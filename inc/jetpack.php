<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package w314a
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function w314a_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'footer'    => 'page',
	) );
}
add_action( 'after_setup_theme', 'w314a_jetpack_setup' );
