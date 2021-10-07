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
		add_action( 'wp_enqueue_scripts', array( $this, 'uw_wp_theme_enqueue_button_script' ) );
	}


	/**
	 * Enqueue button script.
	 *
	 * @return void
	 */
	public function uw_wp_theme_enqueue_button_script() {
		if ( is_multisite() ) {
			wp_register_script( 'uw_wp_theme-button-script', network_site_url( '/wp-content/themes/uw_wp_theme/js/shortcodes/button.js' ), array( 'jquery', 'uw_wp_theme-bootstrap' ), '20210921', true );
		} else {
			wp_register_script( 'uw_wp_theme-button-script', get_theme_file_uri( '/js/shortcodes/button.js' ), array( 'jquery', 'uw_wp_theme-bootstrap' ), '20210921', true );
		}
	}
	function button_handler( $atts, $content = null )
	{
		// only enqueue script when shortcode is present!
		wp_enqueue_script( 'uw_wp_theme-button-script' );

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
