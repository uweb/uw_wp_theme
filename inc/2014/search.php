<?php
/**
 * Registers the UW Search.
 *
 * This needs to be cleaned up!
 *
 * @package uw_wp_theme
 */
class UW_SquishBugs {

	function __construct() {
		// http://core.trac.wordpress.org/ticket/11330.
		add_filter( 'pre_get_posts', array( $this, 'uw_search_query_filter' ) );
	}

	function uw_search_query_filter( $query ) {
		if ( isset( $_GET['s'] ) && empty( $_GET['s'] ) && $query->is_main_query() ) {
			$query->is_search = true;
			$query->is_home   = false;
		}

		return $query;
	}
}

/**
 * Main function for Search. Runs everything.
 */
function uw_wp_theme_search() {
	add_action( 'wp_enqueue_scripts', 'uw_wp_theme_enqueue_search' );
}
add_action( 'wp', 'uw_wp_theme_search' );

/**
 * Enqueue and defer search scripts.
 */
function uw_wp_theme_enqueue_search() {
	if ( is_multisite() ) {
		wp_enqueue_script( 'uw_wp_theme-search-script', network_site_url( '/wp-content/themes/uw_wp_theme/js/2014/search.js' ), array( 'underscore', 'uw_wp_theme-backbone' ), '20190708', true );
		wp_enqueue_script( 'uw_wp_theme-searchtoggle-script', network_site_url( '/wp-content/themes/uw_wp_theme/js/2014/searchtoggle.js' ), array( 'underscore', 'uw_wp_theme-backbone' ), '20190708', true );
		wp_enqueue_style( 'uw_wp_theme-search-style', network_site_url( '/wp-content/themes/uw_wp_theme/css/2014-search.css' ), array(), '20190708' );
	} else {
		wp_enqueue_script( 'uw_wp_theme-search-script', get_theme_file_uri( '/js/2014/search.js' ), array( 'underscore', 'uw_wp_theme-backbone' ), '20190708', true );
		wp_enqueue_script( 'uw_wp_theme-searchtoggle-script', get_theme_file_uri( '/js/2014/searchtoggle.js' ), array( 'underscore', 'uw_wp_theme-backbone' ), '20190708', true );
		wp_enqueue_style( 'uw_wp_theme-search-style', get_theme_file_uri( '/css/2014-search.css' ), array(), '20190708' );
	}
}
