<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package uw_wp_theme
 */

get_header();

?>
	<div class="uw-hero-image"></div>
	<main id="primary" class="site-main container">
		<section class="error-404 not-found">
			<div class="page-content col-md-12">
				<div class="woof"></div>
				<div class="container">
					<div class="row">
						<div class="col">
							<h3>Not what you were expecting?</h3>
							<p>Dubs tells us this page might not be what you had in mind when you set out on your journey through the UW Web. Don&#146;t worry, you&#146;re not in the Dawg House! Here are some of Dubs&#146; favorite pages if you feel like exploring: </p>
						</div>

						<div class="col">
							<ul>
								<li><a href="//uw.edu/?utm_source=error&utm_medium=click&utm_campaign=links&utm_term=uwhomepage">UW home page</a></li>
								<li><a href="//www.washington.edu/discover/">Discover the UW</a></li>
								<li><a href="//uw.edu/maps/?utm_source=error&utm_medium=click&utm_campaign=links&utm_term=maps">Maps</a></li>
								<li><a href="https://www.washington.edu/news/">UW Today</a></li>
								<li><a href="https://gohuskies.com/">Husky Sports</a></li>
								<li><a href="//www.washington.edu/discover/visit/">Visitor and Information Center</a></li>
							</ul>
						</div>
					</div><!-- .row -->
				</div><!-- .container -->
			</div><!-- .page-content -->
		</section><!-- .error-404 -->

	</main><!-- #primary -->

<?php
get_footer();
