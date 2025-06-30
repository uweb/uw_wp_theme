<?php
/**
 * Shortcode for embedding jumbotron style module
 *
 * Template:
 * [uw_jumbotron style="" image="" title="" button="" link=""]content goes here[/uw_jumbotron]
 *
 * FULL-WIDTH JUMBOTRON.
 * - block.
 * - block-slant.
 * - block-center.
 * - simple.
 *
 * LARGE JUMBOTRON (default).
 * - same as simple but content-width.
 */
class UW_Jumbotron {
	/**
	 * Jumbotron constructor.
	 */
	public function __construct() {
		add_shortcode( 'uw_jumbotron', array( $this, 'jumbotron_handler' ) );
	}

	/**
	 * Jumbotron handler
	 *
	 * @param [type] $atts
	 * @param [type] $content
	 * @return void
	 */
	public function jumbotron_handler( $atts, $content = null ) {
		// get shortcode attributes.
		$jumbotron_atts = shortcode_atts(
			array(
				'style'    => '', // block, block-slant, block-center, simple, default.
				'align'    => '', // right. optional alignment for block and block-slant (left-aligned by default).
				'overlay'  => '', // optional overlay for text on jumbotrons without them by default (default, simple).
				'image'    => '', // url for the image from the media library. uses new-burke image if none set.
				'title'    => '', // required. headline.
				'titletag' => 'h2', // title tag, supports h1, h2, h3.
				'button'   => '', // required. button text.
				'link'     => '', // required. button link.
				'id'       => '', // optional ID.
				'alt'      => '', // optional alt tag for the image
			),
			$atts
		);

		// Update kses to allow SVG in output.
		$kses_defaults = wp_kses_allowed_html( 'post' );

		$svg_args = array(
			'svg'     => array( 'class' => true ),
			'pattern' => array(
				'id'               => true,
				'width'            => true,
				'height'           => true,
				'patternunits'     => true,
				'patterntransform' => true,
			),
			'mask'    => array( 'id' => true ),
			'rect'    => array(
				'x'         => true,
				'y'         => true,
				'fill'      => true,
				'width'     => true,
				'height'    => true,
				'class'     => true,
				'transform' => true,
			),
		);
		$allowed_tags = array_merge( $kses_defaults, $svg_args );

		// get optional ID.
		$jumbotron_id = ! empty( $jumbotron_atts['id'] ) ? 'id="' . esc_attr( $jumbotron_atts['id'] ) . '"' : '';

		// overlays and button options specific to overlay.
		if ( 'simple' === $jumbotron_atts['style'] || 'default' === $jumbotron_atts['style'] || empty( $jumbotron_atts['style'] ) ) {
			if ( ! empty( $jumbotron_atts['overlay'] ) ) {
				$overlay = $jumbotron_atts['overlay'];

				if ( 'purple' === $overlay ) {
					$overlay_class = 'purple-overlay';
					$button_class = 'secondary';
				} elseif ( 'gray' === $overlay ) {
					$overlay_class = 'gray-overlay';
					$button_class = 'primary purple';
				} elseif ( 'gold' === $overlay ) {
					$overlay_class = 'gold-overlay';
					$button_class = 'white';
				} elseif ( 'white' === $overlay ) {
					$overlay_class = 'white-overlay';
					$button_class = 'primary purple';
				} else {
					$overlay_class = ''; // if not set, don't set.
					$button_class = ''; // if not set, don't set.
				}
			} else {
				$overlay_class = ''; // if not set, don't set.
				$button_class = ''; // if not set, don't set.
			}
		} else {
			$overlay_class = ''; // if not set, don't set.
			$button_class = ''; // if not set, don't set.
		}

		// if the style is set, get the style.
		if ( empty( $jumbotron_atts['style'] ) ) {
			$jumbotron_class = 'img-background default';
			$inner_class = 'w-60';
			$style = $jumbotron_atts['style'];
		} else {
			$style = $jumbotron_atts['style'];

			// set the $jumbotron_class and $inner_class for each style.
			switch ( $style ) {
				case 'block':
					$jumbotron_class = 'img-background jumbo-block full-width';
					$inner_class = 'w-40';
					break;
				case 'block-slant':
					$jumbotron_class = 'img-background overlay jumbo-block-slant full-width';
					$inner_class = 'transparent-overlay-slant';
					break;
				case 'block-center':
					$jumbotron_class = 'img-background jumbo-block-center full-width';
					$inner_class = 'd-flex-column w-40';
					break;
				case 'simple':
					$jumbotron_class = 'img-background jumbo-simple full-width';
					$inner_class = 'w-60';
					break;
				default:
					$jumbotron_class = 'img-background default';
					$inner_class = 'w-60';
			}
		}

		// alignment options, for block and block-slant only ATM. Adjusts the position of the overlay, not the text.
		if ( 'block' === $style || 'block-slant' === $style ) {
			if ( ! empty( $jumbotron_atts['align'] ) ) {
				if ( 'right' === $jumbotron_atts['align'] && 'block-slant' === $style ) {
					$align_class = 'overlay-right';
				} elseif ( 'right' === $jumbotron_atts['align'] && 'block' === $style ) {
					$align_class = 'd-flex justify-content-end';
				} else {
					$align_class = ''; // default.
				}
			} else {
				$align_class = ''; // default.
			}
		}

		// if the image is set, get the image.
		if ( ! empty( $jumbotron_atts['image'] ) ) {
			$image = $jumbotron_atts['image'];
		} else {
			$image = '';
		}

		// if the image alt tag is set, get it.
		if ( ! empty( $jumbotron_atts['alt'] ) ) {
			$alt = $jumbotron_atts['alt'];
		} else {
			$alt = '';
		}

		// get the button text. use default prompting if not provided.
		if ( $jumbotron_atts['button'] ) {
			$button_text = $jumbotron_atts['button'];
		} else {
			$button_text = 'Add button text!';
		}

		// get the jumbotron title.
		if ( $jumbotron_atts['title'] ) {
			$jumbotron_title = $jumbotron_atts['title'];
		} else {
			$jumbotron_title = 'Add a title!';
		}

		// build the SVG slash pattern for full-width jumbotrons.
		$random_id = rand(); // get a random number to append to id, in case of multiple cards on page.
		$svg_slash = '<div><svg class="slant-pattern"><defs><pattern id="pattern-stripe-' . $random_id . '" width="14" height="10" patternUnits="userSpaceOnUse" patternTransform="rotate(15)"><rect width="1" height="10" transform="translate(0,0)" fill="white"></rect></pattern><mask id="mask-stripe"><rect x="0" y="0" width="100%" height="100%" fill="url(#pattern-stripe-' . $random_id . ')" /></mask></defs><rect class="hbar white-lines" x="0" y="0" width="100%" height="100"></rect></svg></div>';

		// build the shortcode output.
		ob_start();
		?>
		<div <?php echo $jumbotron_id; ?> class="jumbotron jumbotron-fluid <?php echo esc_attr( $jumbotron_class ); ?> <?php echo esc_attr( $overlay_class ); ?> <?php if ( 'block' === $style ) { echo esc_attr( $align_class ); } ?>" <?php if ( ! empty( $jumbotron_atts['image'] ) && $image ) { ?> style="background-image: url(<?php echo esc_url( $image ); ?>);" <?php } ?>><img class="mobile-img" src="<?php echo $image ?>" alt="<?php echo $alt ?>">
			<div class="<?php echo esc_attr( $inner_class ); ?> <?php if ( 'block-slant' === $style ) { echo esc_attr( $align_class ); } ?>">
				<?php if ( 'block-slant' === $style ) { ?>
					<div class="inner-overlay">
				<?php } elseif ( 'block-center' === $style ) { ?>
					<div class="container">
				<?php } ?>
				<<?php echo esc_attr( $jumbotron_atts['titletag'] ); ?> class="display-3"><?php echo esc_attr( $jumbotron_title ); ?></<?php echo esc_attr( $jumbotron_atts['titletag'] ); ?>>
				<?php if ( 'simple' === $jumbotron_atts['style'] || empty( $jumbotron_atts['style'] ) ) { ?>
					<div class="udub-slant-divider"><span></span></div>
				<?php } ?>
				<p><?php echo apply_filters( 'the_content', $content ); ?></p>
				<?php if ( 'block-center' === $style ) { ?>
					</div>
				<?php } ?>

				<?php //if the button attribute is set, show the button.
				if ( $jumbotron_atts['button'] ) { ?>
					<?php if ( 'block-slant' === $style ) { ?>
						<p class="button"><a href="<?php echo esc_url( $jumbotron_atts['link'] ); ?>" class="btn btn-lg secondary"><span><?php echo wp_kses_post( $button_text ); ?></span></a></p>
					<?php } elseif ( 'block-center' === $style ) { ?>
						<p class="button"><a href="<?php echo esc_url( $jumbotron_atts['link'] ); ?>" class="btn btn-sm primary"><span><?php echo wp_kses_post( $button_text ); ?></span></a></p>
					<?php } else { ?>
						<p class="button"><a href="<?php echo esc_url( $jumbotron_atts['link'] ); ?>" class="btn btn-lg arrow <?php echo $button_class ? esc_attr( $button_class ) : esc_attr( 'primary purple' ); ?>"><span><?php echo wp_kses_post( $button_text ); ?></span><span class="arrow-box"><span class="arrow"></span></span></a></p>
					<?php } ?>
				<?php } ?>
				<?php
				if ( 'block' === $style ) {
					echo wp_kses( $svg_slash, $allowed_tags );
				}
				?>
				<?php if ( 'block-slant' === $style ) { ?>
					</div>
				<?php } ?>
			</div>
		</div>
		<?php
		// return the shortcode output.
		return ob_get_clean();
	}
}
