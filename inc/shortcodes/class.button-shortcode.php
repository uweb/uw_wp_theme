<?php

/**
 * UW Button Shortcode.
 * allows for styled buttons to be added to content
 *
 * structure: [uw_button style="arrow" size="large" color="purple" target="#"](button copy)[/uw_button]
 */

class UW_Button {
	function __construct() {
		add_shortcode( 'uw_button', array( $this, 'button_handler' ) );
	}


	/**
	 * Enqueue button script.
	 *
	 * @return void
	 */
	function button_handler( $atts, $content = null ) {
		// Attributes.
		$atts = shortcode_atts(
			array(
				'style'  => '', // type of button. arrow (default), plus, play, primary, secondary.
				'size'   => '', // button size (large or small).
				'color'  => '', // button color.
				'target' => '', // where the button links to.
			),
			$atts
		);

		if ( isset( $atts['style'] ) ) {
			if ( 'plus' === strtolower( $atts['style'] ) ) {
				$style = $atts['style'] . ' arrow';
			} elseif ( 'play' === strtolower( $atts['style'] ) ) {
				$style = $atts['style'] . ' arrow';
			} elseif ( 'arrow' === strtolower( $atts['style'] ) ) {
				$style = 'arrow';
			} elseif ( 'square-outline' === strtolower( $atts['style'] ) ) {
				$style = 'square-outline';
			} else {
				$style = $atts['style'];
			}
		} else {
			$style = '';
		}

		$size = 'btn-lg';

		if ( isset( $atts['size'] ) ) {
			$size = $atts['size'] === 'small' && strpos( $style, 'square-outline' ) === false ? 'btn-sm' : 'btn-lg';
		}

		if ( isset( $atts['color'] ) ) {
			if ( false === strpos( $style, 'square-outline' ) ) {
				$color = ' ' . $atts['color'];
			} else {
				$color = ' ' . $atts['color'];
			}
		} else {
			$color = '';
		}

		ob_start();
		?>

		<a href="<?php echo esc_attr( $atts['target'] ); ?>" class="btn <?php echo esc_attr( $size ); ?> <?php echo esc_attr( $style ); ?><?php echo esc_attr( $color ); ?>"><span><?php
		$output = ob_get_clean();

		if ( $content ) {
			$output .= $content;
		} else {
			$output .= 'Please add button text.';
		}

		if ( 'arrow' === strtolower( $atts['style'] ) || 'square-outline' === strtolower( $atts['style'] ) ) {
			$output .= '</span><span class="arrow-box"><span class="arrow"></span></span></a>';
		} elseif ( 'plus' === strtolower( $atts['style'] ) ) {
			$output .= '</span><span class="arrow-box"><span class="ic-plus"></span></span></a>';
		} elseif ( 'play' === strtolower( $atts['style'] ) ) {
			$output .= '</span><span class="arrow-box"><span class="ic-play"></span></span></a>';
		} else {
			$output .= '</span></span></a>';
		}

		return $output;
	}
}
