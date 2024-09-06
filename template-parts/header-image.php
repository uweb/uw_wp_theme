<?php
// set the header image for the blog if it's set up and we're on those pages.
if ( get_option( 'page_for_posts', true ) && ( is_home() || is_single() || is_archive() || is_category() || is_tag() ) ) {
	$posts_page = get_option( 'page_for_posts' );

	// if there is a featured image set for the posts page, we'll use that for all blog related pages and individual posts.
	if ( has_post_thumbnail( $posts_page ) ) {
		$blog_header  = get_the_post_thumbnail_url( $posts_page );
		$header_image = 'style="background-image:url(' . $blog_header . ')"';
	} else {
		// if the featured image is not set on the blog page, we just use the default.
		$header_image = get_header_image() !== '' ? 'style="background-image:url(' . get_header_image() . ')"' : '';
	}
} else {
	// otherwise, set the header image from the featured image for the page or the header image.
	$header_image = get_header_image() !== '' ? 'style="background-image:url(' . get_header_image() . ')"' : '';
}
?>

<div class="uw-hero-image" <?php echo $header_image; ?> role="region" aria-label="site title and banner">
	<div class="container-fluid">
		<?php uw_site_title(); ?>

		<div class="udub-slant-divider gold"><span></span></div>
	</div>
</div>
