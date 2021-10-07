<?php
/**
 * Custom Header feature
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package uw_wp_theme
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses uw_wp_theme_header_style()
 */
function uw_wp_theme_custom_header_setup() {
	
	$path = get_template_directory_uri() . '/assets/headers/';
	
	$default_headers = array(
		'suzzallo' => array(
			'url'			=> $path . 'suzzallo.jpg',
			'thumbnail_url' => $path . 'suzzallo-thumbnail.jpg',
			'description'   => 'Suzzallo library'
		),
		
		'blossoms' => array(
			'url'			=> $path . 'blossoms.jpg',
			'thumbnail_url' => $path . 'blossoms-thumbnail.jpg',
			'description'   => 'Cherry blossoms'
		),
		
		'fall-leaves' => array(
			'url'			=> $path . 'fall-leaves.jpg',
			'thumbnail_url' => $path . 'fall-leaves-thumbnail.jpg',
			'description'   => 'Fall leaves'
		),
		
		'new-burke' => array(
			'url'			=> $path . 'new-burke.png',
			'thumbnail_url' => $path . 'new-burke-thumbnail.png',
			'description'   => 'New Burke Seattle'
		),
		
		'ima' => array(
			'url'			=> $path . 'ima.jpg',
			'thumbnail_url' => $path . 'ima-thumbnail.jpg',
			'description'   => 'IMA'
		),
		
		'purple' => array(
			'url'			=> $path . 'purple.jpg',
			'thumbnail_url' => $path . 'purple-thumbnail.jpg',
			'description'   => 'Purple'
		),
	);
	
	register_default_headers( $default_headers );
	
	add_theme_support(
		'custom-header', apply_filters(
			'uw_wp_theme_custom_header_args', array(
				'default-image'		=> $default_headers['suzzallo']['url'],
				'random-default'	=> false,
				'header-text'		=> false,
				'width'				=> 1600,
				'height'			=> 350,
				'flex-height'		=> true,
				'flex-width'		=> true,
				'uploads'			=> true,
			)
		)
	);
}
add_action( 'after_setup_theme', 'uw_wp_theme_custom_header_setup' );
