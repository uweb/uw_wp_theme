<?php
/**
 * Template part for displaying PDF attachment pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package uw_wp_theme
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>

		<?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php
				uw_wp_theme_posted_on();
				uw_wp_theme_posted_by();
			?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-summary">
		<a href="<?php echo wp_get_attachment_url( get_the_ID() ); ?>" title="<?php the_title(); ?>" target="_blank" download="<?php the_title() ?>" class="btn btn-lg plus arrow purple"><span>Download <?php echo( is_pdf() ? 'PDF' : '' ); ?></span><span class="arrow-box"><span class="ic-plus"></span></span></a> <br /><br />
		<?php the_content(); ?>
	</div><!-- .entry-summary -->


	<iframe class="uw-pdf-view" style="<?php echo( is_pdf() ? 'width:100%; height:900px;' : 'width:0px; height:0px;' ); ?>" src="<?php echo wp_get_attachment_url( get_the_ID() ); ?>?<?php echo time() ?>"></iframe>

</article><!-- #post-<?php the_ID(); ?> -->
