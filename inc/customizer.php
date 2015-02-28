<?php
/**
 * w314a Theme Customizer
 *
 * @package w314a
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function w314a_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';


	$wp_customize->add_section( 'w314a_theme_options', array(
		'title'    => __( 'Theme Options', 'w314a' ),
		'priority' => 130,
	) );
	
	/* Front Page: Featured Page One */
	$wp_customize->add_setting( 'w314a_featured_page_one_front_page', array(
		'default'           => '',
		'sanitize_callback' => 'w314a_sanitize_dropdown_pages',
	) );
	$wp_customize->add_control( 'w314a_featured_page_one_front_page', array(
		'label'             => __( 'Front Page: Featured Page One', 'w314a' ),
		'section'           => 'w314a_theme_options',
		'priority'          => 1,
		'type'              => 'dropdown-pages',
	) );

	/* Front Page: Featured Page Two */
	$wp_customize->add_setting( 'w314a_featured_page_two_front_page', array(
		'default'           => '',
		'sanitize_callback' => 'w314a_sanitize_dropdown_pages',
	) );
	$wp_customize->add_control( 'w314a_featured_page_two_front_page', array(
		'label'             => __( 'Front Page: Featured Page Two', 'w314a' ),
		'section'           => 'w314a_theme_options',
		'priority'          => 2,
		'type'              => 'dropdown-pages',
	) );

	/* Front Page: Featured Page Three */
	$wp_customize->add_setting( 'w314a_featured_page_three_front_page', array(
		'default'           => '',
		'sanitize_callback' => 'w314a_sanitize_dropdown_pages',
	) );
	$wp_customize->add_control( 'w314a_featured_page_three_front_page', array(
		'label'             => __( 'Front Page: Featured Page Three', 'w314a' ),
		'section'           => 'w314a_theme_options',
		'priority'          => 3,
		'type'              => 'dropdown-pages',
	) );
}
add_action( 'customize_register', 'w314a_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function w314a_customize_preview_js() {
	wp_enqueue_script( 'w314a_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'w314a_customize_preview_js' );

/**
 * Sanitize the dropdown pages.
 *
 * @param interger $input.
 * @return interger.
 */
function w314a_sanitize_dropdown_pages( $input ) {
	if ( is_numeric( $input ) ) {
		return intval( $input );
	}
}