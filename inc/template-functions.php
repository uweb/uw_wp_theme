<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package uw_wp_theme
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function uw_wp_theme_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	if ( is_active_sidebar( 'sidebar-1' ) ) {
		global $template;
		if ( 'front-page.php' !== basename( $template ) ) {
			$classes[] = 'has-sidebar';
		}
	}

	return $classes;
}
add_filter( 'body_class', 'uw_wp_theme_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function uw_wp_theme_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'uw_wp_theme_pingback_header' );

/**
 * Adds async/defer attributes to enqueued / registered scripts.
 *
 * If #12009 lands in WordPress, this function can no-op since it would be handled in core.
 *
 * @link https://core.trac.wordpress.org/ticket/12009
 * @param string $tag    The script tag.
 * @param string $handle The script handle.
 * @return array
 */
function uw_wp_theme_filter_script_loader_tag( $tag, $handle ) {

	foreach ( array( 'async', 'defer' ) as $attr ) {
		if ( ! wp_scripts()->get_data( $handle, $attr ) ) {
			continue;
		}

		// Prevent adding attribute when already added in #12009.
		if ( ! preg_match( ":\s$attr(=|>|\s):", $tag ) ) {
			$tag = preg_replace( ':(?=></script>):', " $attr", $tag, 1 );
		}

		// Only allow async or defer, not both.
		break;
	}

	return $tag;
}

add_filter( 'script_loader_tag', 'uw_wp_theme_filter_script_loader_tag', 10, 2 );

/**
 * Generate preload markup for stylesheets.
 *
 * @param object $wp_styles Registered styles.
 * @param string $handle The style handle.
 */
function uw_wp_theme_get_preload_stylesheet_uri( $wp_styles, $handle ) {
	$preload_uri = $wp_styles->registered[ $handle ]->src . '?ver=' . $wp_styles->registered[ $handle ]->ver;
	return $preload_uri;
}

/**
 * Adds preload for in-body stylesheets depending on what templates are being used.
 * Disabled when AMP is active as AMP injects the stylesheets inline.
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Preloading_content
 */
function uw_wp_theme_add_body_style() {

	// If AMP is active, do nothing.
	if ( uw_wp_theme_is_amp() ) {
		return;
	}

	// Get registered styles.
	$wp_styles = wp_styles();

	$preloads = array();

	// Preload content.css.
	$preloads['uw_wp_theme-content'] = uw_wp_theme_get_preload_stylesheet_uri( $wp_styles, 'uw_wp_theme-content' );

	// Preload sidebar.css and widget.css.
	if ( is_active_sidebar( 'sidebar-1' ) ) {
		$preloads['uw_wp_theme-sidebar'] = uw_wp_theme_get_preload_stylesheet_uri( $wp_styles, 'uw_wp_theme-sidebar' );
		$preloads['uw_wp_theme-widgets'] = uw_wp_theme_get_preload_stylesheet_uri( $wp_styles, 'uw_wp_theme-widgets' );
	}

	// Preload comments.css.
	if ( ! post_password_required() && is_singular() && ( comments_open() || get_comments_number() ) ) {
		$preloads['uw_wp_theme-comments'] = uw_wp_theme_get_preload_stylesheet_uri( $wp_styles, 'uw_wp_theme-comments' );
	}

	// Preload front-page.css.
	global $template;
	if ( 'front-page.php' === basename( $template ) ) {
		$preloads['uw_wp_theme-front-page'] = uw_wp_theme_get_preload_stylesheet_uri( $wp_styles, 'uw_wp_theme-front-page' );
	}

	// Output the preload markup in <head>.
	foreach ( $preloads as $handle => $src ) {
		echo '<link rel="preload" id="' . esc_attr( $handle ) . '-preload" href="' . esc_url( $src ) . '" as="style" />';
		echo "\n";
	}

}
add_action( 'wp_head', 'uw_wp_theme_add_body_style' );

/**
 * Add dropdown symbol to nav menu items with children.
 *
 * Adds the dropdown markup after the menu link element,
 * before the submenu.
 *
 * Javascript converts the symbol to a toggle button.
 *
 * @TODO:
 * - This doesn't work for the page menu because it
 *   doesn't have a similar filter. So the dropdown symbol
 *   is only being added for page menus if JS is enabled.
 *   Create a ticket to add to core?
 *
 * @param string   $item_output The menu item's starting HTML output.
 * @param WP_Post  $item        Menu item data object.
 * @param int      $depth       Depth of menu item. Used for padding.
 * @param stdClass $args        An object of wp_nav_menu() arguments.
 * @return string Modified nav menu HTML.
 */
function uw_wp_theme_add_primary_menu_dropdown_symbol( $item_output, $item, $depth, $args ) {

	// Only for our primary menu location.
	if ( empty( $args->theme_location ) || 'primary' != $args->theme_location ) {
		return $item_output;
	}

	// Add the dropdown for items that have children.
	if ( ! empty( $item->classes ) && in_array( 'menu-item-has-children', $item->classes ) ) {
		return $item_output . '<span class="dropdown"><i class="dropdown-symbol"></i></span>';
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'uw_wp_theme_add_primary_menu_dropdown_symbol', 10, 4 );

/**
 * Filters the HTML attributes applied to a menu item's anchor element.
 *
 * Checks if the menu item is the current menu
 * item and adds the aria "current" attribute.
 *
 * @param array   $atts   The HTML attributes applied to the menu item's `<a>` element.
 * @param WP_Post $item  The current menu item.
 * @return array Modified HTML attributes
 */
function uw_wp_theme_add_nav_menu_aria_current( $atts, $item ) {
	/*
	 * First, check if "current" is set,
	 * which means the item is a nav menu item.
	 *
	 * Otherwise, it's a post item so check
	 * if the item is the current post.
	 */
	if ( isset( $item->current ) ) {
		if ( $item->current ) {
			$atts['aria-current'] = 'page';
		}
	} else if ( ! empty( $item->ID ) ) {
		global $post;
		if ( ! empty( $post->ID ) && $post->ID == $item->ID ) {
			$atts['aria-current'] = 'page';
		}
	}

	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'uw_wp_theme_add_nav_menu_aria_current', 10, 2 );
add_filter( 'page_menu_link_attributes', 'uw_wp_theme_add_nav_menu_aria_current', 10, 2 );

if ( ! function_exists( 'uw_wp_theme_white_bar_menu') ) :
	function uw_wp_theme_white_bar_menu()
	{
		if (has_nav_menu(UW_Dropdowns::LOCATION)) {
				echo '<nav class="navbar navbar-expand-md navbar-light ' . UW_Dropdowns::LOCATION .'">
						<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#' . UW_Dropdowns::LOCATION .'" aria-controls="' . UW_Dropdowns::LOCATION .'" aria-expanded="false" aria-label="Toggle navigation">
							<span class="navbar-toggler-icon"></span>
						  </button><div class="container-fluid">';
				echo  wp_nav_menu( array(
							'theme_location'    => UW_Dropdowns::LOCATION,
							'container_id'      => UW_Dropdowns::LOCATION,
							'container'         => 'div',
							'container_class'   => 'collapse navbar-collapse',
							'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
							'walker'            => new WP_Bootstrap_Navwalker(),
							'menu_class'        => 'navbar-nav'
						) );
				echo '</div></nav>';
			}
	}
endif;

if ( ! function_exists( 'uw_wp_theme_purple_bar_menu') ) :
	function uw_wp_theme_purple_bar_menu()
	{
		echo  wp_nav_menu( array(
			'theme_location'    => UW_Audience::LOCATION,
			'menu_id'           => UW_Audience::LOCATION,
			'container'         => 'ul',
			'menu_class'        => 'navbar-menu menu'
		) );
	}
endif;

if ( !function_exists('uw_site_title')):

	function uw_site_title()
	{
		$classes = 'uw-site-title';
		if (get_option('overly_long_title')){
			$classes .= ' long-title';
		}
		echo '<a href="' . home_url('/') . '" title="' . esc_attr( get_bloginfo() ) . '"><div class="' . $classes . '">' . get_bloginfo() . '</div></a>';
	}

endif;
