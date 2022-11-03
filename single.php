<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package uw_wp_theme
 */

get_header();
$sidebar = get_post_meta( $post->ID, 'sidebar' );

// get the image header.
get_template_part( 'template-parts/header', 'image' );

?>
<div class="container-fluid ">
<?php echo uw_breadcrumbs(); ?>

</div>
<div class="container-fluid uw-body">
	<div class="row">
		<main id="primary" class="site-main uw-body-copy col-md-<?php echo ( ( ! isset( $sidebar[0] ) || 'on' !== $sidebar[0] ) ? '8' : '12' ); ?>">

		<?php

		if ( have_posts() ) :

			/* Display the appropriate header when required. */
			uw_wp_theme_index_header();

			/* Start the Loop. */
			while ( have_posts() ) :
				the_post();

				/*
				* Include the Post-Type-specific template for the content.
				* If you want to override this in a child theme, then include a file
				* called content-___.php (where ___ is the Post Type name) and that will be used instead.
				*/
				get_template_part( 'template-parts/content', get_post_type() );

			endwhile; // End of the loop.
		endif;
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
