<?php
if ( ! function_exists('uw_sidebar_menu') ) :

	function uw_sidebar_menu()
	{
		global $post;
		if ( isset( $post ) && get_post_meta( $post->ID, 'sidebar_nav', true ) ) {
			return;
		}

		echo sprintf( '<nav id="desktop-relative" aria-label="sidebar menu">%s</nav>', uw_list_pages() ) ;
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
		'title_li'     => '<a href="'.get_bloginfo('url').'" title="Home" class="homelink">Home</a>',
		'child_of'     => $parent->post_parent,
		'exclude_tree' => $ids,
		'depth'        => 3,
		'echo'         => 0,
		'walker'       => $UW->SidebarMenuWalker
	  ));

	  $bool = strpos($pages , 'child-page-existance-tester');

	  return  $bool && !is_search() ? sprintf( '%s<ul class="%s first-level">%s</ul>', $toggle, $class, $pages ) : '';

	}

  endif;
