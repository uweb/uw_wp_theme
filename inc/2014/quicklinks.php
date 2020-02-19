<?php
/**
 * Registers the UW Quicklinks navigation and provides a json feed for the current quicklinks.
 *
 * This needs to be cleaned up!
 *
 * @package uw_wp_theme
 */
class UW_QuickLinks {

	const NAME         = 'Quick Links';
	const LOCATION     = 'quick-links';
	const ALLOWED_BLOG = 1;

	function __construct() {
		$this->MULTISITE = is_multisite();

		if ( ! $this->MULTISITE || $this->MULTISITE && get_current_blog_id() === self::ALLOWED_BLOG ) {
			add_action( 'after_setup_theme', array( $this, 'register_quick_links_menu' ) );
			add_action( 'wp_ajax_quicklinks', array( $this, 'uw_quicklinks_feed' ) );
			add_action( 'wp_ajax_nopriv_quicklinks', array( $this, 'uw_quicklinks_feed' ) );
		}
	}

	function register_quick_links_menu() {
		register_nav_menu( self::LOCATION, __( self::NAME ) );
	}

	function uw_quicklinks_feed() {
		if ( $this->MULTISITE ) switch_to_blog( self::ALLOWED_BLOG );

		$locations = get_nav_menu_locations();
		if ( ( isset( $locations[ self::LOCATION ] ) ) ) {
			$this->items = wp_get_nav_menu_items( $locations[ self::LOCATION ] );
		} elseif ( $location = wp_get_nav_menu_object( self::LOCATION ) ) {
			$this->items = wp_get_nav_menu_items( $location->term_id );
		}

		if ( $this->MULTISITE ) restore_current_blog();
			wp_send_json( $this->parse_menu() );
	}

	function parse_menu() {
		if ( isset( $this->items ) )
		foreach ( $this->items as $index => $item ) {
			// Only keep the necessary keys of the $item.
			$item = array_intersect_key( (array) $item, array_fill_keys( array( 'ID', 'title', 'url', 'classes', 'menu_item_parent' ), null ) );

			if ( ! $item['classes'][0] )
				$item['classes'] = false;
				$menu[] = $item;
		}

		return isset( $menu ) ? $menu : array();
	}
}

/**
 * Main function for Quicklinks. Runs everything.
 */
function uw_wp_theme_quicklinks() {
	add_action( 'wp_enqueue_scripts', 'uw_wp_theme_enqueue_quicklinks' );
}
add_action( 'wp', 'uw_wp_theme_quicklinks' );

/**
 * Enqueue and defer quicklinks scripts.
 */
function uw_wp_theme_enqueue_quicklinks() {
	if ( is_multisite() ) {
		wp_enqueue_script( 'uw_wp_theme-quicklinks-script', network_site_url( '/wp-content/themes/uw_wp_theme/js/2014/quicklinks.js' ), array( 'underscore', 'uw_wp_theme-backbone' ), '20190703', true );
		wp_enqueue_style( 'uw_wp_theme-quicklinks-style', network_site_url( '/wp-content/themes/uw_wp_theme/css/2014-quicklinks.css' ), array(), '20190705' );
	} else {
		wp_enqueue_script( 'uw_wp_theme-quicklinks-script', get_theme_file_uri( '/js/2014/quicklinks.js' ), array( 'underscore', 'uw_wp_theme-backbone' ), '20190703', true );
		wp_enqueue_style( 'uw_wp_theme-quicklinks-style', get_theme_file_uri( '/css/2014-quicklinks.css' ), array(), '20190705' );
	}
}
