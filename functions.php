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
			'primary' => esc_html__( 'Primary', 'uw_wp_theme' ),
		)
	);

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
	add_theme_support(
		'custom-background', apply_filters(
			'uw_wp_theme_custom_background_args', array(
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
		'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => false,
			'flex-height' => false,
		)
	);

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

	/**
	 * Optional: Add AMP support.
	 *
	 * Add built-in support for the AMP plugin and specific AMP features.
	 * Control how the plugin, when activated, impacts the theme.
	 *
	 * @link https://wordpress.org/plugins/amp/
	 */
	add_theme_support( 'amp', array(
		'comments_live_list' => true,
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
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'uw_wp_theme-fonts', uw_wp_theme_fonts_url(), array(), null ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion

	// Enqueue main stylesheet.
	if ( is_multisite() ) {
		wp_enqueue_style( 'uw_wp_theme-base-style', network_site_url( '/wp-content/themes/uw_wp_theme/css/editor-styles.css' ), array(), '20180514' );
	} else {
		wp_enqueue_style( 'uw_wp_theme-base-style', get_theme_file_uri( '/css/editor-styles.css' ), array(), '20180514' );
	}
}
add_action( 'enqueue_block_editor_assets', 'uw_wp_theme_gutenberg_styles' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function uw_wp_theme_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'uw_wp_theme' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'uw_wp_theme' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4><span class="udub-slant-divider gold"><span></span></span>',
	) );
}
add_action( 'widgets_init', 'uw_wp_theme_widgets_init' );

/**
 * Enqueue styles.
 */
function uw_wp_theme_styles() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'uw_wp_theme-fonts', uw_wp_theme_fonts_url(), array(), null ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion

	// Enqueue main stylesheet.
	if ( is_multisite() ) {
		wp_enqueue_style( 'uw_wp_theme-base-style', network_site_url( '/wp-content/themes/uw_wp_theme/style.css' ), array(), '20180514' );
	} else {
		wp_enqueue_style( 'uw_wp_theme-base-style', get_stylesheet_uri(), array(), '20180514' );
	}

	// Register component styles that are printed as needed.
	if ( is_multisite() ) {
		wp_register_style( 'uw_wp_theme-bootstrap', network_site_url( '/wp-content/themes/uw_wp_theme/css/bootstrap.css' ), array(), '20190610' );
		wp_register_style( 'uw_wp_theme-comments', network_site_url( '/wp-content/themes/uw_wp_theme/css/comments.css' ), array(), '20180514' );
		wp_register_style( 'uw_wp_theme-content', network_site_url( '/wp-content/themes/uw_wp_theme/css/content.css' ), array(), '20180514' );
		wp_register_style( 'uw_wp_theme-sidebar', network_site_url( '/wp-content/themes/uw_wp_theme/css/sidebar.css' ), array(), '20180514' );
		wp_register_style( 'uw_wp_theme-widgets', network_site_url( '/wp-content/themes/uw_wp_theme/css/widgets.css' ), array(), '20180514' );
		wp_register_style( 'uw_wp_theme-front-page', network_site_url( '/wp-content/themes/uw_wp_theme/css/front-page.css' ), array(), '20180514' );
	} else {
		wp_register_style( 'uw_wp_theme-bootstrap', get_theme_file_uri( '/css/bootstrap.css' ), array(), '20190610' );
		wp_register_style( 'uw_wp_theme-comments', get_theme_file_uri( '/css/comments.css' ), array(), '20180514' );
		wp_register_style( 'uw_wp_theme-content', get_theme_file_uri( '/css/content.css' ), array(), '20180514' );
		wp_register_style( 'uw_wp_theme-sidebar', get_theme_file_uri( '/css/sidebar.css' ), array(), '20180514' );
		wp_register_style( 'uw_wp_theme-widgets', get_theme_file_uri( '/css/widgets.css' ), array(), '20180514' );
		wp_register_style( 'uw_wp_theme-front-page', get_theme_file_uri( '/css/front-page.css' ), array(), '20180514' );
	}
}
add_action( 'wp_enqueue_scripts', 'uw_wp_theme_styles' );

/**
 * Enqueue scripts.
 */
function uw_wp_theme_scripts() {

	// If the AMP plugin is active, return early.
	if ( uw_wp_theme_is_amp() ) {
		return;
	}

	// Enqueue the navigation script.
	if ( is_multisite() ) {
		wp_enqueue_script( 'uw_wp_theme-navigation', network_site_url( '/wp-content/themes/uw_wp_theme/js/navigation.js' ), array(), '20180514', false );
	} else {
		wp_enqueue_script( 'uw_wp_theme-navigation', get_theme_file_uri( '/js/navigation.js' ), array(), '20180514', false );
	}

	wp_script_add_data( 'uw_wp_theme-navigation', 'async', true );
	wp_localize_script( 'uw_wp_theme-navigation', 'uw_wp_themeScreenReaderText', array(
		'expand'   => __( 'Expand child menu', 'uw_wp_theme' ),
		'collapse' => __( 'Collapse child menu', 'uw_wp_theme' ),
	));

	// Add jQuery, Bootstrap, and popper.js scripts.
	wp_deregister_script( 'jquery' ); // deregister first, just in case.

	if ( is_multisite() ) {
		wp_register_script( 'jquery', network_site_url( '/wp-content/themes/uw_wp_theme/js/libs/jquery.min.js' ), array(), '20190610', true );
		wp_enqueue_script( 'uw_wp_theme-bootstrap', network_site_url( '/wp-content/themes/uw_wp_theme/js/libs/bootstrap.min.js' ), array( 'jquery', 'uw_wp_theme-popper' ), '20190610', true );
		wp_enqueue_script( 'uw_wp_theme-popper', network_site_url( '/wp-content/themes/uw_wp_theme/js/libs/popper.min.js' ), array(), '20190610', true );
		wp_enqueue_script( 'uw_wp_theme-tinyscrollbar', network_site_url( '/wp-content/themes/uw_wp_theme/js/libs/jquery.tinyscrollbar.js' ), array(), '20200124', true );
	} else {
		wp_register_script( 'jquery', get_theme_file_uri( '/js/libs/jquery.min.js' ), array(), '20190610', true );
		wp_enqueue_script( 'uw_wp_theme-bootstrap', get_theme_file_uri( '/js/libs/bootstrap.min.js' ), array( 'jquery', 'uw_wp_theme-popper' ), '20190610', true );
		wp_enqueue_script( 'uw_wp_theme-popper', get_theme_file_uri( '/js/libs/popper.min.js' ), array(), '20190610', true );
		wp_enqueue_script( 'uw_wp_theme-tinyscrollbar', get_theme_file_uri( '/js/libs/jquery.tinyscrollbar.js' ), array(), '20200124', true );
	}

	// Add Backbone.js and Underscore.js - legacy UW2014 but using current versions of both!
	if ( is_multisite() ) {
		wp_enqueue_script( 'wp-underscore', network_site_url( '/wp-includes/js/underscore.min.js' ), array(), '1.8.3', true );
		wp_enqueue_script( 'uw_wp_theme-backbone', network_site_url( '/wp-content/themes/uw_wp_theme/js/libs/backbone-min.js' ), array(), '20190619', true );
	} else {
		wp_enqueue_script( 'underscore' );
		wp_enqueue_script( 'uw_wp_theme-backbone', get_theme_file_uri( '/js/libs/backbone-min.js' ), array(), '20190619', true );
	}

	/**
	 * OPL theme stuff. Only needed for UW Public Lectures.
	 */
	if ( false !== strpos( $_SERVER['REQUEST_URI'], 'lectures' ) ) {
		// if the uri includes 'lectures', load this stylesheet.
		wp_enqueue_style( 'opl-style', network_site_url( '/wp-content/themes/uw_wp_theme/pluggable/lectures/public-lectures.css' ), array(), '20200218' );
	}

	// Enqueue skip-link-focus script.
	if ( is_multisite() ) {
		wp_enqueue_script( 'uw_wp_theme-skip-link-focus-fix', network_site_url( '/wp-content/themes/uw_wp_theme/js/skip-link-focus-fix.js' ), array(), '20180514', false );
	} else {
		wp_enqueue_script( 'uw_wp_theme-skip-link-focus-fix', get_theme_file_uri( '/js/skip-link-focus-fix.js' ), array(), '20180514', false );
	}

	wp_script_add_data( 'uw_wp_theme-skip-link-focus-fix', 'defer', true );

	// Enqueue comment script on singular post/page views only.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}
add_action( 'wp_enqueue_scripts', 'uw_wp_theme_scripts' );

/**
 * Custom responsive image sizes.
 */
require get_template_directory() . '/inc/image-sizes.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/pluggable/custom-header.php';

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
 * Optional: Add theme support for lazyloading images.
 *
 * @link https://developers.google.com/web/fundamentals/performance/lazy-loading-guidance/images-and-video/
 */
require get_template_directory() . '/pluggable/lazyload/lazyload.php';

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
 * Social theme feed stuff. Only needed for UW social.
*/
// require get_template_directory() . '/pluggable/social/social-feeds.php';

/**
 * Theme shortcodes.
*/
require get_template_directory() . '/inc/shortcodes/shortcodes.php';

// Register Custom Navigation Walker for function.php
require get_template_directory() . '/inc/wp-bootstrap-navwalker.php';


// Register Custom Navigation Walker for function.php
require get_template_directory() . '/inc/theme-settings.php';
