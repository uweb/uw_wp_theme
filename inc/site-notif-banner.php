<?php
/**
 * Site-wide notification banner settings page
 *
 * @package uw_wp_theme
 */
function uw_site_notif_banner_page() { ?>
	<div class="wrap">
		<h2>Site-wide Notification Banner</h2>
		<?php settings_errors(); ?>
		<h3>Use this to add a site-wide notification message near the top of every page on your site.</h3>
		<p> The banner will appear just under your main navigation menu.
			Users can dismiss the banner on a page, but the banner will persist across other pages. </p>
		<p></p>

		<form name="banner_form" method="post" action="options.php">
			<?php
						settings_fields( 'sitenotif_section' );
						do_settings_sections( 'sitewide-banner' );
						submit_button();
			?>
		</form>

	</div>
	<?php
}

function register_sub_menu() {
	add_submenu_page(
		'themes.php', // where the menu page is added (parent slug).
		'Site Notification Banner ', // title of the page.
		'Site Notification Banner ', // menu item title.
		'manage_options', // capability.
		'sitewide-banner', // slug of page.
		'uw_site_notif_banner_page' // callback function to display form.
	);
}

add_action( 'admin_menu', 'register_sub_menu' );

function uw_activate_banner() {
	?>
		<input type="checkbox" name="uw_activate_banner" value="1" <?php checked( 1, get_option( 'uw_activate_banner' ), true ); ?> />
	<?php
}
function display_banner_message() {
	?>

	<input type="text" name="banner_message" value="<?php  echo get_option( 'banner_message' ) ?>" size="50">

	<?php
}

function display_banner_color_options() {
	?>
	<input type="radio" id="alert-primary" name="banner_color" value="alert-primary" <?php if( get_option ( 'banner_color' ) == 'alert-primary' ) echo 'checked="checked" '; ?> >
			<label for="alert-primary">Primary alert (purple) </label><br>
			<input type="radio" id="alert-secondary" name="banner_color" value="alert-secondary" <?php if( get_option ( 'banner_color' ) == 'alert-secondary' ) echo 'checked="checked" '; ?>>
			<label for="alert-secondary">Secondary alert (gold)</label><br>
			<input type="radio" id="alert-success" name="banner_color" value="alert-success" <?php if( get_option ( 'banner_color' ) == 'alert-success' ) echo 'checked="checked" '; ?>>
			<label for="alert-success">Success alert (green)</label><br>
			<input type="radio" id="alert-danger" name="banner_color" value="alert-danger" <?php if( get_option ( 'banner_color' ) == 'alert-danger' ) echo 'checked="checked" '; ?>>
			<label for="alert-danger">Danger alert (red)</label><br>
			<input type="radio" id="alert-warning" name="banner_color" value="alert-warning" <?php if( get_option ( 'banner_color' ) == 'alert-warning' ) echo 'checked="checked" '; ?>>
			<label for="alert-warning">Warning alert (yellow)</label><br>
			<input type="radio" id="alert-info" name="banner_color" value="alert-info" <?php if( get_option ( 'banner_color' ) == 'alert-info' ) echo 'checked="checked" '; ?>>
			<label for="alert-info">Info alert (blue)</label><br>
			<input type="radio" id="alert-dark" name="banner_color" value="alert-dark" <?php if( get_option ( 'banner_color' ) == 'alert-dark' ) echo 'checked="checked" '; ?>>
			<label for="alert-dark">Dark alert (grey)</label><br>
			<div class="uw-admin-banners">(<a id='enchanced-preview' href='#'>Preview Banner styles<span><img src='https://uw-s3-cdn.s3.us-west-2.amazonaws.com/wp-content/uploads/sites/193/2022/10/31134455/uw-banner-boostrap-alert-styles.png' alt='' width='500px' height='' /></span></a>)</div>
	<?php
}

function display_subpage_fields() {

	add_settings_section( 'sitenotif_section', 'All Settings', null, 'sitewide-banner' );

	add_settings_field( 'uw_activate_banner', 'Turn on banner', 'uw_activate_banner', 'sitewide-banner', 'sitenotif_section' );

	add_settings_field( 'banner_message', 'Banner message', 'display_banner_message', 'sitewide-banner', 'sitenotif_section' );

	add_settings_field( 'banner_color', 'Banner color options', 'display_banner_color_options', 'sitewide-banner', 'sitenotif_section' );


	register_setting( 'sitenotif_section', 'uw_activate_banner' );
	register_setting( 'sitenotif_section', 'banner_message' );
	register_setting( 'sitenotif_section', 'banner_color' );
}
add_action( 'admin_init', 'display_subpage_fields' );
