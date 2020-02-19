<?php
/**
 * The template for displaying all pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package uw_wp_theme
 */

get_header();

$sidebar = get_post_meta( $post->ID, 'sidebar' );

// if this is the public lectures site.
if ( false !== strpos( $_SERVER['REQUEST_URI'], 'lectures' ) ) {
	require get_template_directory() . '/pluggable/lectures/header-image.php';
} else {
	get_template_part( 'template-parts/header', 'image' );
}

?>


<div class="container uw-body">
	<div class="row">

		<main id="primary" class="site-main uw-body-copy col-md-<?php echo ( ( ! isset( $sidebar[0] ) || 'on' !== $sidebar[0] ) ? '8' : '12' ); ?>"

		<?php
		while ( have_posts() ) : the_post();

			/*
				* Include the component stylesheet for the content.
				* This call runs only once on index and archive pages.
				* At some point, override functionality should be built in similar to the template part below.
				*/
			wp_print_styles( array( 'uw_wp_theme-content' ) ); // Note: If this was already done it will be skipped.

			get_template_part( 'template-parts/content', 'page' );

		endwhile; // End of the loop.
		?>

		</main><!-- #primary -->

		<?php
		if ( ! isset( $sidebar[0] ) || 'on' !== $sidebar[0] ) {
			get_sidebar();
		}
		?>

	</div><!-- .row -->
</div><!-- .container -->

<?php
get_footer();
