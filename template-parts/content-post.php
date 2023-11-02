<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package uw_wp_theme
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		?>
		<div class="entry-meta">
			<div class="categories-tags">
				<?php
				if ( 'post' === get_post_type() && get_option( 'show_categories_on_posts' ) ) {
					uw_wp_theme_post_categories();
				}
				if ( 'post' === get_post_type() && get_option( 'show_tags_on_posts' ) ) {
					uw_wp_theme_post_tags();
				}
				?>
			</div>

			<?php
			if ( 'post' === get_post_type() && get_option( 'show_byline_on_posts' ) ) :
				?>

					<?php
					if ( get_option( 'show_author_on_posts' ) ) {
						uw_wp_theme_posted_by();
					}
					if ( get_option( 'show_date_on_posts' ) ) {
						uw_wp_theme_posted_on();
					}
					?>
				<?php
			endif;
			?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<?php
	// if the post has a featured image, display the featured image.
	if ( has_post_thumbnail() &&  get_option( 'show_feature_photo' ) ) {
		echo '<div class="featured-image">';
		the_post_thumbnail();
		echo '</div>';
	}
	?>

	<div class="entry-content">
		<?php
		if ( has_excerpt() && ! is_single() ) {
			the_excerpt();
		} elseif ( get_option( 'show_auto_excerpts' ) && ! is_single() ) {
			the_excerpt();
		} else {
			the_content(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'uw_wp_theme' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
		}

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'uw_wp_theme' ),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->

	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
			<?php
				uw_wp_theme_edit_post_link();
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->

<?php
// if single post and hide prev/next thumbnails is NOT turned on, use prev/next with thumbnail images.
if ( is_singular() && ! get_option( 'hide_blog_nav_thumbs' ) ) :
	$next_post = get_next_post();
	$prev_post = get_previous_post();

	if ( $prev_post && get_the_post_thumbnail( $prev_post ) ) {
		$prev_post_thumb = '<div class="prev-post-thumbnail">' . get_the_post_thumbnail( $prev_post, [ 100, 100 ] ) . '</div>';
	} else {
		$prev_post_thumb = '<div class="prev-post-thumbnail default-thumb"></div>';
	}

	if ( $next_post && get_the_post_thumbnail( $next_post ) ) {
		$next_post_thumb = '<div class="next-post-thumbnail">' . get_the_post_thumbnail( $next_post, [ 100, 100 ] ) . '</div>';
	} else {
		$next_post_thumb = '<div class="next-post-thumbnail default-thumb"></div>';
	}

	the_post_navigation(
		array(
			'prev_text' => $prev_post_thumb . '<div class="prev-post-text-link"><div class="post-navigation-sub"><span class="prev-arrow"></span><span>' . esc_html__( 'Previous article', 'uw_wp_theme' ) . '</span></div><span class="post-navigation-title">%title</span></div>',
			'next_text' => '<div class="next-post-text-link"><div class="post-navigation-sub"><span>' . esc_html__( 'Next article', 'uw_wp_theme' ) . '</span><span class="next-arrow"></span></div><span class="post-navigation-title">%title</span></div>' . $next_post_thumb,
		)
	);
endif;

// if single post and hide prev/next thumbnails IS turned on, use prev/next without thumbnail images.
if ( is_singular() && get_option( 'hide_blog_nav_thumbs' ) ) :
	the_post_navigation(
		array(
			'prev_text' => '<div class="prev-post-text-link"><div class="post-navigation-sub"><span class="prev-arrow"></span><span>' . esc_html__( 'Previous article', 'uw_wp_theme' ) . '</span></div><span class="post-navigation-title">%title</span></div>',
			'next_text' => '<div class="next-post-text-link"><div class="post-navigation-sub"><span>' . esc_html__( 'Next article', 'uw_wp_theme' ) . '</span><span class="next-arrow"></span></div><span class="post-navigation-title">%title</span></div>',
		)
	);
endif;
