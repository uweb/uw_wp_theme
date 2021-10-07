<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package uw_wp_theme
 */

get_header();

// get the image header.
get_template_part( 'template-parts/header', 'image' );

?>
<div class="container-fluid ">
<?php echo uw_breadcrumbs(); ?>

</div>
<div class="container-fluid uw-body">
	<div class="row">

		<main id="primary" class="site-main uw-body-copy col-md-12">
		<article id="404" class="hentry">
				<div class="woof" style="background: url( <?php echo get_template_directory_uri() . '/assets/images/404.jpg' ?>) center center no-repeat; height: 400px;"></div>

				<div class="row">

					<div class="col-md-10 align-self-center offset-md-1">
						<h1>Not what you were expecting?</h1>
						<p>Dubs tells us this page might not be what you had in mind when you set out on your journey through the UW Web. Don&#146;t worry, you&#146;re not in the Dawg House! Here are some of Dubs&#146; favorite pages if you feel like exploring: </p>
						
						<ul style="column-count: 2">
							<li><a href="//uw.edu/?utm_source=error&utm_medium=click&utm_campaign=links&utm_term=uwhomepage">UW home page</a></li>
							<li><a href="//uw.edu/contact/?utm_source=error&utm_medium=click&utm_campaign=links&utm_term=contactus">Contact us</a></li>
							<li><a href="//uw.edu/about/?utm_source=error&utm_medium=click&utm_campaign=links&utm_term=abouttheuw">About the UW</a></li>
							<li><a href="//uw.edu/admissions/?utm_source=error&utm_medium=click&utm_campaign=links&utm_term=applytotheuw">Apply to the UW</a></li>
							<li><a href="//uw.edu/visit/?utm_source=error&utm_medium=click&utm_campaign=links&utm_term=visittheuw">Visit the UW</a></li>
							<li><a href="//uw.edu/maps/?utm_source=error&utm_medium=click&utm_campaign=links&utm_term=maps">Maps</a></li>
							<li><a href="https://my.uw.edu/">MyUW</a></li>
							<li><a href="http://www.uwmedicine.org/">UW Medicine</a></li>
							<li><a href="https://www.uwb.edu/">UW Bothell</a></li>
							<li><a href="https://www.tacoma.uw.edu">UW Tacoma</a></li>
							<li><a href="https://gohuskies.com/">Athletics</a></li>
							<li><a href="//uw.edu/news/?utm_source=error&utm_medium=click&utm_campaign=links&utm_term=uwnews">UW News</a></li>
							<li><a href="http://artsuw.org/">ArtsUW</a></li>
						</ul>

						<p>Or, search the UW web:</p>
						<?php get_search_form(); ?>
						
					</div>

					
				</div>
			</article> 
		</main><!-- #primary -->

	</div><!-- .row -->
</div><!-- .container -->

<?php
get_footer();
