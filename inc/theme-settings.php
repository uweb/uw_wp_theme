<?php
/**
 * Theme settings page
 *
 * @package uw_wp_theme
 */
function theme_settings_page() {
	?>
		<div class="wrap">
			<h1>Theme Panel</h1>

			<?php settings_errors(); ?>
			<div class="notice notice-info is-dismissible">
				<p>Check out the <a href="https://github.com/uweb/uw_wp_theme#readme" target="_blank">theme documentation</a> for more information on these settings.</p>
			</div>
			<div class="card" style="float: right;">
				<?php UW_dashboard_widget_function(); ?>
			</div>
			<div style="float: left;">
				<form method="post" action="options.php">
					<?php
						settings_fields( 'section' );
						do_settings_sections( 'theme-options' );
						submit_button();
					?>
				</form>
			</div>
		</div>
	<?php
}
function add_theme_menu_item() {
	add_menu_page( "Theme Panel", "Theme Panel", "manage_options", "theme-panel", "theme_settings_page", null, 99 );
}

add_action( "admin_menu", "add_theme_menu_item" );


function nav_menu_options() {
	$nav_option = get_option( 'nav_menu_options' );

	if ( ! isset( $nav_option['uw_nav_options'] ) ) {
		$nav_option['uw_nav_options'] = 'default';
	}

	?>
		<select name="nav_menu_options[uw_nav_options]" id="uw_nav_options">
			<option value="default" <?php selected( $nav_option['uw_nav_options'], 'default' ); ?>>Default (classic uw-2014)</option>
			<option value="mega" <?php selected( $nav_option['uw_nav_options'], 'mega' ); ?>>Mega Menu</option>
		</select>
	<?php
}

function toggle_search_options() {
	$toggle_option = get_option( 'toggle_search_options' );

	if ( ! isset( $toggle_option['uw_toggle_options'] ) ) {
		$toggle_option['uw_toggle_options'] = 'uw';
	}
	?>
		<select name="toggle_search_options[uw_toggle_options]" id="uw_toggle_options">
			<option value="uw" <?php selected( $toggle_option['uw_toggle_options'], 'uw' ); ?>>All the UW</option>
			<option value="site" <?php selected( $toggle_option['uw_toggle_options'], 'site' ); ?>>Current site</option>
 		</select>
    <?php
}
 function display_quicklinks_element() {
 	?>
		<input type="checkbox" name="quicklinks-hide" value="1" <?php checked( 1, get_option( 'quicklinks-hide' ), true ); ?> />
	<?php
	}

 function display_breadcrumb_element() {
 	?>
		<input type="checkbox" name="breadcrumb-hide" value="1" <?php checked( 1, get_option( 'breadcrumb-hide' ), true ); ?> />
	<?php
	}

 function display_search_element() {
	 ?>
		<input type="checkbox" name="search-hide" value="1" <?php checked( 1, get_option( 'search-hide' ), true ); ?> />
		 <?php
 }

 function display_overly_long_title() {
	 ?>
		<input type="checkbox" name="overly_long_title" value="1" <?php checked( 1, get_option( 'overly_long_title' ), true ); ?> />
		 <?php
 }

 function display_byline_on_posts() {
	 ?>
		<input type="checkbox" name="show_byline_on_posts" value="1" <?php checked( 1, get_option( 'show_byline_on_posts' ), true ); ?> />
		 <?php
 }

function display_theme_panel_fields() {
	add_settings_section( 'section', 'All Settings', null, 'theme-options' );

	add_settings_field( 'uw_nav_options', 'Main navigation menu style', 'nav_menu_options', 'theme-options', 'section' );

	add_settings_field( 'overly_long_title', 'Does your site title take two lines on desktop?', 'display_overly_long_title', 'theme-options', 'section' );

	add_settings_field( 'show_byline_on_posts', 'Show bylines on single posts and archives?', 'display_byline_on_posts', 'theme-options', 'section' );

    add_settings_field("breadcrumb-hide", "Hide Breadcrumbs from site", "display_breadcrumb_element", "theme-options", "section");

    add_settings_field("quicklinks-hide", "Hide Quicklinks menu button", "display_quicklinks_element", "theme-options", "section");

    // add_settings_field("search-hide", "Hide Search menu button", "display_search_element", "theme-options", "section");

    add_settings_field( 'uw_toggle_options', 'Toggle Search site', 'toggle_search_options', 'theme-options', 'section' );

	  register_setting( 'section', 'toggle_search_options' );
  
    // register_setting("section", "search-hide");

    register_setting( "section", "quicklinks-hide" );

    register_setting( "section", "breadcrumb-hide" );

	register_setting( 'section', 'nav_menu_options' );

	register_setting( 'section', 'overly_long_title' );

	register_setting( 'section', 'show_byline_on_posts' );
}

add_action( 'admin_init', 'display_theme_panel_fields' );
