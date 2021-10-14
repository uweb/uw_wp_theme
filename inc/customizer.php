<?php
/**
 * UW WordPress Theme Theme Customizer
 *
 * @package uw_wp_theme
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function uw_wp_theme_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname', array(
				'selector'        => '.site-title a',
				'render_callback' => 'uw_wp_theme_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription', array(
				'selector'        => '.site-description',
				'render_callback' => 'uw_wp_theme_customize_partial_blogdescription',
			)
		);
	}

	/**
	 * Theme options.
	 */
	$wp_customize->add_section(
		'theme_options', array(
			'title'    => __( 'Theme Options', 'uw_wp_theme' ),
			'priority' => 130, // Before Additional CSS.
		)
	);
}
add_action( 'customize_register', 'uw_wp_theme_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function uw_wp_theme_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function uw_wp_theme_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function uw_wp_theme_customize_preview_js() {
	$template_directory = get_bloginfo( 'template_directory' );
	$theme_version = wp_get_theme( get_template( ) )->get( 'Version' );

	wp_enqueue_script( 'uw_wp_theme-customizer', $template_directory. '/js/customizer.js', array( 'customize-preview' ), $theme_version, true );
}
add_action( 'customize_preview_init', 'uw_wp_theme_customize_preview_js' );
