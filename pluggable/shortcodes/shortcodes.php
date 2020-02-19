<?php
/**
 * Shortcodes for UW Social theme.
 *
 * @package uw_golden
 */

/**
 * Main function. Runs everything.
 */
function uw_golden_shortcodes() {

	// If this is the admin page, do nothing.
	if ( is_admin() ) {
		return;
	}

	/**
	 * UW Modal Shortcode.
	 *
	 * @param array $atts     Attributes for the modal.
	 * @param array $content  Main body content for the modal.
	 */
	function uw_modal_shortcode( $atts, $content = null ) {

		// Attributes.
		$atts = shortcode_atts(
			array(
				'title'  => '', // title of modal.
				'id'     => '', // id to allow for multiple modals on a page.
				'button' => '', // button/trigger text.
			),
			$atts
		);

		ob_start(); ?>
		<button type="button" class="btn btn-lg btn-social-cats <?php echo esc_attr( $atts['id'] ); ?>" data-toggle="modal" data-target="#<?php echo esc_attr( $atts['id'] ); ?>"><span class="btn-social-cats-img"></span><span class="btn-social-cats-label"><?php echo esc_attr( $atts['button'] ); ?></span></button>
		<div id="<?php echo esc_attr( $atts['id'] ); ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="<?php echo esc_attr( $atts['id'] ); ?>Title" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div id="social-overlay"></div>
					<div class="modal-header" id="cover-expose">
						<h5 class="modal-title screen-reader-text" id="<?php echo esc_attr( $atts['id'] ); ?>Title"><?php echo esc_attr( $atts['button'] ); ?> Profile</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
		<?php
		$output = ob_get_clean();

		if ( $content ) {
			$output .= $content;
		} else {
			$output .= 'Please add content to this modal.';
		}

		$output .= '</div></div></div></div>';

		return $output;
	}
	add_shortcode( 'uw_modal', 'uw_modal_shortcode' );

	/**
	 * UW Button Shortcode.
	 *
	 * @param array $atts     Attributes for the button.
	 * @param array $content  Text for the button.
	 */
	function uw_buttons_shortcode( $atts, $content = null ) {

		// Attributes.
		$atts = shortcode_atts(
			array(
				'style'  => '', // type of button.
				'target' => '', // where the button links to.
			),
			$atts
		);

		ob_start();
		?>

		<a href="<?php echo esc_attr( $atts['target'] ); ?>" class="btn btn-lg <?php echo esc_attr( $atts['style'] ); ?>"><span>
		<?php
		$output = ob_get_clean();

		if ( $content ) {
			$output .= $content;
		} else {
			$output .= 'Please add button text.';
		}

		$output .= '</span><span class="arrow-box"><span class="arrow"></span></span></a>';

		return $output;
	}
	add_shortcode( 'uw_button', 'uw_buttons_shortcode' );

	// call the enqueue scripts for shortcodes.
	add_action( 'wp_enqueue_scripts', 'uw_golden_enqueue_shortcodes' );

}
add_action( 'wp', 'uw_golden_shortcodes' );

/**
 * Enqueue and defer shortcode scripts.
 */
function uw_golden_enqueue_shortcodes() {
	if ( is_multisite() ) {
		wp_enqueue_script( 'uw_golden-shortcode-script', network_site_url( '/wp-content/themes/uw_golden/pluggable/shortcodes/shortcodes.js' ), array( 'uw_golden-jquery', 'uw_golden-popper' ), '20190625', true );
		wp_enqueue_style( 'uw_golden-shortcode-style', network_site_url( '/wp-content/themes/uw_golden/pluggable/shortcodes/shortcodes.css' ), array(), '20190624' );
	} else {
		wp_enqueue_script( 'uw_golden-shortcode-script', get_theme_file_uri( '/pluggable/shortcodes/shortcodes.js' ), array( 'uw_golden-jquery', 'uw_golden-popper' ), '20190625', true );
		wp_enqueue_style( 'uw_golden-shortcode-style', get_theme_file_uri( '/pluggable/shortcodes/shortcodes.css' ), array(), '20190624' );
	}
}
