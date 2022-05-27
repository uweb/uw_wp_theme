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

	<script>document.documentElement.classList.remove("no-js");</script>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<a class="screen-reader-shortcut" href="#primary"><?php esc_html_e( 'Skip to content', 'uw_wp_theme' ); ?></a>


<?php $toggle_option = get_option( 'toggle_search_options' ) ? get_option( 'toggle_search_options' )['uw_toggle_options'] : 'uw';
 ?>
<div id="uwsearcharea" aria-hidden="true" class="uw-search-bar-container" data-search="<?php echo $toggle_option ?>" hidden>

	<div class="container no-height" role="search">
		<div class="center-block uw-search-wrapper">
			<form class="uw-search" data-sitesearch="<?php echo esc_url( home_url() ) . '/'; ?>" action="<?php echo ( 'uw' === $toggle_option ? 'https://uw.edu/search' : esc_url( home_url() ) . '/' ); ?>">
				<div class="search-form-wrapper">
					<label class="screen-reader" for="uw-search-bar">Enter search text</label>
					<input id="uw-search-bar" type="search"
						name="<?php
							echo ( 'uw' === $toggle_option ? 'q' : 's' );
						?>"
						value="" autocomplete="off" placeholder="Search" />
				</div>
				<select id="mobile-search-select" class="visible-xs" aria-label="Search scope">
					<?php if ($toggle_option === 'uw') {  ?>
						<option value="uw" >All the UW</option>
						<option value="site">Current site</option>
					<?php } else { ?>
						<option value="site" >Current site</option>
						<option value="uw">All the UW</option>
					<?php } ?>
				</select>
				<input type="submit" value="search" class="search" tabindex="0"/>
				<fieldset style="margin: 0; padding: 0; border: 1px solid #ffffff;">
					<legend id="uw-search-label">Search scope</legend>
					<div id="search-labels" class="labels hidden-xs">
						<!--load these labels and input if UW is selected in Theme Settings -->
					<?php if ( $toggle_option  ==='uw' ) { ?>
						<label id="uw" class="radio checked"><input class="radiobtn" type="radio" name="search" value="uw" data-toggle="radio" checked />All the UW</label>
						<label id="site" class="radio"><input  class="radiobtn" type="radio" name="search" value="site" data-toggle="radio" />Current site</label>

					<!--OR load these labels and input if Site is selected in Theme Settings -->
					<?php } else { ?>
						<label id="site" class="radio checked"><input class="radiobtn" type="radio" name="search" value="site" data-toggle="radio" checked/>Current site</label>
						<label id="uw" class="radio"><input class="radiobtn" type="radio" name="search" value="uw" data-toggle="radio" />All the UW</label>
					<?php } ?>
					</div>
				</fieldset>
			</form>
		</div>
	</div>
</div>

<div id="page" class="site">
<?php if ( ! get_option( 'quicklinks-hide' ) ) {
	get_template_part( 'template-parts/menu', 'quicklinks' );
 } ?>
	<div id="page-inner">
		<header id="masthead" class="site-header">
			<div class="navbar navbar-expand-lg">
				<div class="navbar-brand site-branding">
					<a href="http://uw.edu" title="University of Washington Home" class="uw-patch" tabindex="0">University of Washington</a>
					<a href="http://uw.edu" title="University of Washington Home" class="uw-wordmark" tabindex="-1" aria-hidden="true">University of Washington</a>
				</div><!-- .site-branding -->

				<div id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Main menu', 'uw_wp_theme' ); ?>">

					<div class="audience-menu-container collapse navbar-collapse">
						<?php uw_wp_theme_purple_bar_menu(); ?>
					</div>
					<div id="search-quicklinks">
						<button class="uw-search" aria-owns="uwsearcharea" aria-controls="uwsearcharea" aria-expanded="false" aria-label="open search area" aria-haspopup="true">
							<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="19px" height="51px" viewBox="0 0 18.776 51.062" enable-background="new 0 0 18.776 51.062" xml:space="preserve" focusable="false">
								<g><path fill="#FFFFFF" d="M3.537,7.591C3.537,3.405,6.94,0,11.128,0c4.188,0,7.595,3.406,7.595,7.591 c0,4.187-3.406,7.593-7.595,7.593C6.94,15.185,3.537,11.778,3.537,7.591z M5.245,7.591c0,3.246,2.643,5.885,5.884,5.885 c3.244,0,5.89-2.64,5.89-5.885c0-3.245-2.646-5.882-5.89-5.882C7.883,1.71,5.245,4.348,5.245,7.591z"/><rect x="2.418" y="11.445" transform="matrix(0.7066 0.7076 -0.7076 0.7066 11.7842 2.0922)" fill="#FFFFFF" width="1.902" height="7.622"/></g><path fill="#FFFFFF" d="M3.501,47.864c0.19,0.194,0.443,0.29,0.694,0.29c0.251,0,0.502-0.096,0.695-0.29l5.691-5.691l5.692,5.691 c0.192,0.194,0.443,0.29,0.695,0.29c0.25,0,0.503-0.096,0.694-0.29c0.385-0.382,0.385-1.003,0-1.388l-5.692-5.691l5.692-5.692 c0.385-0.385,0.385-1.005,0-1.388c-0.383-0.385-1.004-0.385-1.389,0l-5.692,5.691L4.89,33.705c-0.385-0.385-1.006-0.385-1.389,0 c-0.385,0.383-0.385,1.003,0,1.388l5.692,5.692l-5.692,5.691C3.116,46.861,3.116,47.482,3.501,47.864z"/>
							</svg>
						</button>
						<?php if ( ! get_option( 'quicklinks-hide' ) ) { ?>
							<button class="uw-quicklinks" aria-haspopup="true" aria-expanded="false" aria-label="Open quick links">Quick Links
								<svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="15.63px" height="69.13px" viewBox="0 0 15.63 69.13" enable-background="new 0 0 15.63 69.13" xml:space="preserve" focusable="false"><polygon fill="#FFFFFF" points="12.8,7.776 12.803,7.773 5.424,0 3.766,1.573 9.65,7.776 3.766,13.98 5.424,15.553 12.803,7.78"/><polygon fill="#FFFFFF" points="9.037,61.351 9.036,61.351 14.918,55.15 13.26,53.577 7.459,59.689 1.658,53.577 0,55.15 5.882,61.351 5.882,61.351 5.884,61.353 0,67.557 1.658,69.13 7.459,63.019 13.26,69.13 14.918,67.557 9.034,61.353"/></svg>
							</button>
						<?php } ?>
					</div><!-- search-quicklinks -->
				</div><!-- #site-navigation -->
			</div><!-- .navbar.navbar-expand-lg -->
		</header><!-- #masthead -->

	<?php
	$nav_option = get_option( 'nav_menu_options' );

	// if the mega menu is set, load the mega menu.
	if ( isset( $nav_option['uw_nav_options'] ) ) {
		if ( 'mega' === $nav_option['uw_nav_options'] ) {
			uw_wp_theme_mega_menu();
		} else {
			// load the classic but updated 2014 menu.
			uw_wp_theme_white_bar_menu();
		}
	} else {
		// load the classic but updated 2014 menu.
		uw_wp_theme_white_bar_menu();
	}

	?>
