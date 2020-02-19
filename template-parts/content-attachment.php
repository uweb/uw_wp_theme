<?php
/**
 * Template part for displaying attachment posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package uw_wp_theme
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<?php
		the_title( '<h1 class="entry-title">', '</h1>' );
		?>
		<div class="entry-meta">
			<?php
				uw_wp_theme_posted_on();
				uw_wp_theme_posted_by();
				uw_wp_theme_attachment_in( $post );
				uw_wp_theme_comments_link();
			?>
		</div><!-- .entry-meta -->

	</header><!-- .entry-header -->

	<div class="entry-content">

		<figure class="attachment-image">
			<?php echo wp_get_attachment_image( get_the_ID(), 'original' ); ?>
			<figcaption>
				<?php the_excerpt(); ?>
			</figcaption>
		</figure><!-- .attachment-image -->

		<?php
			remove_filter( 'the_content', 'prepend_attachment' );
			the_content();
		?>

	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php
			uw_wp_theme_edit_post_link();
		?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->

<?php


// If the attachment is attached to a post, try linking to other attachments on the same post.
if ( ! empty( $post->post_parent ) ) :
	uw_wp_theme_the_attachment_navigation();
endif;

// If comments are open or we have at least one comment, load up the comment template.
if ( comments_open() || get_comments_number() ) :
	comments_template();
endif;
