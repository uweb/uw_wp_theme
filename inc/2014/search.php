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
