<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package uw_wp_theme
 */

?>

		<footer id="colophon" class="site-footer">
			<a href="http://www.washington.edu" class="footer-wordmark">University of Washington</a>

			<a href="http://www.washington.edu/boundless/"><h3 class="be-boundless">Be boundless</h3></a>

			<h4>Connect with us:</h4>
			<nav aria-label="social networking">
				<ul class="footer-social">
					<li><a class="facebook" href="http://www.facebook.com/UofWA">Facebook</a></li>
					<li><a class="twitter" href="http://twitter.com/UW">Twitter</a></li>
					<li><a class="instagram" href="http://instagram.com/uofwa">Instagram</a></li>
					<li><a class="youtube" href="http://www.youtube.com/user/uwhuskies">YouTube</a></li>
					<li><a class="linkedin" href="http://www.linkedin.com/company/university-of-washington">LinkedIn</a></li>
					<li><a class="pinterest" href="http://www.pinterest.com/uofwa/">Pinterest</a></li>
				</ul>
			</nav>

			<nav aria-label="footer navigation">
				<ul class="footer-links">
					<li><a href="http://www.uw.edu/accessibility">Accessibility</a></li>
					<li><a href="http://uw.edu/contact">Contact Us</a></li>
					<li><a href="http://www.washington.edu/jobs">Jobs</a></li>
					<li><a href="http://www.washington.edu/safety">Campus Safety</a></li>
					<li><a href="http://my.uw.edu/">My UW</a></li>
					<li><a href="http://www.washington.edu/rules/wac">Rules Docket</a></li>
					<li><a href="http://www.washington.edu/online/privacy/">Privacy</a></li>
					<li><a href="http://www.washington.edu/online/terms/">Terms</a></li>
				</ul>
			</nav>

			<div class="site-info">
				<p>&copy; <?php echo date( 'Y' ); ?> University of Washington  |  Seattle, WA</p>
			</div><!-- .site-info -->
		</footer><!-- #colophon -->
	</div><!-- #page-inner -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
