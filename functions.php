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
	$blocks_enabled = get_option( 'enable-uw-blocks' );

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

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

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

	// Remove WooCommerce block CSS
	wp_dequeue_style( 'wc-blocks-style' );

	if ( ! isset( $blocks_enabled ) || $blocks_enabled !== '1' ) {
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

	/**
	 * Enable UW Blocks Support and related settings.
	 */
	if ( isset( $blocks_enabled ) && $blocks_enabled === '1' ) {
		add_theme_support( 'disable-custom-gradients' ); // disable custom gradients
		remove_theme_support( 'core-block-patterns' ); // remove core block patterns
		add_theme_support( 'editor-styles' ); // enable editor styles
		add_editor_style( 'editor-styles.css' );

		// use our custom color palette.
		add_theme_support( 'editor-color-palette', array(
			array(
				'name'  => __( 'Husky Purple', 'uw_wp_theme' ),
				'slug'  => 'husky-purple',
				'color' => '#32006e',
			),
			array(
				'name'  => __( 'Spirit Purple', 'uw_wp_theme' ),
				'slug'  => 'spirit-purple',
				'color' => '#4b2e83',
			),
			array(
				'name'  => __( 'Husky Gold', 'uw_wp_theme' ),
				'slug'  => 'husky-gold',
				'color' => '#b7a57a',
			),
			array(
				'name'  => __( 'Heritage Gold', 'uw_wp_theme' ),
				'slug'  => 'heritage-gold',
				'color' => '#85754d',
			),
			array(
				'name'  => __( 'Light Gold', 'uw_wp_theme' ),
				'slug'  => 'light-gold',
				'color' => '#e8e3d3',
			),
			array(
				'name'  => __( 'Accent Green', 'uw_wp_theme' ),
				'slug'  => 'accent-green',
				'color' => '#aadb1e',
			),
			array(
				'name'  => __( 'Accent Teal', 'uw_wp_theme' ),
				'slug'  => 'accent-teal',
				'color' => '#2ad2c9',
			),
			array(
				'name'  => __( 'Accent Pink', 'uw_wp_theme' ),
				'slug'  => 'accent-pink',
				'color' => '#e93cac',
			),
			array(
				'name'  => __( 'Accent Lavender', 'uw_wp_theme' ),
				'slug'  => 'accent-lavender',
				'color' => '#c5b4e3',
			),
			array(
				'name'  => __( 'White', 'uw_wp_theme' ),
				'slug'  => 'white',
				'color' => '#ffffff',
			),
			array(
				'name'  => __( 'Nearly Black', 'uw_wp_theme' ),
				'slug'  => 'nearly-black',
				'color' => '#373A3C',
			),
			array(
				'name'  => __( 'True Black', 'uw_wp_theme' ),
				'slug'  => 'true-black',
				'color' => '#000000',
			),
			array(
				'name'  => __( 'Very Light Gray', 'uw_wp_theme' ),
				'slug'  => 'very-light-gray',
				'color' => '#e5e4e2',
			),
			array(
				'name'  => __( 'Light Gray', 'uw_wp_theme' ),
				'slug'  => 'light-gray',
				'color' => '#d3d3d3',
			),
			array(
				'name'  => __( 'Lighter Gray', 'uw_wp_theme' ),
				'slug'  => 'lighter-gray',
				'color' => '#cccccc',
			),
			array(
				'name'  => __( 'Gray', 'uw_wp_theme' ),
				'slug'  => 'gray',
				'color' => '#d5d8de',
			),
			array(
				'name'  => __( 'Medium Gray', 'uw_wp_theme' ),
				'slug'  => 'medium-gray',
				'color' => '#808080',
			),)
		);

		/**
		 * Deregister core blocks
		 *
		 * @param [type] $allowed_block
		 * @return array
		 */
		function hide_default_blocks( $allowed_block ) {
			$blocks = WP_Block_Type_Registry::get_instance()->get_all_registered();
			unset(
				$blocks['core/details'],
				$blocks['core/navigation'],
				$blocks['core/quote'],
				$blocks['core/read-more'],
				$blocks['core/verse'],
			);

			return array_keys( $blocks );
		}
		add_filter( 'allowed_block_types_all', 'hide_default_blocks' );

		// WordPress core block styles can only be unregistered using JavaScript.
		function remove_core_editor_styles() {
			wp_enqueue_script(
				'uw-unregister-core-block-styles',
				get_theme_file_uri( '/assets/blocks/global/unregister-core-block-styles.js' ),
				array( 'wp-blocks', 'wp-dom' ),
				wp_get_theme()->get( 'Version' ),
				true
			);
		}
		add_action( 'admin_init', 'remove_core_editor_styles' );

		// use our custom font sizes.
		add_theme_support( 'editor-font-sizes', array(
			array(
				'name'      => __( 'Regular', 'uw_wp_theme' ),
				'shortName' => __( 'S', 'uw_wp_theme' ),
				'size'      => 17,
				'slug'      => 'regular',
			),
			array(
				'name'      => __( 'Medium', 'uw_wp_theme' ),
				'shortName' => __( 'M', 'uw_wp_theme' ),
				'size'      => 20,
				'slug'      => 'medium',
			),
			array(
				'name'      => __( 'Large', 'uw_wp_theme' ),
				'shortName' => __( 'L', 'uw_wp_theme' ),
				'size'      => 24,
				'slug'      => 'large',
			),
			array(
				'name'      => __( 'Larger', 'uw_wp_theme' ),
				'shortName' => __( 'XL', 'uw_wp_theme' ),
				'size'      => 28,
				'slug'      => 'larger',
			),
			array(
				'name'      => __( 'Largest', 'uw_wp_theme' ),
				'shortName' => __( 'XXL', 'uw_wp_theme' ),
				'size'      => 37,
				'slug'      => 'largest',
			),
		) );

		add_action( 'enqueue_block_assets', 'uw_wp_theme_enqueue_block_styles' );

		function uw_wp_theme_enqueue_block_styles() {
			$blocks = array(
				'core/button',
				'core/cloud',
				'core/comments',
				'core/cover',
				'core/embed',
				'core/file',
				'core/image',
				'core/list',
				'core/postslist',
				'core/pullquote',
				'core/rss',
				'core/queryloop',
				'core/table',
				'core/video',
			);
			// Loop through each block and enqueue its styles.
			foreach ( $blocks as $block ) {
				// remove core/ in filename.
				$slug = str_replace( 'core/', '', $block );
				wp_enqueue_block_style(
					$block,
					array(
						'handle' => "uw_wp_theme-block-{$slug}",
						'src'    => get_theme_file_uri( "assets/blocks/{$slug}/{$slug}.css" ),
						'path'   => get_theme_file_path( "assets/blocks/{$slug}/{$slug}.css" ),
					)
				);
			}
		}
		add_action( 'enqueue_block_assets', 'uw_wp_theme_enqueue_block_styles' );

		register_block_style( 'core/image', array(
			'name'         => 'bordered',
			'label'        => __( 'Bordered', 'uw_wp_theme' ),
			'inline_style' => '.wp-block-image.is-style-bordered img {
				border: 1px solid #ddd;
				padding: .25rem;
			}'
		) );

		register_block_style( 'core/image', array(
			'name'         => 'rounded',
			'label'        => __( 'Rounded', 'uw_wp_theme' ),
			'inline_style' => '.wp-block-image.is-style-rounded img {
				border-radius: 50%;
			}'
		) );

		function enqueue_custom_pullquote_toggle_script() {
			wp_enqueue_script(
				'custom-pullquote-toggle',
				get_template_directory_uri() . '/assets/blocks/pullquote/pullquote.js',
				array( 'wp-blocks', 'wp-element', 'wp-components', 'wp-compose', 'wp-edit-post', 'wp-editor', 'wp-hooks' ),
				filemtime( get_template_directory() . '/assets/blocks/pullquote/pullquote.js' )
			);
		}
		add_action( 'enqueue_block_assets', 'enqueue_custom_pullquote_toggle_script' );

		function enqueue_custom_video_script() {
			wp_enqueue_script(
				'uw_wp_theme-custom-video',
				get_template_directory_uri() . '/assets/blocks/video/video.js',
				array( 'wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-compose', 'wp-edit-post', 'wp-hooks' ),
				filemtime( get_template_directory() . '/assets/blocks/video/video.js' )
			);
		}
		add_action( 'enqueue_block_assets', 'enqueue_custom_video_script' );

		function enqueue_video_overlay_script() {
			wp_enqueue_script(
				'video-play-pause',
				get_template_directory_uri() . '/assets/blocks/video/video-play-pause.js', // Update this path if needed
				array(),
				null,
				true
			);
		}
		add_action( 'wp_enqueue_scripts', 'enqueue_video_overlay_script' );

    	function enqueue_cover_script() {
			wp_enqueue_script(
				'restrict-cover-block',
				get_template_directory_uri() . '/assets/blocks/cover/cover.js',
				array( 'wp-blocks', 'wp-editor', 'wp-dom-ready', 'wp-hooks' ),
				filemtime( get_template_directory() . '/assets/blocks/cover/cover.js' )
			);
		}
		add_action( 'enqueue_block_assets', 'enqueue_cover_script' );

		function restrict_cover_block_alignments( $settings, $post ) {
			if ( isset( $settings['supports']['align'] ) ) {
				$settings['supports']['align'] = [ 'full' ];
			}
			return $settings;
		}
		add_filter( 'block_type_metadata_settings', 'restrict_cover_block_alignments', 10, 2 );



		// This adds class names to query loop pagination parts so that it matches the posts archive pagination styles

		add_filter( 'render_block', 'add_class_to_list_block', 10, 2 );
		function add_class_to_list_block( $block_content, $block ) {

			if ( 'core/query-pagination' === $block['blockName'] ) {
				$block_content = new WP_HTML_Tag_Processor( $block_content );
				$block_content->next_tag(); /* first tag should always be ul or ol */
				$block_content->add_class( 'navigation pagination' );
				$block_content->get_updated_html();
			}
			if ( 'core/query-pagination-numbers' === $block['blockName'] ) {
				$block_content = new WP_HTML_Tag_Processor( $block_content );
				$block_content->next_tag(); /* first tag should always be ul or ol */
				$block_content->add_class( 'nav-links' );
				$block_content->get_updated_html();
			}

			if ( 'core/query-pagination-previous' === $block['blockName'] ) {
				$block_content = new WP_HTML_Tag_Processor( $block_content );
				$block_content->next_tag(); /* first tag should always be ul or ol */
				$block_content->add_class( 'prev page-numbers' );
				$block_content->get_updated_html();
			}
			if ( 'core/query-pagination-next' === $block['blockName'] ) {
				$block_content = new WP_HTML_Tag_Processor( $block_content );
				$block_content->next_tag(); /* first tag should always be ul or ol */
				$block_content->add_class( 'next page-numbers' );
				$block_content->get_updated_html();
			}

			return $block_content;
		}

		register_block_style( 'core/button', array(
			'name'         => 'default',
			'label'        => __( 'Default - Purple', 'uw_wp_theme' ),
			'is_default'   => true
		) );

		register_block_style( 'core/button', array(
			'name'         => 'goldbtn',
			'label'        => __( 'Gold', 'uw_wp_theme' ),
			'inline_style' => '.wp-block-button.is-style-goldbtn a, .wp-block-button.is-style-goldbtn div {
				background-color: var(--wp--preset--color--light-gold);
				color: var(--wp--preset--color--spirit-purple);
			}'
		) );
	}

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
 * Add wp-img class for modal popup reference. See /js/shortcodes/gallery.js
 */
add_filter('get_image_tag_class','uw_modal_add_image_class');

function uw_modal_add_image_class ( $class ) {
	$class .= ' wp-img';
	return $class;
}

/**
 * Register Google Fonts
 */
// function uw_wp_theme_fonts_url() {
// 	$fonts_url = '';

// 	/**
// 	 * Translator: If Open Sans does not support characters in your language, translate this to 'off'.
// 	 */
// 	$open_sans = esc_html_x( 'on', 'Open Sans font: on or off', 'uw_wp_theme' );
// 	$encode_sans = esc_html_x( 'on', 'Encode Sans font: on or off', 'uw_wp_theme' );

// 	$font_families = array();

// 	if ( 'off' !== $open_sans ) {
// 		$font_families[] = 'Open Sans:300i,400i,600i,700i,300,400,600,700';
// 	}

// 	if ( 'off' !== $encode_sans ) {
// 		$font_families[] = 'Encode Sans:400,600';
// 	}

// 	if ( in_array( 'on', array( $open_sans, $encode_sans ), true ) ) {
// 		$query_args = array(
// 			'family' => rawurlencode( implode( '|', $font_families ) ),
// 			'subset' => rawurlencode( 'latin,latin-ext' ),
// 		);

// 		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
// 	}

// 	return esc_url_raw( $fonts_url );
// }

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
 * Enqueue styles.
 */
function uw_wp_theme_styles() {

	$template_directory = get_bloginfo( 'template_directory' );
	$theme_version = wp_get_theme( get_template( ) )->get( 'Version' );

	// Add custom fonts, used in the main stylesheet.
	// wp_enqueue_style( 'uw_wp_theme-fonts', uw_wp_theme_fonts_url(), array(), null ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion

	// Enqueue main stylesheet.
	wp_enqueue_style( 'uw_wp_theme-base-style', $template_directory . '/style.css', array(), $theme_version );

	// Register component styles that are printed as needed.
	wp_enqueue_style( 'uw_wp_theme-bootstrap', $template_directory . '/css/bootstrap.css', array(), $theme_version );
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

// Register custom 404 content settings page.
require get_template_directory() . '/inc/custom-404-page.php';
