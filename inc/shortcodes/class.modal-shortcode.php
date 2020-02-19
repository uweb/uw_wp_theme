<?php

/**
 * UW Modal Shortcode.
 *
 * structure: [uw_modal id="arts" button="Arts"](modal content)[/uw_modal]
 */

 class UW_Modal
 {
	function __construct()
	{
		add_shortcode( 'uw_modal', array( $this, 'uw_modal_shortcode' ) );
	}

	function uw_modal_shortcode( $atts, $content = null )
	{
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
}
