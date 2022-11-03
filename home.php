<?php
/**
 * The blog posts index template file
 *
 * By default, WordPress sets your site's home page to display your latest blog posts.
 * This page is called the blog posts index. You can also set your blog posts to display
 * on a separate static page. The template file home.php is used to render the blog posts
 * index, whether it is being used as the front page or on separate static page.
 * If home.php does not exist, WordPress will use index.php.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#home-page-display
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
		<main id="primary" class="site-main uw-body-copy col-md-<?php echo ( ( ! isset( $sidebar[0] ) || 'on' !== $sidebar[0] ) ? '8' : '12' ); ?>">

		<?php

		// this might be kind of secret squirrel because WP hides the editor once you set a page to be the posts page. If you have copy in the posts page, this allows it to display above the posts on the blog page. It will display on all pages, so the intro should make sense for that.
		if ( get_option( 'page_for_posts' ) ) {
			// get the posts page.
			$posts_page = get_option( 'page_for_posts' );

			// get the content from the post's page.
			$content = get_post( $posts_page )->post_content;

			// if there is content from the post's page, then display it. If not, nothing appears.
			if ( ( $content && ! is_paged() ) || ( $content && get_option( 'show_blog_intro_all' ) ) ) {
				$content_output  = '<div class="blog-intro">';
				$content_output .= $content;
				$content_output .= '</div>';
				echo wp_kses_post( $content_output );
			}
		}

		if ( ! is_singular() && is_paged() ) {
			echo wp_kses_post( '<div class="top-posts-nav-links">' );
			the_posts_pagination(
				array(
					'mid_size'           => 2,
					'prev_text'          => __( '&lsaquo; Previous', 'uw_wp_theme' ),
					'next_text'          => __( 'Next &rsaquo;', 'uw_wp_theme' ),
					'screen_reader_text' => __( 'Search Results Navigation', 'uw_wp_theme' ),
					'aria_label'         => __( 'Search Results', 'uw_wp_theme' ),
				)
			);
			echo wp_kses_post( '</div>' );
		}

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

			}

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
