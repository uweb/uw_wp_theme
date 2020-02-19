<?php
/**
 * Social feeds for UW Social theme.
 *
 * @package uw_wp_theme
 */

/**
 * Main function. Runs everything.
 */
function uw_wp_theme_social_feeds() {

	// If this is the admin page, do nothing.
	if ( is_admin() ) {
		return;
	}

	// Only add these scripts on the home page.
	if ( is_front_page() ) {
		add_action( 'wp_enqueue_scripts', 'uw_wp_theme_enqueue_social_assets' );
	}

}
add_action( 'wp', 'uw_wp_theme_social_feeds' );

/**
 * Enqueue and defer social feeds scripts.
 */
function uw_wp_theme_enqueue_social_assets() {
	if ( is_multisite() ) {
		wp_enqueue_script( 'uw_wp_theme-social-common', network_site_url( '/wp-content/themes/uw_wp_theme/pluggable/social/js/common.js' ), array( 'underscore', 'uw_wp_theme-backbone' ), '20190618', true );
		wp_enqueue_script( 'uw_wp_theme-social-facebook', network_site_url( '/wp-content/themes/uw_wp_theme/pluggable/social/js/facebook-scraper.js' ), array( 'underscore', 'uw_wp_theme-backbone' ), '20190618', true );
		wp_enqueue_script( 'uw_wp_theme-social-masonry', network_site_url( '/wp-content/themes/uw_wp_theme/pluggable/social/js/social-masonry.js' ), array( 'underscore', 'uw_wp_theme-backbone' ), '20190618', true );
		wp_enqueue_script( 'uw_wp_theme-social-twitter', network_site_url( '/wp-content/themes/uw_wp_theme/pluggable/social/js/twitter-scraper.js' ), array( 'underscore', 'uw_wp_theme-backbone' ), '20190618', true );
	} else {
		wp_enqueue_script( 'uw_wp_theme-social-common', get_theme_file_uri( '/pluggable/social/js/common.js' ), array( 'underscore', 'uw_wp_theme-backbone' ), '20190618', true );
		wp_enqueue_script( 'uw_wp_theme-social-facebook', get_theme_file_uri( '/pluggable/social/js/facebook-scraper.js' ), array( 'underscore', 'uw_wp_theme-backbone' ), '20190618', true );
		wp_enqueue_script( 'uw_wp_theme-social-masonry', get_theme_file_uri( '/pluggable/social/js/social-masonry.js' ), array( 'underscore', 'uw_wp_theme-backbone' ), '20190618', true );
		wp_enqueue_script( 'uw_wp_theme-social-twitter', get_theme_file_uri( '/pluggable/social/js/twitter-scraper.js' ), array( 'underscore', 'uw_wp_theme-backbone' ), '20190618', true );
	}
}
