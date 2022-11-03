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
			<a href="https://www.washington.edu/" class="footer-wordmark">University of Washington</a>
			<a href="https://www.washington.edu/boundless/"><div class="be-boundless">Be boundless</div></a>

			<div class="h4" id="social_preface">Connect with us:</div>
			<nav aria-labelledby="social_preface">
				<ul class="footer-social">
					<li><a class="facebook" href="https://www.facebook.com/UofWA">Facebook</a></li>
					<li><a class="twitter" href="https://twitter.com/UW">Twitter</a></li>
					<li><a class="instagram" href="https://instagram.com/uofwa">Instagram</a></li>
					<li><a class="youtube" href="https://www.youtube.com/user/uwhuskies">YouTube</a></li>
					<li><a class="linkedin" href="https://www.linkedin.com/company/university-of-washington">LinkedIn</a></li>
					<li><a class="pinterest" href="https://www.pinterest.com/uofwa/">Pinterest</a></li>
				</ul>
			</nav>

			<nav aria-label="footer navigation">
				<!--<ul class="footer-links"> -->
				<?php uw_wp_theme_footer_menu(); ?>

				<!-- </ul> -->
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
