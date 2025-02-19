<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package uw_wp_theme
 */

get_header();

$sidebar = isset( $post ) ? get_post_meta( $post->ID, 'sidebar' ) : '';

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

		if ( have_posts() ) {

			/* Display the appropriate header when required. */
			uw_wp_theme_index_header();

			/* Start the Loop. */
			while ( have_posts() ) {
				the_post();

				/*
				* Include the Post-Type-specific template for the content.
				* If you want to override this in a child theme, then include a file
				* called content-___.php (where ___ is the Post Type name) and that will be used instead.
				*/
				get_template_part( 'template-parts/content', get_post_type() );

			};

			if ( ! is_singular() ) {
				the_posts_pagination(
					array(
						'mid_size'           => 2,
						'prev_text'          => __( '&lsaquo; Previous', 'uw_wp_theme' ),
						'next_text'          => __( 'Next &rsaquo;', 'uw_wp_theme' ),
						'screen_reader_text' => __( 'Search Results Navigation', 'uw_wp_theme' ),
						'aria_label'         => __( 'Search Results', 'uw_wp_theme' ),
					)
				);
			}

		} else {

			get_template_part( 'template-parts/content', 'none' );
		}
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
