<?php
/**
 *  This is the UW object that contains all the classes for our back-end functionality
 *  All classes should be accessible by UW::ClassName
 */
class UW {

	function __construct() {
		$this->includes();
		$this->initialize();
	}

	private function includes() {
		require get_template_directory() . '/inc/nav/quicklinks.php';
		require get_template_directory() . '/inc/2014/search.php';
		require get_template_directory() . '/inc/nav/whitebar.php';
		require get_template_directory() . '/inc/nav/purplebar.php';
		require get_template_directory() . '/inc/nav/sidebar.php';
		require get_template_directory() . '/inc/nav/sidebar-walker.php';
		require get_template_directory() . '/inc/2014/page-meta.php';
		require get_template_directory() . '/inc/nav/megamenu.php';
		require get_template_directory() . '/inc/shortcodes/class.media-credit.php';
	}

	private function initialize() {
		$this->UW_Dropdowns      = new UW_Dropdowns();
		$this->SidebarMenuWalker = new UW_Sidebar_Menu_Walker();
		$this->UW_Audience       = new UW_Audience();
		$this->Quicklinks        = new UW_QuickLinks();
		$this->SquishBugs        = new UW_SquishBugs();
		$this->UW_Page_Meta      = new UW_Page_Meta();
		$this->UW_MegaMenu       = new UW_MegaMenu();
		$this->UW_Media_Credit   = new UW_Media_Credit();
	}
}
/**
 * Main function for 2014 carryover.
 */
function uw_wp_theme_2014() {
	add_action( 'wp_enqueue_scripts', 'uw_wp_theme_enqueue_2014_carryover' );
}

add_action( 'wp', 'uw_wp_theme_2014' );

/**
 * Enqueue and defer 2014 script.
 */
function uw_wp_theme_enqueue_2014_carryover() {
	wp_enqueue_script( 'uw_wp_theme-2014-script', get_template_directory_uri() . '/js/2014.min.js', array( 'underscore', 'backbone' ), '20190708', true );

	$site_parameters = array(
		'style_dir' => site_url(),
	);
	wp_localize_script( 'scripts', 'style_dir', $site_parameters );
}
