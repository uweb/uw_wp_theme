<?php
/**
 * UW WordPress Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package uw_wp_theme
 */

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function uw_wp_theme_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on uw_wp_theme, use a find and replace
		* to change 'uw_wp_theme' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'uw_wp_theme', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Add theme support for Gallery post format
	add_theme_support( 'post-formats', array( 'gallery' ) );

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

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		)
	);

	// Set up the WordPress core custom background feature.
	// add_theme_support(
	// 	'custom-background', apply_filters(
	// 		'uw_wp_theme_custom_background_args', array(
	// 			'default-color' => 'ffffff',
	// 			'default-image' => '',
	// 		)
	// 	)
	// );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	// add_theme_support(
	// 	'custom-logo', array(
	// 		'height'      => 250,
	// 		'width'       => 250,
	// 		'flex-width'  => false,
	// 		'flex-height' => false,
	// 	)
	// );

	/**
	 * Add support for default block styles.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/extensibility/theme-support/#default-block-styles
	 */
	add_theme_support( 'wp-block-styles' );
	/**
	 * Add support for wide aligments.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/extensibility/theme-support/#wide-alignment
	 */
	add_theme_support( 'align-wide' );

	/**
	 * Add support for block color palettes.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/extensibility/theme-support/#block-color-palettes
	 */
	add_theme_support( 'editor-color-palette', array(
		array(
			'name'  => __( 'Dusty orange', 'uw_wp_theme' ),
			'slug'  => 'dusty-orange',
			'color' => '#ed8f5b',
		),
		array(
			'name'  => __( 'Dusty red', 'uw_wp_theme' ),
			'slug'  => 'dusty-red',
			'color' => '#e36d60',
		),
		array(
			'name'  => __( 'Dusty wine', 'uw_wp_theme' ),
			'slug'  => 'dusty-wine',
			'color' => '#9c4368',
		),
		array(
			'name'  => __( 'Dark sunset', 'uw_wp_theme' ),
			'slug'  => 'dark-sunset',
			'color' => '#33223b',
		),
		array(
			'name'  => __( 'Almost black', 'uw_wp_theme' ),
			'slug'  => 'almost-black',
			'color' => '#0a1c28',
		),
		array(
			'name'  => __( 'Dusty water', 'uw_wp_theme' ),
			'slug'  => 'dusty-water',
			'color' => '#41848f',
		),
		array(
			'name'  => __( 'Dusty sky', 'uw_wp_theme' ),
			'slug'  => 'dusty-sky',
			'color' => '#72a7a3',
		),
		array(
			'name'  => __( 'Dusty daylight', 'uw_wp_theme' ),
			'slug'  => 'dusty-daylight',
			'color' => '#97c0b7',
		),
		array(
			'name'  => __( 'Dusty sun', 'uw_wp_theme' ),
			'slug'  => 'dusty-sun',
			'color' => '#eee9d1',
		),
	) );

	/**
	 * Optional: Disable custom colors in block color palettes.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/extensibility/theme-support/
	 *
	 * add_theme_support( 'disable-custom-colors' );
	 */

	/**
	 * Add support for font sizes.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/extensibility/theme-support/#block-font-sizes
	 */
	add_theme_support( 'editor-font-sizes', array(
		array(
			'name'      => __( 'small', 'uw_wp_theme' ),
			'shortName' => __( 'S', 'uw_wp_theme' ),
			'size'      => 16,
			'slug'      => 'small',
		),
		array(
			'name'      => __( 'regular', 'uw_wp_theme' ),
			'shortName' => __( 'M', 'uw_wp_theme' ),
			'size'      => 20,
			'slug'      => 'regular',
		),
		array(
			'name'      => __( 'large', 'uw_wp_theme' ),
			'shortName' => __( 'L', 'uw_wp_theme' ),
			'size'      => 36,
			'slug'      => 'large',
		),
		array(
			'name'      => __( 'larger', 'uw_wp_theme' ),
			'shortName' => __( 'XL', 'uw_wp_theme' ),
			'size'      => 48,
			'slug'      => 'larger',
		),
	) );

}
add_action( 'after_setup_theme', 'uw_wp_theme_setup' );

/**
 * Set the embed width in pixels, based on the theme's design and stylesheet.
 *
 * @param array $dimensions An array of embed width and height values in pixels (in that order).
 * @return array
 */
function uw_wp_theme_embed_dimensions( array $dimensions ) {
	$dimensions['width'] = 720;
	return $dimensions;
}
add_filter( 'embed_defaults', 'uw_wp_theme_embed_dimensions' );

/**
 * Register Google Fonts
 */
function uw_wp_theme_fonts_url() {
	$fonts_url = '';

	/**
	 * Translator: If Open Sans does not support characters in your language, translate this to 'off'.
	 */
	$open_sans = esc_html_x( 'on', 'Open Sans font: on or off', 'uw_wp_theme' );
	$encode_sans = esc_html_x( 'on', 'Encode Sans font: on or off', 'uw_wp_theme' );

	$font_families = array();

	if ( 'off' !== $open_sans ) {
		$font_families[] = 'Open Sans:300i,400i,600i,700i,300,400,600,700';
	}

	if ( 'off' !== $encode_sans ) {
		$font_families[] = 'Encode Sans:400,600';
	}

	if ( in_array( 'on', array( $open_sans, $encode_sans ), true ) ) {
		$query_args = array(
			'family' => rawurlencode( implode( '|', $font_families ) ),
			'subset' => rawurlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}

/**
 * Add preconnect for Google Fonts.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function uw_wp_theme_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'uw_wp_theme-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'uw_wp_theme_resource_hints', 10, 2 );

/**
 * Enqueue WordPress theme styles within Gutenberg.
 */
function uw_wp_theme_gutenberg_styles() {
	$template_directory = get_bloginfo( 'template_directory' );
	$theme_version = wp_get_theme( get_template( ) )->get( 'Version' );

	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'uw_wp_theme-fonts', uw_wp_theme_fonts_url(), array(), null ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion

	// Enqueue main stylesheet.
	wp_enqueue_style( 'uw_wp_theme-base-style', $template_directory . '/css/editor-styles.css', array(), $theme_version );
}
add_action( 'enqueue_block_editor_assets', 'uw_wp_theme_gutenberg_styles' );

/**
 * Enqueue styles.
 */
function uw_wp_theme_styles() {

	$template_directory = get_bloginfo( 'template_directory' );
	$theme_version = wp_get_theme( get_template( ) )->get( 'Version' );

	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'uw_wp_theme-fonts', uw_wp_theme_fonts_url(), array(), null ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion

	// Enqueue main stylesheet.
	wp_enqueue_style( 'uw_wp_theme-base-style', $template_directory . '/style.css', array(), $theme_version );

	// Register component styles that are printed as needed.
	wp_enqueue_style( 'uw_wp_theme-bootstrap', $template_directory . '/css/bootstrap.css', array(), $theme_version );
	wp_enqueue_style( 'uw_wp_theme-content', $template_directory . '/css/content.css', array(), $theme_version );
	wp_enqueue_style( 'uw_wp_theme-sidebar', $template_directory . '/css/sidebar.css', array(), $theme_version );
	wp_enqueue_style( 'uw_wp_theme-widgets', $template_directory . '/css/widgets.css', array(), $theme_version );

}

add_action( 'wp_enqueue_scripts', 'uw_wp_theme_styles' );

/**
 * Enqueue scripts.
 */
function uw_wp_theme_scripts() {

	$template_directory = get_bloginfo( 'template_directory' );
	$theme_version = wp_get_theme( get_template( ) )->get( 'Version' );


	// Add jQuery, Bootstrap, and popper.js scripts.
	wp_deregister_script( 'jquery' ); // deregister first, just in case.

	wp_register_script( 'jquery', $template_directory . '/js/libs/jquery.min.js', array(), $theme_version, true );
	wp_enqueue_script( 'uw_wp_theme-bootstrap', $template_directory . '/js/libs/bootstrap.min.js', array( 'jquery', 'uw_wp_theme-popper' ), $theme_version, true );
	wp_enqueue_script( 'uw_wp_theme-popper', $template_directory . '/js/libs/popper.min.js', array(), $theme_version, true );
	wp_enqueue_script( 'uw_wp_theme-tinyscrollbar', $template_directory . '/js/libs/jquery.tinyscrollbar.js', array(), $theme_version, true );
	wp_enqueue_script( 'uw.bootstrap.shortcode-init', $template_directory . '/js/uw.bootstrap.shortcode-init.js', array(), $theme_version, true );

	// Add Backbone.js and Underscore.js - legacy UW2014 but using current versions of both!
	wp_enqueue_script( 'underscore' );
	wp_enqueue_script( 'backbone');

	// Enqueue skip-link-focus script.
	wp_enqueue_script( 'uw_wp_theme-skip-link-focus-fix', $template_directory . '/js/skip-link-focus-fix.js', array(), $theme_version, false );

	wp_script_add_data( 'uw_wp_theme-skip-link-focus-fix', 'defer', true );

	// Enqueue additional navmenu keyboard accessibility script.
	wp_enqueue_script( 'uw_wp_theme-keyboard-navmenu', $template_directory . '/js/keyboard-navmenu.js', array(), $theme_version, false );

	wp_script_add_data( 'uw_wp_theme-keyboard-navmenu', 'defer', true );

	// Enqueue additional button keyboard accessibility script.
	wp_enqueue_script( 'uw_wp_theme-keyboard-button', $template_directory . '/js/keyboard-button.js', array(), $theme_version, false );

	wp_script_add_data( 'uw_wp_theme-keyboard-button', 'defer', true );
}
add_action( 'wp_enqueue_scripts', 'uw_wp_theme_scripts' );

/**
 * Custom responsive image sizes.
 */
require get_template_directory() . '/inc/image-sizes.php';

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
 * Global filters (adopted from uw-2014)
 */
require get_template_directory() . '/inc/filters.php';

/**
 * Carryover from UW 2014 theme.
 */

if ( ! function_exists( 'setup_uw_object' ) ) {
	function setup_uw_object() {
		require get_template_directory() . '/inc/2014/class.uw.php';
		$UW = new UW();
		do_action( 'extend_uw_object', $UW );
		return $UW;
	}
}

$UW = setup_uw_object();

/**
 * Suppresses WordPress update notices to non-super admin. Also from 2014.
 */
if ( ! function_exists( 'suppress_updates' ) ) {
	/**
	 * If suppress_updates() does not exist elsewhere, use this suppress_updates() function to prevent showing update notices to non-admin users
	 */
	function suppress_updates() {
		if ( ( ! is_super_admin() ) && is_multisite() ) {
			remove_action( 'admin_notices', 'update_nag', 3 );
			remove_action( 'admin_notices', 'maintenance_nag', 10 );
			remove_action( 'network_admin_notices', 'update_nag', 3 );
			remove_action( 'network_admin_notices', 'maintenance_nag', 10 );
		}
	}
}
add_action( 'admin_head', 'suppress_updates', 1 );

/**
 * Theme shortcodes.
*/
require get_template_directory() . '/inc/shortcodes/shortcodes.php';


/**
 * Theme widgets.
 */
require get_template_directory() . '/inc/widgets/widgets.php';


// Register Custom Navigation Walker for the default Bootstrap menu (aka updated 2014 menu).
require get_template_directory() . '/inc/wp-bootstrap-navwalker.php';

// Register Custom Navigation Walker for the Mega Menu.
require get_template_directory() . '/inc/wp-bootstrap-megamenu-navwalker.php';

// Register Custom Navigation Walker for function.php.
require get_template_directory() . '/inc/theme-settings.php';

// Register Site Alert.
require get_template_directory() . '/inc/site-notif-banner.php';
