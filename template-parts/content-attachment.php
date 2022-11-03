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
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php
				uw_wp_theme_posted_on();
				uw_wp_theme_posted_by();
			?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">

		<figure class="attachment-image text-center">
			<?php echo wp_get_attachment_image( $post->ID, 'full', false, $attr=array( 'class' =>'attachment-full center-block' ) ); ?>
			<figcaption class="p-4">
				<?php echo get_the_excerpt(); ?>
			</figcaption>
		</figure><!-- .attachment-image -->

		<div class="text-center">
			<a href="<?php echo wp_get_attachment_url( get_the_ID() ); ?>" title="<?php the_title(); ?>" target="_blank" download="<?php the_title() ?>" class="btn btn-lg plus arrow purple"><span>Download</span><span class="arrow-box"><span class="ic-plus"></span></span></a>
		</div>

	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->

