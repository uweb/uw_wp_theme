<?php

/**
 * Call to Action (CTA) Shortcode.
 * allows for styled calls to action to be added to content
 *
 * structure: [uw_cta type="image" style="purple" img="(url)" full_width="true" spacing="" id="" heading="Heading text" heading_level="h2" link_text="Link text" target="#"](CTA copy)[/uw_cta]
 */

class UW_Call_To_Action {
	function __construct() {
		add_shortcode( 'uw_cta', array( $this, 'cta_handler' ) );
	}

	/**
	 * Enqueue CTA script.
	 *
	 * @return void
	 */
	function cta_handler( $atts, $content = null ) {
		// Shortcode attributes and defaults.
		$atts = shortcode_atts(
			array(
				'type'          => 'image', // type of CTA (image or noimage).
				'style'         => 'purple', // style of CTA (purple, gold, white).
				'img'           => '', // image URL for image CTAs.
				'full_width'    => 'false', // whether the CTA should be full width (false or true).
				'spacing'       => 'default', // spacing class for the CTA (default, top, bottom, all).
				'id'            => '', // unique ID for the CTA.
				'heading'       => 'Enter a heading', // heading text.
				'heading_level' => 'h2', // heading level (h1, h2, etc.).
				'link_text'     => 'Enter link text', // link text for the CTA.
				'target'        => '#', // where the CTA links to.
			),
			$atts
		);

		// Set default values for CTA type and style. Set button class based on type and style.
		if ( isset( $atts['type'] ) && 'image' === $atts['type'] ) {
			$cta_type = 'image';
			$cta_style = $atts['style'];
			$cta_image = $atts['img'];

			if ( 'gold' === $cta_style ) {
				$button_class = 'white';
			} elseif ( 'white'  === $cta_style ) {
				$button_class = 'primary purple';
			} else {
				$button_class = 'secondary lightgold';
			}
		} else {
			$button_class = 'secondary lightgold';
		}

		// If no image is provided, set type to noimage. Default is image.
		if ( 'image' === $atts['type'] && '' === $atts['img'] ) {
			// If type is image but no image is provided, change type to noimage.
			$cta_type = 'noimage';
		} elseif ( 'noimage' === $atts['type'] ) {
			// If type is noimage, set style to default.
			$cta_type = 'noimage';
		} else {
			// Default type is image.
			$cta_type = 'image';
		}

		// Set spacing class based on spacing attribute.
		if ( isset( $atts['spacing'] ) )  {
			$cta_spacing = $atts['spacing'];
			if ( 'all' === $cta_spacing ) {
				$cta_spacing_class = 'rm-col-padding';
			} elseif ( 'top' === $cta_spacing ) {
				$cta_spacing_class = 'rm-top-padding';
			} elseif ( 'bottom' === $cta_spacing ) {
				$cta_spacing_class = 'rm-bottom-padding';
			} else {
				// default; none.
				$cta_spacing_class = '';
			}
		} else {
			// default; none.
			$cta_spacing_class = '';
		}

		// Set heading level or use default h2.
		if ( isset( $atts['heading_level'] ) ) {
			$heading_level = strtolower($atts['heading_level']);
		} else {
			$heading_level = 'h2';
		}

		// Set width class based on full_width attribute.
		if ( isset( $atts['full_width'] ) && 'true' === $atts['full_width'] ) {
			$width = ' full-width';
		} else {
			$width = ' content-width';
		}

		ob_start();

		// output the CTA HTML.
		?>
		<div <?php if ( '' !== $atts['id']): ?>id="<?php echo esc_attr( $atts['id'] ); ?>"<?php endif; ?> class="call-to-action cta-<?php echo esc_attr( $cta_type ); ?><?php if ( 'image' === $atts['type'] ) : echo esc_attr( ' ' . $atts['style'] ); endif; ?><?php echo esc_attr( $width ); ?> <?php echo esc_attr( $cta_spacing_class ); ?>">
			<div class="container">
				<div class="row">
					<div class="cta-content">
						<div class="cta-body">
							<<?php echo esc_html( $heading_level ); ?> class="h2"><?php echo esc_html( $atts['heading'] ); ?></<?php echo esc_html( $heading_level ); ?>>
							<p><?php echo esc_html( $content ); ?></p>
							<p class="button"><a href="<?php echo esc_attr( $atts['target'] ); ?>" class="btn btn-lg arrow <?php echo $button_class ? esc_attr( $button_class ) : esc_attr( 'primary purple' ); ?>"><span><?php echo esc_attr( $atts['link_text'] ); ?></span><span class="arrow-box"><span class="arrow"></span></span></a></p>
						</div><!-- .cta-body -->
					</div><!-- .cta-content -->
					<?php if ( 'image' === $atts['type'] && $atts['img'] ) : ?>
						<div class="cta-image" style="background-image: url('<?php echo esc_url( $atts['img'] ); ?>');"></div>
					<?php endif; ?>
				</div><!-- .row -->
			</div><!-- .container -->
		</div><!-- .call-to-action -->
		<?php
	}
}
