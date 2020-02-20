<?php

if ( is_front_page() || is_post_type_archive( 'uw_oplevents' ) ) {
	$header_image_class = 'opl-header1';
} elseif ( is_singular( 'uw_oplevents' ) ) {
	$header_image_class = 'opl-header2';
} elseif ( is_page( array( 67, 79 ) ) ) {
	// plan your visit and related podcasts.
	$header_image_class = 'opl-header3';
} else {
	// all the other pages.
	$header_image_class = 'opl-header4';
}

?>
<div class="uw-hero-image <?php echo esc_attr( $header_image_class ); ?>">
	<div class="container-fluid">
		<a href="<?php echo esc_attr( home_url( '/' ) ); ?>" title="<?php echo esc_attr( the_title() ); ?>"><div class="uw-site-title"><?php echo esc_attr( bloginfo() ); ?></div></a>
		<div class="udub-slant-divider gold"><span></span></div>
	</div>
</div>
