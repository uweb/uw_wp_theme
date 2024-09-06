<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package uw_wp_theme
 */

//if ( ! is_active_sidebar( 'sidebar' ) ) {
	//return;
//}
?>

<?php //wp_print_styles( array( 'uw_wp_theme-sidebar', 'uw_wp_theme-widgets' ) ); ?>
<aside id="secondary" aria-label="sidebar" class="primary-sidebar uw-sidebar widget-area col-md-4">
	<?php uw_sidebar_menu(); ?>
	<?php dynamic_sidebar( 'sidebar' ); ?>
</aside><!-- #secondary -->
