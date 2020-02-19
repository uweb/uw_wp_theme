<?php

$header_image = get_header_image() !== '' ? 'style="background-image:url("' . set_url_scheme( get_header_image() ) . '")"' : '';


?>
<div class="uw-hero-image"<?php echo $header_image; ?>>
	<div class="container">
		<a href="<?php echo esc_attr( home_url( '/' ) ); ?>" title="<?php echo esc_attr( the_title() ); ?>"><div class="uw-site-title"><?php echo esc_attr( bloginfo() ); ?></div></a>
		<div class="udub-slant-divider gold"><span></span></div>
	</div>
</div>
