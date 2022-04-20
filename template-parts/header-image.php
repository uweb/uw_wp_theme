<?php
$header_image = get_header_image() !== '' ? 'style="background-image:url(' . get_header_image() . ')"' : '';

$header_image = get_post_thumbnail_id( $post->ID ) ? 'style="background-image:url(' .wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) ) . ')"' : $header_image;
?>

<div class="uw-hero-image"<?php echo $header_image; ?>>
	<div class="container-fluid">
		<?php uw_site_title(); ?>

		<div class="udub-slant-divider gold"><span></span></div>
	</div>
</div>
