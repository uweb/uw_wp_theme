<?php
$header_image = get_header_image() !== '' ? 'style="background-image:url(' . get_header_image() . ')"' : '';
?>

<div class="uw-hero-image"<?php echo $header_image; ?>>
	<div class="container-fluid">
		<?php uw_site_title(); ?>
		
		<div class="udub-slant-divider gold"><span></span></div>
	</div>
</div>
