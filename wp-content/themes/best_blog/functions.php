<?php
/**
 * best_blog functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package best_blog
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function best_blog_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on best_blog, use a find and replace
		* to change 'best_blog' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'best_blog', get_template_directory() . '/languages' );

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
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'best_blog' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'best_blog_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'best_blog_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function best_blog_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'best_blog_content_width', 640 );
}
add_action( 'after_setup_theme', 'best_blog_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function best_blog_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'best_blog' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'best_blog' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'best_blog_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function best_blog_scripts() {
	wp_enqueue_style( 'best_blog-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'best_blog-style', 'rtl', 'replace' );

	wp_enqueue_script( 'best_blog-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'best_blog_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

//my functions

function best_blog_add_homepage_marker( $title ) {
	if (is_home()) {
		$title .= ' You are on homepage';
	}

    return $title;
}

add_filter( 'document_title', 'best_blog_add_homepage_marker' );

function best_blog_enqueue_styles($id, $src) {
    wp_enqueue_style( $id, $src,);
}

function best_blog_enqueue_critical_styles() {
	$src = get_template_directory_uri() . '/assets/css/critical.css';

	best_blog_enqueue_styles('best_blog_critical', $src);
}

add_action('wp_enqueue_scripts', 'best_blog_enqueue_critical_styles');

function best_blog_enqueue_default_styles() {
	$src = get_template_directory_uri() . '/assets/css/styles.css';
	
	best_blog_enqueue_styles('best_blog_styles', $src);
}

add_action('wp_footer', 'best_blog_enqueue_default_styles');

function best_blog_load_assets_in_footer() {
	$src = get_template_directory_uri() . '/assets/css/footer-styles.css';

	best_blog_enqueue_styles('best_blog_footer_styles', $src);
}

add_action('wp_footer', 'best_blog_load_assets_in_footer');

function best_blog_get_current_day_generate( ){
	return apply_filters('best_blog_get_current_day', date("d-m-Y"));
}

add_shortcode( 'get_current_day', 'best_blog_get_current_day_generate' );

function best_blog_add_one_day($date) {
	$timestamp = strtotime($date);

	return date('d-m-Y',  $timestamp + '86400');
}

add_filter('best_blog_get_current_day', 'best_blog_add_one_day');

function best_blog_body_class_filter( $classes,){
	if (is_home()) {
		$classes = [...$classes, 'hey-dude-it-is-blog'];
	}

	return $classes;
}

add_filter( 'body_class', 'best_blog_body_class_filter',);

function best_blog_allow_shortcode_in_title($title) {
	return do_shortcode($title);
}

add_filter('the_title', 'best_blog_allow_shortcode_in_title');