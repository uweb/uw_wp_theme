<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
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
		<main id="primary" class="site-main uw-body-copy col-md-<?php echo ( ( ! isset( $sidebar[0] ) || 'on' !== $sidebar[0] ) ? '12' : '8' ); ?>">

		<?php

		if ( have_posts() ) :

			/* Display the appropriate header when required. */
			uw_wp_theme_index_header();

			/* Start the Loop. */
			while ( have_posts() ) : the_post();

            /*
             * Include the post format-specific template for the content. If you want to
             * use this in a child theme, then include a file called called content-___.php
             * (where ___ is the post format) and that will be used instead.
             */
            get_template_part( 'template-parts/content', 'attachment' );

          endwhile;

		endif;
        ?>

		</main><!-- #primary -->
		<?php
		if ( isset( $sidebar[0] ) ) {
			if ( null !== $sidebar[0] ) {
				get_sidebar();
			}
		}
		?>
	</div><!-- .row -->

</div><!-- .container -->

<?php get_footer(); ?>
