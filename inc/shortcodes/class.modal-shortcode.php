<?php

/**
 * UW Modal Shortcode.
 *
 * Structure:
 * [uw_modal id="arts" button="Arts"](modal content)[/uw_modal]
 */
class UW_Modal {

	/**
	 * Modal constructor.
	 */
	public function __construct() {
		add_shortcode( 'uw_modal', array( $this, 'uw_modal_shortcode' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'uw_wp_theme_enqueue_modal_script' ) );
	}

	/**
	 * Enqueue modal script.
	 *
	 * @return void
	 */
	public function uw_wp_theme_enqueue_modal_script() {
		$template_directory = get_bloginfo( 'template_directory' );
		$theme_version = wp_get_theme( get_template( ) )->get( 'Version' );
		
		wp_register_script( 'uw_wp_theme-modal-script', $template_directory . '/js/shortcodes/modal.js', array( 'jquery', 'uw_wp_theme-bootstrap' ), $theme_version, true );
	}

	/**
	 * UW Modal Shortcode.
	 *
	 * @param [string] $atts    Attributes for shortcode.
	 * @param [string] $content Content for shortcode.
	 * @return void
	 */
	public function uw_modal_shortcode( $atts, $content = null ) {

		// only enqueue script when shortcode is present!
		wp_enqueue_script( 'uw_wp_theme-modal-script' );

		// Attributes.
		$modal_atts = shortcode_atts(
			array(
				'title'    => '', // title of modal.
				'id'       => '', // id to allow for multiple modals on a page.
				'button'   => '', // button/trigger text.
				'width'    => '', // width options: narrow, wide, default (medium).
				'color'    => '', // button color options: gold, purple.
				'scroll'   => '', // set to true if the modal should be scrollable.
				'position' => '', // set to center if vertically centered.
			),
			$atts
		);

		// get the URL of the current page.
		if ( ! empty( $_SERVER['REQUEST_URI'] ) ) {
			$current_url = esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) );
		} else {
			$current_url;
		}

		// set a default ID if none set. We'll assign a unique number with the JS.
		if ( empty( $modal_atts['id'] ) ) {
			$modal_id = 'uw-modal';
		} else {
			$modal_id = $modal_atts['id'];
		}

		// set button text.
		if ( empty( $modal_atts['button'] ) ) {
			$button_text = 'Set button text';
		} else {
			$button_text = $modal_atts['button'];
		}

		// set button color.
		if ( empty( $modal_atts['button'] ) ) {
			$button_color = 'primary';
		} else {
			if ( 'gold' === $modal_atts['color'] ) {
				$button_color = 'secondary';
			} else {
				$button_color = 'primary';
			}
		}

		// set classes for width options.
		if ( ! empty( $modal_atts['width'] ) ) {
			if ( 'wide' === $modal_atts['width'] ) {
				$width_class = 'w-90';
			} elseif ( 'narrow' === $modal_atts['width'] ) {
				$width_class = '';
			} else {
				$width_class = 'w-60'; // default is narrow.
			}
		} else {
			$width_class = 'w-60'; // default is narrow.
		}

		// start the shortcode.
		ob_start();
		?>
		<button type="button" class="btn btn-lg btn-modal <?php echo esc_attr( $button_color ); ?> <?php echo esc_attr( $modal_id ); ?>" data-toggle="modal" data-target="#<?php echo esc_attr( $modal_id ); ?>"><span class="btn-label"><?php echo esc_attr( $button_text ); ?></span></button>
		<div id="<?php echo esc_attr( $modal_id ); ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="<?php echo esc_attr( $modal_id ); ?>Title" aria-hidden="true">
			<div class="modal-dialog <?php echo esc_attr( $width_class ); ?> <?php echo 'true' === $modal_atts['scroll'] ? esc_attr( 'modal-dialog-scrollable' ) : ''; ?> <?php echo 'center' === $modal_atts['position'] ? esc_attr( 'modal-dialog-centered' ) : ''; ?>" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="<?php echo esc_attr( $modal_id ); ?>Title"><?php echo esc_attr( $modal_atts['title'] ); ?></h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
		<?php
		$output = ob_get_clean();

		if ( $content ) {
			// allow other shortcodes inside the modal shortcode.
			$output .= do_shortcode( $content );
		} else {
			$output .= '<strong>Please add content to this modal.</strong>';
		}

		$output .= '</div></div></div></div>';

		return $output;
	}
}
