<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package uw_wp_theme
 */

get_header();

$sidebar = get_post_meta($post->ID, "sidebar");

// if this is the public lectures site.
if ( false !== strpos( $_SERVER['REQUEST_URI'], 'lectures' ) ) {
	require get_template_directory() . '/pluggable/lectures/header-image.php';
} else {
	get_template_part( 'template-parts/header', 'image' );
}

/*
* Include the component stylesheet for the content.
* This call runs only once on index and archive pages.
* At some point, override functionality should be built in similar to the template part below.
*/
wp_print_styles( array( 'uw_wp_theme-content', 'uw_wp_theme-bootstrap' ) ); // Note: If this was already done it will be skipped.

?>

<div class="container-fluid uw-body">
	<div class="row">

		<main id="primary" class="site-main uw-body-copy col-md-<?php echo ( ( ! isset( $sidebar[0] ) || 'on' !== $sidebar[0] ) ? '8' : '12' ); ?>" tabindex="-1" role="main">

			<header class="entry-header">
				<h1 class="search-title"><?php echo esc_attr( $wp_query->found_posts ); ?> <?php esc_html_e( 'Search results found for', 'uw_wp_theme' ); ?>: &ldquo;<?php the_search_query(); ?>&rdquo;</h1>
			</header>

			<?php
			if ( have_posts() ) :

				/* Start the Loop */
				while ( have_posts() ) :
					the_post();

					/*
					* Include the component stylesheet for the content.
					* This call runs only once on index and archive pages.
					* At some point, override functionality should be built in similar to the template part below.
					*/
					wp_print_styles( array( 'uw_wp_theme-content' ) ); // Note: If this was already done it will be skipped.

					/**
					 * Run the loop for the search to output the results.
					 * If you want to overload this in a child theme then include a file
					 * called content-search.php and that will be used instead.
					 */
					get_template_part( 'template-parts/content', 'search' );

				endwhile;

				the_posts_pagination(
					array(
						'mid_size'           => 2,
						'prev_text'          => __( 'Previous results', 'uw_wp_theme' ),
						'next_text'          => __( 'More results', 'uw_wp_theme' ),
						'screen_reader_text' => __( 'Search Results Navigation', 'uw_wp_theme' ),
						'aria_label'         => __( 'Search Results', 'uw_wp_theme' ),
					)
				);

			else :

				get_template_part( 'template-parts/content', 'none' );

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
