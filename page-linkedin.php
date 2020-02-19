<?php
/**
 * Template Name: LinkedIn Swag
 * Render the LinkedIn Swag page.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#front-page-display
 *
 * @package uw_wp_theme
 */

get_header();

/*
* Include the component stylesheet for the content.
* This call runs only once on index and archive pages.
* At some point, override functionality should be built in similar to the template part below.
*/
wp_print_styles( array( 'uw_wp_theme-content', 'uw_wp_theme-bootstrap' ) ); // Note: If this was already done it will be skipped.

?>
	<main id="primary" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content-linkedin', get_post_type() );

		endwhile; // End of the loop.
		?>
		<?php the_posts_navigation(); ?>

	</main><!-- #primary -->

<?php
get_footer();
