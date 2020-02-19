<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package uw_wp_theme
 */

?>
<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php if ( ! uw_wp_theme_is_amp() ) : ?>
		<script>document.documentElement.classList.remove("no-js");</script>
	<?php endif; ?>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<a class="sr-only sr-only-focusable skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'uw_wp_theme' ); ?></a>

<div id="uwsearcharea" aria-hidden="true" class="uw-search-bar-container"></div>

<div id="page" class="site">
	<div id="page-inner">
		<header id="masthead" class="site-header">
			<nav class="navbar navbar-expand-lg">
				<div class="navbar-brand site-branding">
					<a href="http://uw.edu" title="University of Washington Home" class="uw-patch">University of Washington</a>
					<a href="http://uw.edu" title="University of Washington Home" class="uw-wordmark" tabindex="-1" aria-hidden="true">University of Washington</a>
				</div><!-- .site-branding -->

				<div id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Main menu', 'uw_wp_theme' ); ?>"
					<?php if ( uw_wp_theme_is_amp() ) : ?>
						[class]=" siteNavigationMenu.expanded ? 'main-navigation toggled-on' : 'main-navigation' "
					<?php endif; ?>
				>
					<?php if ( uw_wp_theme_is_amp() ) : ?>
						<amp-state id="siteNavigationMenu">
							<script type="application/json">
								{
									"expanded": false
								}
							</script>
						</amp-state>
					<?php endif; ?>
					</button>

					<div class="audience-menu-container collapse navbar-collapse">
						<?php uw_wp_theme_purple_bar_menu(); ?>
					</div>
					<div id="search-quicklinks">
						<button class="uw-search" aria-owns="uwsearcharea" aria-controls="uwsearcharea" aria-expanded="false" aria-label="open search area" aria-haspopup="true">
							<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="19px" height="51px" viewBox="0 0 18.776 51.062" enable-background="new 0 0 18.776 51.062" xml:space="preserve" focusable="false">
								<g><path fill="#FFFFFF" d="M3.537,7.591C3.537,3.405,6.94,0,11.128,0c4.188,0,7.595,3.406,7.595,7.591 c0,4.187-3.406,7.593-7.595,7.593C6.94,15.185,3.537,11.778,3.537,7.591z M5.245,7.591c0,3.246,2.643,5.885,5.884,5.885 c3.244,0,5.89-2.64,5.89-5.885c0-3.245-2.646-5.882-5.89-5.882C7.883,1.71,5.245,4.348,5.245,7.591z"/><rect x="2.418" y="11.445" transform="matrix(0.7066 0.7076 -0.7076 0.7066 11.7842 2.0922)" fill="#FFFFFF" width="1.902" height="7.622"/></g><path fill="#FFFFFF" d="M3.501,47.864c0.19,0.194,0.443,0.29,0.694,0.29c0.251,0,0.502-0.096,0.695-0.29l5.691-5.691l5.692,5.691 c0.192,0.194,0.443,0.29,0.695,0.29c0.25,0,0.503-0.096,0.694-0.29c0.385-0.382,0.385-1.003,0-1.388l-5.692-5.691l5.692-5.692 c0.385-0.385,0.385-1.005,0-1.388c-0.383-0.385-1.004-0.385-1.389,0l-5.692,5.691L4.89,33.705c-0.385-0.385-1.006-0.385-1.389,0 c-0.385,0.383-0.385,1.003,0,1.388l5.692,5.692l-5.692,5.691C3.116,46.861,3.116,47.482,3.501,47.864z"/>
							</svg>
						</button>
						<button class="uw-quicklinks" aria-haspopup="true" aria-expanded="false" aria-label="Open quick links">Quick Links
							<svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="15.63px" height="69.13px" viewBox="0 0 15.63 69.13" enable-background="new 0 0 15.63 69.13" xml:space="preserve" focusable="false"><polygon fill="#FFFFFF" points="12.8,7.776 12.803,7.773 5.424,0 3.766,1.573 9.65,7.776 3.766,13.98 5.424,15.553 12.803,7.78"/><polygon fill="#FFFFFF" points="9.037,61.351 9.036,61.351 14.918,55.15 13.26,53.577 7.459,59.689 1.658,53.577 0,55.15 5.882,61.351 5.882,61.351 5.884,61.353 0,67.557 1.658,69.13 7.459,63.019 13.26,69.13 14.918,67.557 9.034,61.353"/></svg>
						</button>
					</div><!-- search-quicklinks -->
				</div><!-- #site-navigation -->
			</nav><!-- .navbar.navbar-expand-lg -->
		</header><!-- #masthead -->
	<?php uw_wp_theme_white_bar_menu(); ?>
	<?php wp_print_styles( array( 'uw_wp_theme-content', 'uw_wp_theme-bootstrap' ) ); // Note: If this was already done it will be skipped. ?>
