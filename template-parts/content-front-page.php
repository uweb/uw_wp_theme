<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package uw_wp_theme
 */

?>

<div id="social-wrapper"></div>
<div id="color"></div>
<div id="social-top">
	<h1>Get social, Huskies!</h1>
		<?php
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
		?>
</div>
<div id="content" class="row">
	<div id="twitter" class="feed col-md-4">
		<h3><a href="https://twitter.com/UW">@UW Tweets</a></h3>
		<a class="fade hidden" href="https://twitter.com/UW">See More</a>
	</div>

	<div id="facebook" class="feed col-md-4">
		<h3><a href="https://www.facebook.com/UofWA">UofWA Facebook Posts</a></h3>
		<a class="fade hidden" href="https://www.facebook.com/UofWA">See More</a>
	</div>

	<div id="instagram" class='feed col-md-4'>
		<h3><a href="https://instagram.com/uofwa">UofWA Instagrams</a></h3>
		<a class="fade hidden" href="https://instagram.com/uofwa">See More</a>
	</div>
</div>

<script type="text/template" id="large-background-tile">
	<div class="background-tile" style="height:<%= image.low_resolution.height %>px; width:<%= image.low_resolution.width %>px;background-image:url('<%= image.low_resolution.url %>');display:inline-block; float:left;" data-img=<%= image.number %>></div>
</script>
<script type="text/template" id="small-background-tiles">
	<div class="block">
		<% for (var i = 0; i < 4; i++) { %>
			<div class="background-tile" style="height:<%= image[i].image.low_resolution.height / 2 %>px; width:<%= image[i].image.low_resolution.width / 2 %>px;background-image:url('<%= image[i].image.low_resolution.url %>');background-size:cover;display:inline-block; float:left;" data-img=<%= image[i].number %>></div>
		<% } %>
	</div>
</script>
