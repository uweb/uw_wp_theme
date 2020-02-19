<?php
/**
 * Registers the UW Search.
 *
 * This needs to be cleaned up!
 *
 * @package uw_golden
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
function uw_golden_search() {
	add_action( 'wp_enqueue_scripts', 'uw_golden_enqueue_search' );
}
add_action( 'wp', 'uw_golden_search' );

/**
 * Enqueue and defer search scripts.
 */
function uw_golden_enqueue_search() {
	if ( is_multisite() ) {
		wp_enqueue_script( 'uw_golden-search-script', network_site_url( '/wp-content/themes/uw_golden/pluggable/search/search.js' ), array( 'underscore', 'uw_golden-backbone' ), '20190708', true );
		wp_enqueue_script( 'uw_golden-searchtoggle-script', network_site_url( '/wp-content/themes/uw_golden/pluggable/search/searchtoggle.js' ), array( 'underscore', 'uw_golden-backbone' ), '20190708', true );
		wp_enqueue_style( 'uw_golden-search-style', network_site_url( '/wp-content/themes/uw_golden/pluggable/search/search.css' ), array(), '20190708' );
	} else {
		wp_enqueue_script( 'uw_golden-search-script', get_theme_file_uri( '/pluggable/search/search.js' ), array( 'underscore', 'uw_golden-backbone' ), '20190708', true );
		wp_enqueue_script( 'uw_golden-searchtoggle-script', get_theme_file_uri( '/pluggable/search/searchtoggle.js' ), array( 'underscore', 'uw_golden-backbone' ), '20190708', true );
		wp_enqueue_style( 'uw_golden-search-style', get_theme_file_uri( '/pluggable/search/search.css' ), array(), '20190708' );
	}
}
