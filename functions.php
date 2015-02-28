<?php
/**
 * w314a functions and definitions
 *
 * @package w314a
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'w314a_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function w314a_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on w314a, use a find and replace
	 * to change 'w314a' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'w314a', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'w314a-featured-image', 648, 9999 );
	add_image_size( 'w314a-thumbnail-landscape', 330, 240, true );
	add_image_size( 'w314a-thumbnail-square', 330, 330, true );
	add_image_size( 'w314a-hero', 1230, 1230, true );
	
	
	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'w314a' ),
		'social'  => __( 'Social Links Menu', 'w314a' ),
		'footer'  => __( 'Footer Menu', 'w314a' ),
	) );
	

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link', 'status', 'gallery',
	) );
	/* Editor styles. */
	add_editor_style( get_stylesheet_uri() ); // otherwise create editor-style.css and use this file


	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'w314a_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
	
	// use bootstrap mobile navigation
	require( get_template_directory().'/inc/wp_bootstrap_navwalker.php');
}
endif; // w314a_setup
add_action( 'after_setup_theme', 'w314a_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function w314a_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'w314a' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer One', 'w314a' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Use this widget area to display widgets in the first column of the footer', 'w314a' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Two', 'w314a' ),
		'id'            => 'sidebar-3',
		'description'   => __( 'Use this widget area to display widgets in the second column of the footer', 'w314a' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Three', 'w314a' ),
		'id'            => 'sidebar-4',
		'description'   => __( 'Use this widget area to display widgets in the third column of the footer', 'w314a' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => __( 'Front Page Index', 'w314a' ),
		'id'            => 'sidebar-5',
		'description'   => __( 'Use this widget area to display widgets in the first column of your Front Page', 'w314a' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => __( 'Front Page One', 'w314a' ),
		'id'            => 'sidebar-6',
		'description'   => __( 'Use this widget area to display widgets in the first column of your Front Page', 'w314a' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => __( 'Front Page Two', 'w314a' ),
		'id'            => 'sidebar-7',
		'description'   => __( 'Use this widget area to display widgets in the second column of your Front Page', 'w314a' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => __( 'Front Page Three', 'w314a' ),
		'id'            => 'sidebar-8',
		'description'   => __( 'Use this widget area to display widgets in the third column of your Front Page', 'w314a' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );


	register_widget( 'w314a_popular_posts' );
	register_widget( 'w314a_category_widget' );
	register_widget( 'w31a_carousel_widget' );
}
add_action( 'widgets_init', 'w314a_widgets_init' );

/**
 * Include theme widgets
 */
require_once(get_template_directory() . '/widgets/widget-categories.php');
require_once(get_template_directory() . '/widgets/widget-carousel.php');
require_once(get_template_directory() . '/widgets/widget-popular-posts.php');

/**
 * Enqueue scripts and styles.
 */
function w314a_scripts() {
	// bootstrap inclusion 
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/bootstrap/css/bootstrap.min.css');
	wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/bootstrap/js/bootstrap.min.js', array('jquery'), '', true );
	// fontawesome inclusion see http://fortawesome.github.io/Font-Awesome/
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/font-awesome/css/font-awesome.min.css');
	
	// custom styles
	wp_enqueue_style( 'w314a-style', get_stylesheet_uri() );
	wp_enqueue_script( 'w314a-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );
	wp_enqueue_script( 'w314a-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'w314a-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20141010' );
	}
}
add_action( 'wp_enqueue_scripts', 'w314a_scripts' );



/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
