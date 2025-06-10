<?php
/**
 * FooterMenu Setup
 *
 * @package uw_wp_theme
 */
class UW_FooterMenu {
	const NAME           = 'Footer menu';
	const LOCATION       = 'footer-links';
	const DISPLAY_NAME   = 'Footer menu';
	const DEFAULT_STATUS = 'publish';
	const ALLOWED_BLOG	 =	1;

	public $MULTISITE;
	public $menu_items;
	public $MENU_ID;

	function __construct() {
		$this->MULTISITE = is_multisite();
		$this->menu_items = array();
		add_action( 'after_setup_theme', array( $this, 'install_default_footer_menu' ) );

		if ( ! $this->MULTISITE || $this->MULTISITE && get_current_blog_id() === self::ALLOWED_BLOG ) {
			add_action( 'after_setup_theme', array( $this, 'register_footer_menu' ) );
		}
	}

	function register_footer_menu() {
		register_nav_menu( self::LOCATION, __( self::NAME ) );
	}

	function install_default_footer_menu() {

		$this->generate_menu_list();
		$this->MENU_ID = wp_create_nav_menu( self::DISPLAY_NAME );

		// wp_create_nav_menu returns a WP_Error if the menu already exists.
		if ( is_wp_error( $this->MENU_ID ) ) return;

		// Each site in the network will have a different menu item ID for each thing.  Make the first menu and save its id
		// then set that ID as the menu-item-parent-id for each child.  Then save each child.
		foreach ( $this->menu_items as $menu_name => $menu_attributes ) {

			$children = isset( $menu_attributes['children'] ) ? $menu_attributes['children'] : NULL;

			unset( $menu_attributes['children'] );

			$parent_id = wp_update_nav_menu_item( $this->MENU_ID, $menu_item_db_id = 0, $menu_attributes );

			if ( $children ) {
				foreach ( $children as $submenu ) {
					$submenu['menu-item-parent-id'] = $parent_id;
					wp_update_nav_menu_item( $this->MENU_ID, $menu_item_db_id = 0, $submenu );
				}
			}
		}

		$this->set_uw_menu_location();
	}

	function set_uw_menu_location() {
		$locations = (array) get_theme_mod( 'nav_menu_locations' );
		$locations['footer-menu'] = $this->MENU_ID;
		set_theme_mod( 'nav_menu_locations', $locations );
	}

	function generate_menu_list() {

		// The default footer menu.
		$this->add_menu_item( 'Accessibility', 'https://www.washington.edu/accessibility/' );
		$this->add_menu_item( 'Contact Us', 'https://www.washington.edu/contact/' );
		$this->add_menu_item( 'Jobs', 'https://www.washington.edu/jobs/' );
		$this->add_menu_item( 'Campus Safety', 'https://www.washington.edu/safety/' );
		$this->add_menu_item( 'My UW', 'https://my.uw.edu/' );
		$this->add_menu_item( 'Rules Docket', 'https://www.washington.edu/rules/wac/' );
		$this->add_menu_item( 'Privacy', 'https://www.washington.edu/online/privacy/' );
		$this->add_menu_item( 'Terms', 'https://www.washington.edu/online/terms/' );
		$this->add_menu_item( 'Newsletter', 'https://www.washington.edu/newsletter/' );
	}

	function add_menu_item( $name, $url, $parent = null ) {
		$item['menu-item-title']    = $name;
		$item['menu-item-url']      = $url;
		$item['menu-item-status']   = self::DEFAULT_STATUS;

		if ( $parent ) {
			$this->menu_items[ $parent ]['children'][$name] = $item;
		} else {
			$this->menu_items[$name] = $item;
		}
	}

	// Fallback function to render standard menu if this menu isn't enabled.
	public static function fallback_menu( ) {
		wp_nav_menu( array( 'menu' => 'footer-menu', 'container' => 'ul', 'menu_class' => self::LOCATION, ) );
	}

}
