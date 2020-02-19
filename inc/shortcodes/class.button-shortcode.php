<?php

/**
 * UW Button Shortcode.
 * allows for styled buttons to be added to content
 *
 * structure: [uw_button style="arrow" size="large" color="purple" target="#"](button copy)[/uw_button]
 */

class UW_Button
{
	function __construct()
	{
		add_shortcode( 'uw_button', array( $this, 'button_handler' ) );
	}

	function button_handler( $atts, $content = null )
	{
		// Attributes.
		$atts = shortcode_atts(
			array(
				'style'  => '', // type of button.
				'size'   => '', // button size (large or small).
				'color'  => '', // button color.
				'target' => '', // where the button links to.
			),
			$atts
		);

		$style = isset( $atts['style'] ) ? $atts['style'] : 'square-outline';
		$size = 'btn-lg';
		if ( isset( $atts['size'] ) ) {
			$size = $atts['size'] === 'small' && strpos( $style, 'square-outline' ) === false ? 'btn-sm' : 'btn-lg';
		}
		$color = isset( $atts['color'] ) && strpos( $style, 'square-outline' ) === false ? ' ' . $atts['color'] : '';

		ob_start();
		?>

		<a href="<?php echo esc_attr( $atts['target'] ); ?>" class="btn <?php echo esc_attr( $size ); ?> <?php echo esc_attr( $style ); ?><?php echo esc_attr( $color ); ?>"><span><?php
		$output = ob_get_clean();

		if ( $content ) {
			$output .= $content;
		} else {
			$output .= 'Please add button text.';
		}

		$output .= strpos( $atts['style'], 'arrow' ) !== false || strpos( $atts['style'], 'square-outline' ) !== false ? '</span><span class="arrow-box"><span class="arrow"></span></span></a>' : '</span></span></a>';

		return $output;
	}
}
