<?php

/**
 * UW 2014 Button Shortcode.
 * allows for styled buttons to be added to content
 *
 *  structure: [button color='gold' type='type' url='link url' small='true']Button Text[/button]
 */

 class UW_2014_Button
 {
	private $types = array( 'plus', 'go', 'external', 'play' );

	 function __construct()
	 {
		//remove_shortcode('button');
        add_shortcode( 'button', array( $this, 'uw_2014_button_handler' ) );
	 }

	 function uw_2014_button_handler( $atts, $content )
	 {
		$attributes = (object) $atts;

		$color = 'gold';
		if ( isset( $atts['color'] ) ) {
			$color = $atts['color'] === 'gray' ? 'purple' : $atts['color'];
		}
		$type = 'arrow';
		if ( isset( $atts['type'] ) ) {
			$type = in_array( $atts['type'], $this->types ) ? 'arrow' : $atts['type'];
		}
		$size = 'btn-lg';
		if ( isset( $atts['small'] ) ) {
			$size = $atts['small'] === 'small' || $atts['small'] === 'true' ? 'btn-sm' : 'btn-lg';
		}
		$url = '#';
		if ( isset( $attributes->url ) ) {
			$url = $attributes->url;
		}

		ob_start();
		?>

		<a href="<?php echo esc_attr( $url ); ?>" class="btn <?php echo esc_attr( $size ); ?> <?php echo esc_attr( $type ); ?> <?php echo esc_attr( $color ); ?>"><span><?php
		$output = ob_get_clean();

		if ( $content ) {
			$output .= $content;
		} else {
			$output .= 'Please add button text.';
		}

		$output .= strpos( $type, 'arrow' ) !== false || strpos( $type, 'square-outline' ) !== false ? '</span><span class="arrow-box"><span class="arrow"></span></span></a>' : '</span></a>';

		return $output;
	}
}
