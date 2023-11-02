<?php
/**
 * Custom 404 page settings
 *
 * @package uw_wp_theme
 */
function uw_custom_404_page() { ?>
	<div class="wrap">
		<h2>Custom 404 page</h2>
		<?php settings_errors(); ?>
		<p>Use this setting to provide custom information, specific to your site, that will appear in the 404 page template. We recommend adding a list of relevant links that will help direct folks to the page they are trying to find. <strong>Please note: shortcodes are not allowed in this section.</strong></p>

		<p>Check the box to enable the custom 404 content and include your content below.</p>

		<form name="custom_404_form" method="post" action="options.php">
			<?php
				settings_fields( 'custom_404_section' );
				do_settings_sections( 'uw-custom-404' );
				submit_button();
			?>
		</form>

	</div>
	<?php
}

function register_custom_404_menu() {
	add_submenu_page(
		'themes.php', // where the menu page is added (parent slug).
		'Custom 404 page', // title of the page.
		'Custom 404 page', // menu item title.
		'activate_plugins', // capability.
		'uw-custom-404', // slug of page.
		'uw_custom_404_page' // callback function to display form.
	);
}
add_action( 'admin_menu', 'register_custom_404_menu' );

function uw_activate_custom_404() {
	?>
		<input type="checkbox" name="uw_activate_custom_404" value="1" <?php checked( 1, get_option( 'uw_activate_custom_404' ), true ); ?> />
	<?php
}

function display_custom_404_input() {
	$content            = get_option( 'custom_404_input' ) ? get_option( 'custom_404_input' ) : '';
	$custom_editor_id   = 'custom_404_input';
	$custom_editor_name = 'custom_404_input';
	$args               = array(
		'textarea_name' => $custom_editor_name, // Set custom name.
	);
	wp_editor( $content, $custom_editor_id, $args );
}

function display_404_subpage_fields() {

	add_settings_section( 'custom_404_section', '', null, 'uw-custom-404' );

	add_settings_field( 'uw_activate_custom_404', 'Enable custom 404 content', 'uw_activate_custom_404', 'uw-custom-404', 'custom_404_section' );

	add_settings_field( 'custom_404_input', 'Custom 404 page content', 'display_custom_404_input', 'uw-custom-404', 'custom_404_section' );

	register_setting( 'custom_404_section', 'uw_activate_custom_404' );
	register_setting( 'custom_404_section', 'custom_404_input' );
}
add_action( 'admin_init', 'display_404_subpage_fields' );
