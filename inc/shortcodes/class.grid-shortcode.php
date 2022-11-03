<?php

/**
 * UW Grid shortcode
 * For using the Links list found in the dashboard
 *
 * Example:
 * [row]
 *   [col class='col-md-12']Text[/col]
 * [/row]
 */
class UW_Grid {
	function __construct() {
		add_shortcode( 'row', array( $this, 'bs_row' ) );
		add_shortcode( 'col', array( $this, 'bs_span' ) );
	}

	function bs_row( $atts, $content = null ) {
		// Attributes.
		$atts    = shortcode_atts(
			array(
				'class'  => 'row',
				'height' => '', // equal.
				'width'  => '', // full-width.
				'background' => '', // Sets background color. Options: gold, purple, gray (grey also works), none. Also sets <h*> and <p> color. Default = none.
				'image' => '', // url of background image. Use background attribute to control text color.
			),
			$atts
		);
		$content = preg_replace( '/<br class="nc".\/>/', '', $content );
		$class   = isset( $atts['class'] ) ? 'grid ' . $atts['class'] : ' row';
		$height  = isset( $atts['height'] ) ? $atts['height'] : '';
		$width   = isset( $atts['width'] ) ? $atts['width'] : '';
		$image   = isset( $atts['image'] ) ? $atts['image'] : '';
		$background   = isset( $atts['background'] ) ? $atts['background'] : '';
		if ( ! empty( $atts['image'] ) ) {
			$bgimage = ' style="background-image: url(' . $image . '); padding:6rem;background-size:cover; background-repeat:no-repeat;"';
		} else {
			$bgimage = '';
		}

		$result  = '<div class="' . $class . ' ' . $height . '' . $width . ' ' . $background . ' " ' . $bgimage . '>';
		$result .= do_shortcode( $content );
		$result .= '</div>';
		return $result;
	}

	function bs_span( $atts, $content = null ) {
		$atts = shortcode_atts(
			array(
				'class' => 'col-sm-1',
			),
			$atts
		);
		$class   = isset( $atts['class'] ) ? $atts['class'] : 'row';
		$result  = '<div class="' . $class . '">';
		$result .= do_shortcode( $content );
		$result .= '</div>';
		return $result;
	}
}
