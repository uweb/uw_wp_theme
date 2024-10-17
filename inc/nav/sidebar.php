<?php
/**
 * Load sidebar menu JS.
 */
function uw_wp_theme_enqueue_sidebar_nav_script() {
	$template_directory = get_bloginfo( 'template_directory' );
	$theme_version = wp_get_theme( get_template( ) )->get( 'Version' );

	wp_register_script( 'uw_wp_theme-sidebar-nav-script', $template_directory . '/js/sidebar-nav.js', array( 'jquery', 'uw_wp_theme-bootstrap' ), $theme_version, true );
}
add_action( 'wp_enqueue_scripts', 'uw_wp_theme_enqueue_sidebar_nav_script' );

if ( ! function_exists('uw_sidebar_menu') ) :

	function uw_sidebar_menu()
	{
		global $post;
		$args = array (
			'parent' => $post->ID
		);

		$children = get_pages( $args );

		$sidebarnavcheck = get_post_meta( $post->ID, 'sidebarnavcheck', true );

		if ( isset( $post ) && get_post_meta( $post->ID, 'sidebar_nav', true ) ) {
			return;
		}

		// If this page is a parent page with children or a child page with a parent and therefore uses the sidebar navigation, display it - UNLESS the checkbox for "Hide Sidebar Navigation" is checked in the page template settings. Without this if statement, an empty nav will announce itself to screen readers on all pages with a sidebar and no nav.
		if ( $sidebarnavcheck !== 'on' && ( ( is_page() && $post->post_parent > 0 ) || ( is_page() && count( $children ) > 0 ) ) ) {
			echo sprintf( '<nav id="desktop-relative">%s</nav>', uw_list_pages() );
		}
	}

endif;
if ( ! function_exists( 'uw_list_pages') ) :
	function uw_list_pages( $mobile = false )
	{
	  global $UW;
	  global $post;

	  if ( !isset( $post ) ) return;

	  $parent = get_post( $post->post_parent );

	  if ( ! $mobile && ! get_children( array('post_parent' => $post->ID, 'post_status' => 'publish' ) ) && $parent->ID == $post->ID ) return;

	  $toggle = $mobile ? '<button class="uw-mobile-menu-toggle">Menu</button>' : '';
	  $class  = $mobile ? 'uw-mobile-menu' : 'uw-sidebar-menu';

	  $siblings = get_pages( array (
		'parent'    => $parent->post_parent,
		'post_type' => 'page',
		'exclude'   => $parent->ID
	  ) );

	  //$ids = !is_front_page() ? array_map( function($sibling) { return $sibling->ID; }, $siblings ) : array();

	  $ids = array_map( function($sibling) { return $sibling->ID; }, $siblings );

	  $pages = wp_list_pages(array(
		'title_li'     => '<a href="'.get_bloginfo('url').'" title="Section home" class="homelink">Home</a>',
		'child_of'     => $parent->post_parent,
		'exclude_tree' => $ids,
		'depth'        => 3,
		'echo'         => 0,
		'walker'       => $UW->SidebarMenuWalker
	  ));

	  $bool = strpos($pages , 'child-page-existance-tester');

	  wp_enqueue_script( 'uw_wp_theme-sidebar-nav-script' );

	  return  $bool && !is_search() ? sprintf( '%s<ul class="%s first-level">%s</ul>', $toggle, $class, $pages ) : '';
	}

  endif;
