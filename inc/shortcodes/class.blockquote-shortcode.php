<?php
/**
 * Shortcode for blockquote module
 *
 * Template:
 * [blockquote style="" align="" name="Dubs Husky" title="Official Live Mascot"] blockquote text [/blockquote]
 */
class UW_Blockquote {
	const PRIORITY = 12;

	/**
	 * Blockquote constructor.
	 */
	public function __construct() {
		remove_filter( 'the_content', 'wpautop' );
		add_filter( 'the_content', 'wpautop', self::PRIORITY );

		add_shortcode( 'blockquote', array( $this, 'blockquote_handler' ) );
	}

	/**
	 * Blockquote handler.
	 *
	 * @param string $atts attributes from shortcode: name, style.
	 * @param string $content content from shortcode.
	 * @return string
	 */
	public function blockquote_handler( $atts, $content ) {

		$blockquote_atts = shortcode_atts(
			array(
				'style' => '', // simple or brand. Default is brand.
				'align' => '', // left, right, center. Default is left.
				'name'  => '', // source attribution name.
				'title' => '', // source's title or other information.
				'id'    => '', // custom id.
			),
			$atts
		);

		// if there's no content, display a message with instructions on how to add the required structure.
		if ( empty( $content ) ) {
			return 'No content inside the blockquote module. Make sure your close your blockquote. Required stucture: [blockquote style="" align="" name="" title=""] blockquote text [/blockquote]';
		}

		// set the ID if provided, otherwise set to empty string.
		if ( ! empty( $blockquote_atts['id'] ) ) {
			$blockquote_id = 'id="' . esc_attr( $blockquote_atts['id'] ) . '" ';
		} else {
			$blockquote_id = '';
		}

		// get the style flag.
		// check for if style is not set or set to brand. Default.
		if ( ! isset( $blockquote_atts['style'] ) || 'brand' === $blockquote_atts['style'] ) {
			$blockquote_style_class = '';
			// check for style flag set to simple.
		} elseif ( 'simple' === $blockquote_atts['style'] ) {
			$blockquote_style_class = 'quote-simple';
		} else {
			$blockquote_style_class = '';
		}

		// get the align flag.
		// check for if align is not set or left. Default.
		if ( ! isset( $blockquote_atts['align'] ) || 'left' === $blockquote_atts['align'] ) {
			$blockquote_align = 'text-left';
			// check for align set to center.
		} elseif ( 'center' === $blockquote_atts['align'] ) {
			// center aligned.
			$blockquote_align = 'text-center';
			// check for align set to right.
		} elseif ( 'right' === $blockquote_atts['align'] ) {
			// right aligned.
			$blockquote_align = 'text-right';
		} else {
			// no match, don't do anything.
			$blockquote_align = '';
		}

		// start shortcode output.
		ob_start();
		?>

		<figure id="quote-block" class="quote-block <?php echo esc_attr( $blockquote_style_class ); ?>">
			<div <?php echo $blockquote_id; ?>class="mb-0 <?php echo esc_attr( $blockquote_align ); ?>">
				<blockquote><?php echo wp_kses_post( $content ); ?></blockquote>
				<?php if ( $blockquote_atts['name'] ) : ?>
					<figcaption><?php echo esc_attr( $blockquote_atts['name'] ); ?><span class="uw-slant-inline"></span><span class="quote-source-title"><?php echo esc_attr( $blockquote_atts['title'] ); ?></span></figcaption>
				<?php endif; ?>
			</div>
		</figure>
		<?php

		// complete shortcode output and return it.
		return ob_get_clean();
	}
}
