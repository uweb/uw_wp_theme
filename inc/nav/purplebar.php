<?php
/**
 * Audience Nav Setup
 *
 * @package uw_wp_theme
 */

class UW_Audience
{

	const NAME           = 'Purple bar';
	const LOCATION       = 'purple-bar';
	const DISPLAY_NAME   = 'Audience menu';
	const DEFAULT_STATUS = 'publish';

	public $menu_items;
	public $MENU_ID;

	function __construct() {
		$this->menu_items = array();
		add_action( 'after_setup_theme', array( $this, 'register_purple_bar_menu' ) );
		add_action( 'after_setup_theme', array( $this, 'install_default_purple_bar_menu' ) );
	}

	function register_purple_bar_menu() {
		register_nav_menu( UW_Audience::LOCATION, __( UW_Audience::NAME ) );
	}

	function install_default_purple_bar_menu() {

		$this->generate_menu_list();
		$this->MENU_ID = wp_create_nav_menu( UW_Audience::DISPLAY_NAME );

		// wp_create_nav_menu returns a WP_Error if the menu already exists;
		if ( is_wp_error( $this->MENU_ID ) ) return;


		//      Each site in the network will have a different menu item ID for each thing.  Make the first menu and save its id
		//      then set that ID as the menu-item-parent-id for each child.  Then save each child.
		foreach ( $this->menu_items as $menu_name => $menu_attributes ) {

			$children = isset( $menu_attributes['children'] ) ? $menu_attributes['children'] : NULL;

			unset( $menu_attributes['children'] );


			$parent_id = wp_update_nav_menu_item( $this->MENU_ID, $menu_item_db_id=0, $menu_attributes );

			if ( $children )
			{
				foreach ( $children as $submenu){
					$submenu['menu-item-parent-id'] = $parent_id;
					wp_update_nav_menu_item($this->MENU_ID, $menu_item_db_id=0, $submenu);
				}
			}
		}

		$this->set_uw_menu_location();
	}

	function set_uw_menu_location()
	{
		$locations = (ARRAY) get_theme_mod( 'nav_menu_locations' );
		$locations[ 'purple-bar' ] = $this->MENU_ID;
		set_theme_mod( 'nav_menu_locations', $locations );
	}

	 function generate_menu_list()
	 {

		// The default About dropdown.
		$this->add_menu_item( 'Students', '//uw.edu/studentlife/' );
		$this->add_menu_item( 'Parents', '//uw.edu/parents/' );
		$this->add_menu_item( 'Faculty &amp; Staff', '//uw.edu/facultystaff/' );
		$this->add_menu_item( 'Alumni', '//uw.edu/alumni/' );

	}

	function add_menu_item( $name, $url, $parent=null )
	{
		$item['menu-item-title']    = $name;
		$item['menu-item-url']      = $url;
		$item['menu-item-status'] 	= UW_Audience::DEFAULT_STATUS;


		if ( $parent )
			$this->menu_items[ $parent ]['children'][$name] = $item;
		else
			$this->menu_items[$name] = $item;

	}

}
