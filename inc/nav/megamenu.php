<?php
/**
 * Mega Menu Nav Setup
 *
 * @package uw_wp_theme
 */
class UW_MegaMenu {

	const NAME         = 'Mega Menu';
	const LOCATION     = 'mega-menu';
	const DISPLAY_NAME = 'Mega Menu';

	public function __construct() {
		add_action( 'init', array( $this, 'register_mega_menu' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'uw_wp_theme_enqueue_megamenu_script' ) );
	}

	/**
	 * Register the Mega Menu
	 *
	 * @return void
	 */
	public function register_mega_menu() {
		register_nav_menu( self::LOCATION, __( self::NAME ) );
	}

	/**
	 * Load megamenu JS.
	 *
	 * @return void
	 */
	public function uw_wp_theme_enqueue_megamenu_script() {
		$template_directory = get_bloginfo( 'template_directory' );
		$theme_version = wp_get_theme( get_template( ) )->get( 'Version' );

		wp_register_script( 'uw_wp_theme-megamenu-script', $template_directory . '/js/megamenu.js', array( 'jquery', 'uw_wp_theme-bootstrap' ), $theme_version, true );
	}
}
