<?php

if ( ! function_exists( 'uw_list_pages' ) ) :

	function uw_list_pages( $mobile = false ) {
		global $UW;
		global $post;

		$parent = get_post( $post->post_parent );

		if ( ! get_children( array('post_parent' => $post->ID, 'post_status' => 'publish' ) ) && $parent->ID === $post->ID ) return;

		$toggle = $mobile ? '<button class="uw-mobile-menu-toggle">Menu</button>' : '';
		$class  = $mobile ? 'uw-mobile-menu' : 'uw-sidebar-menu';

		$siblings = get_pages(
			array(
				'parent'    => $parent->post_parent,
				'post_type' => 'page',
				'exclude'   => $parent->ID,
			)
		);

		$ids = ! is_front_page() ? array_map( function( $sibling ) { return $sibling->ID; }, $siblings ) : array();

		$pages = wp_list_pages(
			array(
				'title_li'     => '',
				'child_of'     => $parent->post_parent,
				'exclude_tree' => $ids,
				'depth'        => 3,
				'echo'         => 0,
				'sort_column'  => 'menu_order',
				'walker'       => $UW->SidebarMenuWalker,
			)
		);

		return $pages;
	}

endif;

if ( ! function_exists('uw_sidebar_menu') ) :

	function uw_sidebar_menu() {
		// check to see if this page is a parent of children or a child page first and then only print out the menu if true.
		global $post;
		$children = get_pages( array( 'child_of' => $post->ID ) );
		if ( is_page() && ( $post->post_parent || count( $children ) > 0  ) ) {
			echo sprintf( '<ul class="nav flex-column">%s</ul>', uw_list_pages() );
		}
	}

endif;
