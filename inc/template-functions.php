<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package uw_wp_theme
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function uw_wp_theme_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	if ( is_active_sidebar( 'sidebar-1' ) ) {
		global $template;
		if ( 'front-page.php' !== basename( $template ) ) {
			$classes[] = 'has-sidebar';
		}
	}

	return $classes;
}
add_filter( 'body_class', 'uw_wp_theme_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function uw_wp_theme_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'uw_wp_theme_pingback_header' );

/**
 * Adds async/defer attributes to enqueued / registered scripts.
 *
 * If #12009 lands in WordPress, this function can no-op since it would be handled in core.
 *
 * @link https://core.trac.wordpress.org/ticket/12009
 * @param string $tag    The script tag.
 * @param string $handle The script handle.
 * @return array
 */
function uw_wp_theme_filter_script_loader_tag( $tag, $handle ) {

	foreach ( array( 'async', 'defer' ) as $attr ) {
		if ( ! wp_scripts()->get_data( $handle, $attr ) ) {
			continue;
		}

		// Prevent adding attribute when already added in #12009.
		if ( ! preg_match( ":\s$attr(=|>|\s):", $tag ) ) {
			$tag = preg_replace( ':(?=></script>):', " $attr", $tag, 1 );
		}

		// Only allow async or defer, not both.
		break;
	}

	return $tag;
}

add_filter( 'script_loader_tag', 'uw_wp_theme_filter_script_loader_tag', 10, 2 );

/**
 * Generate preload markup for stylesheets.
 *
 * @param object $wp_styles Registered styles.
 * @param string $handle The style handle.
 */
function uw_wp_theme_get_preload_stylesheet_uri( $wp_styles, $handle ) {
	$preload_uri = $wp_styles->registered[ $handle ]->src . '?ver=' . $wp_styles->registered[ $handle ]->ver;
	return $preload_uri;
}

/**
 * Adds preload for in-body stylesheets depending on what templates are being used.
 * Disabled when AMP is active as AMP injects the stylesheets inline.
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Preloading_content
 */
function uw_wp_theme_add_body_style() {

	// If AMP is active, do nothing.
	if ( uw_wp_theme_is_amp() ) {
		return;
	}

	// Get registered styles.
	$wp_styles = wp_styles();

	$preloads = array();

	// Preload content.css.
	$preloads['uw_wp_theme-content'] = uw_wp_theme_get_preload_stylesheet_uri( $wp_styles, 'uw_wp_theme-content' );

	// Preload sidebar.css and widget.css.
	if ( is_active_sidebar( 'sidebar-1' ) ) {
		$preloads['uw_wp_theme-sidebar'] = uw_wp_theme_get_preload_stylesheet_uri( $wp_styles, 'uw_wp_theme-sidebar' );
		$preloads['uw_wp_theme-widgets'] = uw_wp_theme_get_preload_stylesheet_uri( $wp_styles, 'uw_wp_theme-widgets' );
	}

	// Preload comments.css.
	if ( ! post_password_required() && is_singular() && ( comments_open() || get_comments_number() ) ) {
		$preloads['uw_wp_theme-comments'] = uw_wp_theme_get_preload_stylesheet_uri( $wp_styles, 'uw_wp_theme-comments' );
	}

	// Preload front-page.css.
	global $template;
	if ( 'front-page.php' === basename( $template ) ) {
		$preloads['uw_wp_theme-front-page'] = uw_wp_theme_get_preload_stylesheet_uri( $wp_styles, 'uw_wp_theme-front-page' );
	}

	// Output the preload markup in <head>.
	foreach ( $preloads as $handle => $src ) {
		echo '<link rel="preload" id="' . esc_attr( $handle ) . '-preload" href="' . esc_url( $src ) . '" as="style" />';
		echo "\n";
	}

}
add_action( 'wp_head', 'uw_wp_theme_add_body_style' );

/**
 * Add dropdown symbol to nav menu items with children.
 *
 * Adds the dropdown markup after the menu link element,
 * before the submenu.
 *
 * Javascript converts the symbol to a toggle button.
 *
 * @TODO:
 * - This doesn't work for the page menu because it
 *   doesn't have a similar filter. So the dropdown symbol
 *   is only being added for page menus if JS is enabled.
 *   Create a ticket to add to core?
 *
 * @param string   $item_output The menu item's starting HTML output.
 * @param WP_Post  $item        Menu item data object.
 * @param int      $depth       Depth of menu item. Used for padding.
 * @param stdClass $args        An object of wp_nav_menu() arguments.
 * @return string Modified nav menu HTML.
 */
function uw_wp_theme_add_primary_menu_dropdown_symbol( $item_output, $item, $depth, $args ) {

	// Only for our primary menu location.
	if ( empty( $args->theme_location ) || 'primary' != $args->theme_location ) {
		return $item_output;
	}

	// Add the dropdown for items that have children.
	if ( ! empty( $item->classes ) && in_array( 'menu-item-has-children', $item->classes ) ) {
		return $item_output . '<span class="dropdown"><i class="dropdown-symbol"></i></span>';
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'uw_wp_theme_add_primary_menu_dropdown_symbol', 10, 4 );

/**
 * Filters the HTML attributes applied to a menu item's anchor element.
 *
 * Checks if the menu item is the current menu
 * item and adds the aria "current" attribute.
 *
 * @param array   $atts   The HTML attributes applied to the menu item's `<a>` element.
 * @param WP_Post $item  The current menu item.
 * @return array Modified HTML attributes
 */
function uw_wp_theme_add_nav_menu_aria_current( $atts, $item ) {
	/*
	 * First, check if "current" is set,
	 * which means the item is a nav menu item.
	 *
	 * Otherwise, it's a post item so check
	 * if the item is the current post.
	 */
	if ( isset( $item->current ) ) {
		if ( $item->current ) {
			$atts['aria-current'] = 'page';
		}
	} else if ( ! empty( $item->ID ) ) {
		global $post;
		if ( ! empty( $post->ID ) && $post->ID == $item->ID ) {
			$atts['aria-current'] = 'page';
		}
	}

	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'uw_wp_theme_add_nav_menu_aria_current', 10, 2 );
add_filter( 'page_menu_link_attributes', 'uw_wp_theme_add_nav_menu_aria_current', 10, 2 );

if ( ! function_exists( 'uw_wp_theme_white_bar_menu') ) :
	function uw_wp_theme_white_bar_menu()
	{
		if (has_nav_menu(UW_Dropdowns::LOCATION)) {
				echo '<nav class="navbar navbar-expand-md navbar-light ' . UW_Dropdowns::LOCATION .'">
						<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#' . UW_Dropdowns::LOCATION .'" aria-controls="' . UW_Dropdowns::LOCATION .'" aria-expanded="false" aria-label="Toggle navigation">
							<span class="navbar-toggler-icon"></span>
						  </button><div class="container-fluid">';
				echo  wp_nav_menu( array(
							'theme_location'    => UW_Dropdowns::LOCATION,
							'container_id'      => UW_Dropdowns::LOCATION,
							'container'         => 'div',
							'container_class'   => 'collapse navbar-collapse',
							'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
							'walker'            => new WP_Bootstrap_Navwalker(),
							'menu_class'        => 'navbar-nav',
							'depth'				=> 2,
						) );
				echo '</div></nav>';
			}
	}
endif;

if ( ! function_exists( 'uw_wp_theme_purple_bar_menu') ) :
	function uw_wp_theme_purple_bar_menu()
	{
		echo  wp_nav_menu( array(
			'theme_location'    => UW_Audience::LOCATION,
			'menu_id'           => UW_Audience::LOCATION,
			'container'         => 'ul',
			'menu_class'        => 'navbar-menu menu'
		) );
	}
endif;

if ( !function_exists('uw_site_title')):

	function uw_site_title()
	{
		$classes = 'uw-site-title';
		if (get_option('overly_long_title')){
			$classes .= ' long-title';
		}
		echo '<a href="' . home_url('/') . '" title="' . esc_attr( get_bloginfo() ) . '"><div class="' . $classes . '">' . get_bloginfo() . '</div></a>';
	}

endif;

if ( ! function_exists( 'uw_mobile_front_page_menu' ) ) :

  function uw_mobile_front_page_menu($class='')
  {
    $spacer = '';
    if (!empty($class)){
        $class = ' ' . $class;
        $spacer = '<div id="spacer"></div>';

    }
    echo sprintf( '<nav id="mobile-relative" class="frontpage%s" aria-label="mobile menu">%s%s</nav>', $class, $spacer, uw_list_front_page_menu_items() ) ;
  }

endif;

if ( ! function_exists( 'uw_list_front_page_menu_items' ) ) :

function uw_list_front_page_menu_items()
{
      $toggle = '<button class="uw-mobile-menu-toggle">Menu</button>';
      $items = wp_nav_menu( array(
              'title_li'     => '<a href="'.get_bloginfo('url').'" title="Home" class="homelink">Home</a>',
              'theme_location'  => UW_Dropdowns::LOCATION,
              'depth' => 2,
              'container_class' => '',
              'menu_class'      => '',
              'fallback_cb'     => '',
              'echo' => false,
              // 'walker'          => new UW_Dropdowns_Walker_Menu()
      ) );

      return $items ? sprintf( '%s<ul class="uw-mobile-menu first-level">%s</ul>', $toggle, $items ) : '';


}

endif;

if ( ! function_exists('get_uw_breadcrumbs') ) :

  function get_uw_breadcrumbs()
  {

    global $post;
    $ancestors = array_reverse( get_post_ancestors( $post ) );
    $html = '<li><a href="http://uw.edu" title="University of Washington">Home</a></li>';
    $html .= '<li' . (is_front_page() ? ' class="current"' : '') . '><a href="' . home_url('/') . '" title="' . get_bloginfo('title') . '">' . get_bloginfo('title') . '</a><li>';

    if ( is_404() )
    {
        $html .=  '<li class="current"><span>Woof!</span>';
    } else

    if ( is_search() )
    {
        $html .=  '<li class="current"><span>Search results for ' . get_search_query() . '</span>';
    } else

    if ( is_author() )
    {
        $author = get_queried_object();
        $html .=  '<li class="current"><span> Author: '  . $author->display_name . '</span>';
    } else

    if ( get_queried_object_id() === (Int) get_option('page_for_posts')   ) {
        $html .=  '<li class="current"><span> '. get_the_title( get_queried_object_id() ) . ' </span>';
    }

    // If the current view is a post type other than page or attachment then the breadcrumbs will be taxonomies.
    if( is_category() || is_single() || is_post_type_archive() )
    {

      if ( is_post_type_archive() )
      {
        $posttype = get_post_type_object( get_post_type() );
        //$html .=  '<li class="current"><a href="'  . get_post_type_archive_link( $posttype->query_var ) .'" title="'. $posttype->labels->menu_name .'">'. $posttype->labels->menu_name  . '</a>';
        $html .=  '<li class="current"><span>'. $posttype->labels->menu_name  . '</span>';
      }

      if ( is_category() )
      {
        $category = get_category( get_query_var( 'cat' ) );
        //$html .=  '<li class="current"><a href="'  . get_category_link( $category->term_id ) .'" title="'. get_cat_name( $category->term_id ).'">'. get_cat_name($category->term_id ) . '</a>';
        $html .=  '<li class="current"><span>'. get_cat_name($category->term_id ) . '</span>';
      }

      if ( is_single() )
      {
        if ( has_category() )
        {
          $thecat = get_the_category( $post->ID  );
          $category = array_shift( $thecat ) ;
          $html .=  '<li><a href="'  . get_category_link( $category->term_id ) .'" title="'. get_cat_name( $category->term_id ).'">'. get_cat_name($category->term_id ) . '</a>';
        }
        if ( uw_is_custom_post_type() )
        {
          $posttype = get_post_type_object( get_post_type() );
          $archive_link = get_post_type_archive_link( $posttype->query_var );
          if (!empty($archive_link)) {
            $html .=  '<li><a href="'  . $archive_link .'" title="'. $posttype->labels->menu_name .'">'. $posttype->labels->menu_name  . '</a>';
          }
          else if (!empty($posttype->rewrite['slug'])){
            $html .=  '<li><a href="'  . site_url('/' . $posttype->rewrite['slug'] . '/') .'" title="'. $posttype->labels->menu_name .'">'. $posttype->labels->menu_name  . '</a>';
          }
        }
        $html .=  '<li class="current"><span>'. get_the_title( $post->ID ) . '</span>';
      }
    }

    // If the current view is a page then the breadcrumbs will be parent pages.
    else if ( is_page() )
    {

      if ( ! is_home() || ! is_front_page() )
        $ancestors[] = $post->ID;

      if ( ! is_front_page() )
      {
        foreach ( array_filter( $ancestors ) as $index=>$ancestor )
        {
          $class      = $index+1 == count($ancestors) ? ' class="current" ' : '';
          $page       = get_post( $ancestor );
          $url        = get_permalink( $page->ID );
          $title_attr = esc_attr( $page->post_title );
          if (!empty($class)){
            $html .= "<li $class><span>{$page->post_title}</span></li>";
          }
          else {
            $html .= "<li><a href=\"$url\" title=\"{$title_attr}\">{$page->post_title}</a></li>";
          }
        }
      }

    }

    return "<nav class='uw-breadcrumbs' aria-label='breadcrumbs'><ul>$html</ul></nav>";
  }

endif;

if ( ! function_exists('uw_breadcrumbs') ) :

  function uw_breadcrumbs()
  {
    echo get_uw_breadcrumbs();
  }

endif;

if ( ! function_exists('uw_wp_theme_breadcrumbs') ) :

	function uw_wp_theme_breadcrumbs(){

		global $post;
		$ancestors = array_reverse( get_post_ancestors( $post ) );
		$html = '<li><a href="http://uw.edu" title="University of Washington">Home</a></li>';
		$html .= '<li' . (is_front_page() ? ' class="current"' : '') . '><a href="' . home_url('/') . '" title="' . get_bloginfo('title') . '">' . get_bloginfo('title') . '</a><li>';

		if ( is_404() )
		{
		    $html .=  '<li class="current"><span>Woof!</span>';
		} else

		if ( is_search() )
		{
		    $html .=  '<li class="current"><span>Search results for ' . get_search_query() . '</span>';
		} else

		if ( is_author() )
		{
		    $author = get_queried_object();
		    $html .=  '<li class="current"><span> Author: '  . $author->display_name . '</span>';
		} else

		if ( get_queried_object_id() === (Int) get_option('page_for_posts')   ) {
		    $html .=  '<li class="current"><span> '. get_the_title( get_queried_object_id() ) . ' </span>';
		}

		// If the current view is a post type other than page or attachment then the breadcrumbs will be taxonomies.
		if( is_category() || is_single() || is_post_type_archive() )
		{

		  if ( is_post_type_archive() )
		  {
		    $posttype = get_post_type_object( get_post_type() );
		    //$html .=  '<li class="current"><a href="'  . get_post_type_archive_link( $posttype->query_var ) .'" title="'. $posttype->labels->menu_name .'">'. $posttype->labels->menu_name  . '</a>';
		    $html .=  '<li class="current"><span>'. $posttype->labels->menu_name  . '</span>';
		  }

		  if ( is_category() )
		  {
		    $category = get_category( get_query_var( 'cat' ) );
		    //$html .=  '<li class="current"><a href="'  . get_category_link( $category->term_id ) .'" title="'. get_cat_name( $category->term_id ).'">'. get_cat_name($category->term_id ) . '</a>';
		    $html .=  '<li class="current"><span>'. get_cat_name($category->term_id ) . '</span>';
		  }

		  if ( is_single() )
		  {
		    if ( has_category() )
		    {
		      $thecat = get_the_category( $post->ID  );
		      $category = array_shift( $thecat ) ;
		      $html .=  '<li><a href="'  . get_category_link( $category->term_id ) .'" title="'. get_cat_name( $category->term_id ).'">'. get_cat_name($category->term_id ) . '</a>';
		    }
		    if ( uw_is_custom_post_type() )
		    {
		      $posttype = get_post_type_object( get_post_type() );
		      $archive_link = get_post_type_archive_link( $posttype->query_var );
		      if (!empty($archive_link)) {
		        $html .=  '<li><a href="'  . $archive_link .'" title="'. $posttype->labels->menu_name .'">'. $posttype->labels->menu_name  . '</a>';
		      }
		      else if (!empty($posttype->rewrite['slug'])){
		        $html .=  '<li><a href="'  . site_url('/' . $posttype->rewrite['slug'] . '/') .'" title="'. $posttype->labels->menu_name .'">'. $posttype->labels->menu_name  . '</a>';
		      }
		    }
		    $html .=  '<li class="current"><span>'. get_the_title( $post->ID ) . '</span>';
		  }
		}

		// If the current view is a page then the breadcrumbs will be parent pages.
		else if ( is_page() )
		{

		  if ( ! is_home() || ! is_front_page() )
		    $ancestors[] = $post->ID;

		  if ( ! is_front_page() )
		  {
		    foreach ( array_filter( $ancestors ) as $index=>$ancestor )
		    {
		      $class      = $index+1 == count($ancestors) ? ' class="current" ' : '';
		      $page       = get_post( $ancestor );
		      $url        = get_permalink( $page->ID );
		      $title_attr = esc_attr( $page->post_title );
		      if (!empty($class)){
		        $html .= "<li $class><span>{$page->post_title}</span></li>";
		      }
		      else {
		        $html .= "<li><a href=\"$url\" title=\"{$title_attr}\">{$page->post_title}</a></li>";
		      }
		    }
		  }

		}

		return "<nav class='uw-breadcrumbs' aria-label='breadcrumbs'><ul>$html</ul></nav>";
	}

endif;
