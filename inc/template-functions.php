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
	function uw_wp_theme_white_bar_menu() {
		if ( has_nav_menu( UW_Dropdowns::LOCATION ) ) {
			// only enqueue script when mega menu is present!
			wp_enqueue_script( 'uw_wp_theme-classic-script' );

				echo '<nav aria-label="main menu" class="navbar navbar-expand-md navbar-light ' . UW_Dropdowns::LOCATION .'">
						<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#' . UW_Dropdowns::LOCATION .'" aria-controls="' . UW_Dropdowns::LOCATION .'" aria-expanded="false" aria-label="Toggle navigation">
							<span class="navbar-toggler-icon">Menu</span>
						  </button><div class="container-fluid">';
				echo wp_nav_menu(
					array(
						'theme_location'    => UW_Dropdowns::LOCATION,
						'container_id'      => UW_Dropdowns::LOCATION,
						'container'         => 'div',
						'container_class'   => 'collapse navbar-collapse',
						'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
						'walker'            => new WP_Bootstrap_Navwalker(),
						'menu_class'        => 'navbar-nav classic-menu-nav',
						'depth'             => 3,
					)
				);
				echo '</div></nav>';
		}
	}
endif;

if ( ! function_exists( 'uw_wp_theme_purple_bar_menu' ) ) :
	function uw_wp_theme_purple_bar_menu() {
		echo wp_nav_menu(
			array(
				'theme_location'    => UW_Audience::LOCATION,
				'menu_id'           => UW_Audience::LOCATION,
				'container'         => 'ul',
				'menu_class'        => 'navbar-menu menu',
			)
		);
	}
endif;
if ( ! function_exists( 'uw_wp_theme_footer_menu' ) ) :
	function uw_wp_theme_footer_menu() {
		echo wp_nav_menu(
			array(
				'theme_location'    => UW_FooterMenu::LOCATION,
				'menu_id'           => UW_FooterMenu::LOCATION,
				'container'         => 'ul',
				'menu_class'        => 'footer-links',
				'fallback_cb'		=> 'UW_FooterMenu::fallback_menu',
			)
		);
	}
endif;

if ( ! function_exists( 'uw_site_title' ) ) :

	function uw_site_title() {
		$classes = 'uw-site-title';
		if ( get_option( 'overly_long_title' ) ) {
			$classes .= ' long-title';
		}

		if ( get_option( 'page_for_posts', true ) && ( is_home() || is_single() || is_archive() || is_category() || is_tag() ) ) {
			echo '<a href="' . esc_url( get_post_type_archive_link( 'post' ) ) . '" title="' . esc_attr( get_the_title( get_option( 'page_for_posts', true ) ) ) . '"><div class="' . esc_attr( $classes ) . '">' . esc_attr( get_the_title( get_option( 'page_for_posts', true ) ) ) . '</div></a>';
		} else {
			echo '<a href="' . home_url('/') . '" title="' . esc_attr( get_bloginfo() ) . '"><div class="' . $classes . '">' . get_bloginfo() . '</div></a>';
		}
	}

endif;

if ( ! function_exists('uw_is_custom_post_type') ) :

	function uw_is_custom_post_type()
	{
	  return get_post_type() ? array_key_exists(  get_post_type(),  get_post_types( array( '_builtin'=>false) ) ) : true;
	}

  endif;


if ( ! function_exists( 'uw_mobile_front_page_menu' ) ) :

  function uw_mobile_front_page_menu($class='') {
		$spacer = '';
	if (!empty($class)){
			$class = ' ' . $class;
			$spacer = '<div id="spacer"></div>';

	}
    echo sprintf( '<nav id="mobile-relative" class="frontpage%s" aria-label="mobile menu">%s%s</nav>', $class, $spacer, uw_list_front_page_menu_items() ) ;
  }

endif;

if ( ! function_exists( 'uw_list_front_page_menu_items' ) ) :

	function uw_list_front_page_menu_items() {
		$toggle = '<button class="uw-mobile-menu-toggle">Menu</button>';

		$items = wp_nav_menu( array(
				'title_li'     => '<a href="'.get_bloginfo('url').'" title="Home" class="homelink">Home</a>',
				'theme_location'  => UW_Dropdowns::LOCATION,
				'depth' => 2,
				'container_class' => '',
				'menu_class'      => '',
				'fallback_cb'     => '',
				'echo' => false,
			)
		);

		return $items ? sprintf( '%s<ul class="uw-mobile-menu first-level">%s</ul>', $toggle, $items ) : '';
	}

endif;


if ( ! function_exists( 'uw_breadcrumbs' ) ) :

	function uw_breadcrumbs() {

		if ( get_option( 'breadcrumb-hide' ) ) :
			return;
		endif;

		global $post;

		if ( isset( $post ) && get_post_meta( $post->ID, 'breadcrumbs', true ) ) {
			return;
		}

		$ancestors = array_reverse( get_post_ancestors( $post ) );
		$html      = '<li><a href="' . home_url( '/' ) . '" title="' . get_bloginfo( 'title' ) . '">' . get_bloginfo( 'title' ) . '</a>';

		if ( is_404() ) {
			$html .= '<li class="current"><span>Woof!</span>';
		} elseif ( is_search() ) {
			$html .= '<li class="current"><span>Search results for ' . get_search_query() . '</span>';
		} elseif ( is_author() ) {
			$author = get_queried_object();
			$html  .= '<li class="current"><span> Author: ' . $author->display_name . '</span>';
		} elseif ( get_queried_object_id() === (int) get_option( 'page_for_posts' ) ) {
			$html .= '<li class="current"><span> ' . get_the_title( get_queried_object_id() ) . ' </span>';
		}

		// If the current view is a post type other than page or attachment then the breadcrumbs will be taxonomies.
		if ( is_category() || is_single() || is_post_type_archive() || is_tag() ) {

			if ( is_post_type_archive() ) {
				$posttype = get_post_type_object( get_post_type() );
				//$html .=  '<li class="current"><a href="'  . get_post_type_archive_link( $posttype->query_var ) .'" title="'. $posttype->labels->menu_name .'">'. $posttype->labels->menu_name  . '</a>';
				$html .= '<li class="current"><span>' . $posttype->labels->menu_name  . '</span>';
			}

			if ( is_category() ) {
				if ( 'post' === get_post_type() && get_option( 'page_for_posts', true ) ) {
					$html .= '<li><a href="' . esc_url( get_post_type_archive_link( 'post' ) ) . '">' . get_the_title( get_option( 'page_for_posts' ) ) . '</a>';
				}

				$category = get_category( get_query_var( 'cat' ) );
				//$html .=  '<li class="current"><a href="'  . get_category_link( $category->term_id ) .'" title="'. get_cat_name( $category->term_id ).'">'. get_cat_name($category->term_id ) . '</a>';
				$html .= '<li class="current"><span>' . get_cat_name( $category->term_id ) . '</span>';
			}

			if ( is_tag() ) {
				if ( 'post' === get_post_type() && get_option( 'page_for_posts', true ) ) {
					$html .= '<li><a href="' . esc_url( get_post_type_archive_link( 'post' ) ) . '">' . get_the_title( get_option( 'page_for_posts' ) ) . '</a>';
				}

				$tag   = get_tag( get_queried_object_id() );
				$html .= '<li class="current"><span>' . $tag->slug . '</span>';
			}

			if ( is_single() ) {
				if ( 'post' === get_post_type() && get_option( 'page_for_posts', true ) ) {
					$html .= '<li><a href="' . esc_url( get_post_type_archive_link( 'post' ) ) . '">' . get_the_title( get_option( 'page_for_posts' ) ) . '</a>';
				} elseif ( has_category() ) {
					$thecat   = get_the_category( $post->ID );
					$category = array_shift( $thecat );
					$html    .= '<li><a href="' . get_category_link( $category->term_id ) . '" title="' . get_cat_name( $category->term_id ) . ' ">' . get_cat_name( $category->term_id ) . '</a>';
				}
				// check if is Custom Post Type.
				if ( ! is_singular( array( 'page', 'attachment', 'post' ) ) ) {
					$posttype = get_post_type_object( get_post_type() );
					$html    .= '<li><a href="' . home_url( '/' ) . '" title="' . get_bloginfo( 'title' ) . '">' . get_bloginfo( 'title' ) . '</a>';
				}

				$html .= '<li class="current"><span>' . get_the_title( $post->ID ) . '</span>';
			}
		} elseif ( is_page() ) {
			// If the current view is a page then the breadcrumbs will be parent pages.

			if ( ! is_home() || ! is_front_page() ) {
				$ancestors[] = $post->ID;
			}

			if ( ! is_front_page() ) {
				foreach ( array_filter( $ancestors ) as $index => $ancestor ) {

					$class      = $index + 1 === count( $ancestors ) ? ' class="current" ' : '';
					$page       = get_post( $ancestor );
					$url        = get_permalink( $page->ID );
					$title_attr = esc_attr( $page->post_title );

					if ( ! empty( $class ) ) {
						$html .= "<li $class><span>{$page->post_title}</span></li>";
					} else {
						$html .= "<li><a href=\"$url\" title=\"{$title_attr}\">{$page->post_title}</a></li>";
					}
				}
			}
		}

		return "<nav class='uw-breadcrumbs' aria-label='breadcrumbs'><ul>$html</ul></nav>";
	}
endif;

// Mega Menu navigation.
if ( ! function_exists( 'uw_wp_theme_mega_menu' ) ) :
	function uw_wp_theme_mega_menu() {
		if ( has_nav_menu( UW_MegaMenu::LOCATION ) ) {

			// only enqueue script when mega menu is present!
			wp_enqueue_script( 'uw_wp_theme-megamenu-script' );

			// output the mega menu.
			echo '<nav class="navbar white-bar navbar-expand-md navbar-light ' . UW_MegaMenu::LOCATION . '" aria-label="' . UW_MegaMenu::LOCATION . '">
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#' . UW_MegaMenu::LOCATION .'" aria-controls="' . UW_MegaMenu::LOCATION . '" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon">Menu</span>
				</button>
		  		<div class="container-fluid">';
			echo wp_nav_menu(
				array(
					'theme_location'    => UW_MegaMenu::LOCATION,
					'container_id'      => UW_MegaMenu::LOCATION,
					'container'         => 'div',
					'container_class'   => 'collapse navbar-collapse',
					'fallback_cb'       => 'Bootstrap_MegaMenu_Walker::fallback',
					'walker'            => new Bootstrap_MegaMenu_Walker(),
					'menu_class'        => 'navbar-nav megamenu-nav',
					'depth'             => 3,
				)
			);
			echo '</div></nav>';
		} else {
			// if no menu is set in the WP settings, add this message to the front end.
			echo '<div class="container"><div class="alert alert-warning" role="alert">You\'re almost there. Please add a menu to the Mega Menu in Appearance > Menus.</div></div>';
		}
	}
endif;



//adds Resources widget to right side of admin dashboard
add_action( 'wp_dashboard_setup', 'uw_dashboard_setup_function' );
function uw_dashboard_setup_function() {
    add_meta_box(
		'uw-dashboard-widget',
		'UW Theme Resources',
		'uw_dashboard_widget_function',
		'dashboard',
		'side',
		'high'
	);
}
function uw_dashboard_widget_function() {
    // widget content goes here

	echo '<div class="colums2">';
	echo '<p style="font-weight: 600;">Documentation and guides</p>';
	echo '<p><a href="https://github.com/uweb/uw_wp_theme" target="_blank">UW WordPress Theme repo</a> <span aria-hidden="true" class="dashicons dashicons-external"></span></p>';
 	echo '<p><a href="https://github.com/uweb/uw_wp_theme#readme" target="_blank">README.md</a> <span aria-hidden="true" class="dashicons dashicons-external"></span></p>';
	echo '<p><a href="https://www.washington.edu/brand/" target="_blank">UW Brand Portal</a> <span aria-hidden="true" class="dashicons dashicons-external"></span></p>';
	echo '</div>';

	echo '<div class="colums2">';
	echo '<p style="font-weight: 600;">Meetups</p>';
	echo '<p><a href="https://www.washington.edu/brand/web/web-council/">Web Council </a> <span aria-hidden="true" class="dashicons dashicons-external"></span></p>';
	echo '<p><a href="https://sites.uw.edu/wpug/">WordPress Users Group </a> <span aria-hidden="true" class="dashicons dashicons-external"></span></p>';
	echo '<br>';
	echo '<p><strong>Need help?</strong> Contact the  <a href="mailto:uweb@uw.edu">UMAC Web Strategy Team</a>. </p>';
	echo '</div>';
}

add_action( 'admin_enqueue_scripts', 'dashboard_widget_display_enqueues' );
function dashboard_widget_display_enqueues( $hook ) {

	wp_enqueue_style( 'dashboard-widget-styles', get_template_directory_uri( '', __FILE__ ) . '/assets/admin/css/dashboard-widgets.css' );
}

/**
 * Truncates the given string at the specified length.
 *
 * @param string $str The input string.
 * @param int $width The number of chars at which the string will be truncated.
 * @return string
 */
if ( !function_exists('uw_social_truncate') ) :
	function uw_social_truncate( $str, $width ) {
		return strtok( wordwrap( $str, $width, "...\n" ), "\n" );
	}
endif;


if ( !function_exists( 'uw_meta_tags' ) ) :
	function uw_meta_tags() {

		global $post;

		// Get the current site's URL
		$url = network_site_url();
		$site_url = home_url();
		$has_post_thumbnail = isset( $post->ID ) ? has_post_thumbnail( $post->ID ) : false;

		if( $url="http:/gs2.local/" || $url = "http://cmsdev.uw.edu/cms/" || $url = "https://www.washington.edu/cms/" ) {
			if ( $site_url === "https://www.washington.edu/cms/uwclimatesurvey" ) {

				$og_img = "https://s3-us-west-2.amazonaws.com/uw-s3-cdn/wp-content/uploads/sites/164/2019/10/16193323/Campus-Climate-Survey-Social-Facebook-1200x630.jpg";

				echo '<meta property="og:image" content="' . $og_img . '" />' . PHP_EOL;
			}
			else if( !$has_post_thumbnail ) {
				//the post does not have featured image, use a default image
				$default_image = "http://s3-us-west-2.amazonaws.com/uw-s3-cdn/wp-content/uploads/sites/10/2019/06/21094817/Univ-of-Washington_Memorial-Way.jpg";
				//replace this with a default image on your server or an image in your media library

				echo '<meta property="og:image" content="' . $default_image . '" />' . PHP_EOL;
			}
			else {
				$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );

				echo '<meta property="og:image" content="' . esc_attr( $thumbnail_src[0] ) . '" />' . PHP_EOL;
			}

			echo '<meta name="twitter:card" content="summary" />' . PHP_EOL;
			echo '<meta name="twitter:site" content="@uw" />' . PHP_EOL;
			echo '<meta name="twitter:creator" content="@uw" />' . PHP_EOL;
			echo '<meta name="twitter:card" content="summary_large_image" />' . PHP_EOL;
			echo '<meta property="og:title" content="' . html_entity_decode( get_the_title() ) . '" />' . PHP_EOL;
			// echo '<meta property="og:type" content="article"/>' . PHP_EOL;
			$actual_link = ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] === 'on' ? "https" : "http" ) . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			echo '<meta property="og:url" content="' . $actual_link . '" />' . PHP_EOL;
			echo '<meta property="og:site_name" content="' . get_bloginfo( 'name' ) . '" />' . PHP_EOL;

			if ( !is_singular() ) //if it is not a post or a page
			return;

			if ( trim( $post->post_excerpt ) != '' ) {
				//If there's an excerpt that's what we'll use
				$fb_desc = trim( $post->post_excerpt );
			} else {
				//If not we grab it from the content
				$fb_desc = trim( $post->post_content );
			}
			//Trim description
			$fb_desc = trim( str_replace( '&nbsp;', ' ', $fb_desc ) ); //Non-breaking spaces are usefull on a meta description. We'll just convert them to normal spaces to really trim it
			$fb_desc = trim( wp_strip_all_tags( strip_shortcodes( stripslashes( $fb_desc ), true ) ) );
			$fb_desc = uw_social_truncate( $fb_desc, 200 );

			echo '<meta property="og:description" content="' . $fb_desc . '" />' . PHP_EOL;
			if ( isset( $post->type_meta ) && $post->type_meta == 'article' && isset( $post->author_meta ) && $post->author_meta != '' ) { '<meta property="article:author" content="' . $post->author_meta . '" />' . PHP_EOL; }
			echo "
			" . PHP_EOL;
		}
	}
	add_action( 'wp_head', 'uw_meta_tags', 5 );
endif;

if ( !function_exists( 'uw_header_template' ) ) :

	function uw_header_template( $type ) {

		global $post;

		//$version = $type == 'big' ? '' : '2';
		if ( 'big' == $type ) {
			$version = '';
		} else if ( 'jumbotron' == $type ) {
			$version = 'jumbo';
		} else {
			$version = '2';
		}

		$background_url = get_post_thumbnail_id( $post->ID ) ? wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) ) : get_template_directory_uri() . "/assets/headers/suzzallo.jpg";

		$mobileimage_url = get_post_meta( $post->ID, "mobileimage" );
		$hasmobileimage = '';

		if ( !empty( $mobileimage_url ) && $mobileimage_url[0] !== "" ) {
			$mobileimage = $mobileimage_url[0];
			$hasmobileimage = 'hero-mobile-image';
		}

		$banner = get_post_meta( $post->ID, 'banner' );
		$buttontext = get_post_meta( $post->ID, 'buttontext' );
		$buttonlink = get_post_meta( $post->ID, 'buttonlink' );
		$pagetitle = get_post_meta( $post->ID, 'pagetitle' );

		?>
		<div class="uw-hero-image <?php echo esc_attr( $hasmobileimage ); ?> hero-height<?php echo esc_attr( $version ); ?>" style="background-image: url( <?php echo esc_url( $background_url ); ?> );" <?php echo ('jumbotron' == $type) ? 'role="region" aria-label="page title and banner"' : 'role="presentation"' ?>>
			<?php if ( isset( $mobileimage ) ) { ?>
				<div class="mobile-image" style="background-image: url( <?php echo $mobileimage ?> );"></div>
			<?php } ?>

			<div class="container-fluid">
				<?php if( 'jumbotron' == $type ) { ?> <!-- this is the jumbotron style hero -->
					<?php $subhead = get_post_meta( $post->ID, 'subhead' ); ?>

					<?php if( !empty( $banner ) && $banner[0] ) { ?>
						<div id="banner"><span><span><?php echo $banner[0] ? $banner[0] : ''; ?></span></span></div>
					<?php } ?>
					<div class="row col-sm-6 jumbo">
						<h1 class=" uw-site-title <?php echo $version ?>"><?php the_title(); ?></h1>
					</div>
					<?php if( !empty( $subhead ) && $subhead[0] ) { ?>
					<div class="row col-sm-6 jumbo">
						<p class="jumbo-subhead" ><?php echo $subhead[0] ? $subhead[0] : '';  ?></p>
					</div>
					<?php } ?>
					<?php if( !empty( $buttontext ) && $buttontext[0] ) { ?>
						<a class="btn btn-lg arrow white" href="<?php echo $buttonlink && $buttontext[0] ? $buttonlink[0] : ''; ?>"><span><?php echo $buttontext[0] ? $buttontext[0] : ''; ?></span><span class="arrow-box"><span class="arrow"></span></span></a>

					<?php } ?>
				<?php } else { ?> <!-- this is the other hero types -->
					<?php if( !empty( $banner ) && $banner[0] ) { ?>
						<div id="hashtag"><span><span><?php echo $banner[0] ? $banner[0] : ''; ?></span></span></div>
					<?php } ?>

					<?php if ( ! empty( $pagetitle ) && $pagetitle[0] ) { ?>
						<!-- do not show site title -->
					<?php } else { ?>
						<h1 class="uw-site-title<?php echo $version ?>"><?php the_title(); ?></h1>
						<?php if( !empty( $subhead ) && $subhead[0] ) {
							echo $subhead;
						}
						?>
						<span class="udub-slant"><span></span></span>
					<?php } ?>


					<?php if( !empty( $buttontext ) && $buttontext[0] ) { ?>
						<a class="btn btn-lg arrow white" href="<?php echo $buttonlink && $buttontext[0] ? $buttonlink[0] : ''; ?>"><span><?php echo $buttontext[0] ? $buttontext[0] : ''; ?></span><span class="arrow-box"><span class="arrow"></span></span></a>

					<?php } ?>

					<?php } ?>
			</div>
		</div>
		<?php if ( ! empty( $pagetitle ) && $pagetitle[0] ) { ?>
			<div role="region" aria-label="page title" class="container-fluid mt-3">
				<h1 class="uw-site-title<?php echo esc_attr( $version ); ?> below-hero"><?php the_title(); ?></h1>
			</div>
				<?php } else { ?>
					<!-- do nothing -->
				<?php } ?>
		<?php

	}

endif;

if ( ! function_exists( 'is_pdf' ) ):

	function is_pdf() {
	  return get_post_mime_type() == 'application/pdf';
	}

  endif;


  if ( ! function_exists( 'add_sitewide_banner' ) ):
	function add_sitewide_banner() {
		if (  get_option( 'uw_activate_banner' ) && get_option( 'banner_message' )   ){
			echo '<div class="banner alert ' . get_option( 'banner_color' ) .' alert-dismissible fade show " role="alert"><p>' . wp_kses_post( get_option( 'banner_message' ) ) .'</p> <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button></div>';
		}
	}

endif;

function error_notice(){
	if ( get_option( 'uw_activate_banner' ) && ! get_option( 'banner_message' ) ) {
		global $current_screen;
		$admin_screen = get_current_screen();

		if ( 'appearance_page_sitewide-banner' === $admin_screen->base ) {

			echo '<div class="notice notice-warning is-dismissible">
			<p>You must enter content in the "Alert message" field for the alert to appear on your site</p>
			</div>';
		}
	}
}
add_action('admin_notices', 'error_notice');
