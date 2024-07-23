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
				'id'     => '', // optional ID.
			),
			$atts
		);

		// get the button ID, if there is one.
		$btn_id = ! empty( $atts['id'] ) ? 'id="' . esc_attr( $atts['id'] ) . '"' : '';

		$style_list = ['check', 'flag', 'minus', 'person', 
		'plus', 'camera', 'mail', 'search',
		'key', 'clipboard', 'bookmark', 'ticket', 
		'heart', 'watch', 'letter', 'marker',
		'social', 'close', 'calendat', 'pencil',
		'computer', 'page', 'view', 'eating', 
		'book', 'stop', 'compass', 'home',
		'play', 'picture', 'address-book', 'map',
		'music', 'settings', 'tools', 'globe',
		'briefcase', 'pause', 'trash', 'right-arrow-full',
		'list', 'page2', 'right-arrow', 'podium',
		'directions', 'capitol', 'map-marker', 'passport',
		'administration', 'plane', 'handshake', 'suitcase',
		'globe2', 'umbrella', 'ribbon', 'money',
		'checkmark', 'external', 'simple-arrow', 'check2',
		'people', 'clipboard-check'];

		if ( isset( $atts['style'] ) ) {
			if ( in_array( strtolower( $atts['style'] ), $style_list ) ) {
				$style = $atts['style'] . ' arrow icon-link';
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

		<a href="<?php echo esc_attr( $atts['target'] ); ?>" <?php echo $btn_id; ?> class="btn <?php echo esc_attr( $size ); ?> <?php echo esc_attr( $style ); ?><?php echo esc_attr( $color ); ?>"><span><?php
		$output = ob_get_clean();

		if ( $content ) {
			$output .= $content;
		} else {
			$output .= 'Please add button text.';
		}

		if ( 'arrow' === strtolower( $atts['style'] ) || 'square-outline' === strtolower( $atts['style'] ) ) {
			$output .= '</span><span class="arrow-box"><span class="arrow"></span></span></a>';
		} elseif ( in_array( strtolower( $atts['style'] ), $style_list ) ){
			$output .= '</span><span class="arrow-box"><span class="icon ic-';
			$output .= strtolower( $atts['style'] );
			$output .= '"></span></span></a>';
		} else {
			$output .= '</span></span></a>';
		}

		return $output;
	}
}
