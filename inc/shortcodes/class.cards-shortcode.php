<?php
/**
 * Shortcode for embedding cards style module
 *
 * Template:
 * [uw_card style="" align="" color="" image="" alt="" icon="" title="" subtitle="" button="" link=""]content goes here[/uw_card]
 *
 * SMALL CARDS STYLES.
 * - inset: inset image color background.
 * - no-image: no image color background.
 * - image-top: image top color background.
 * - block: block headline. no image, white background.
 * - text-link: headline, text link. no image, white background.
 * - step: no image, icon top corner, sub-title. New Huskies for reference.
 *
 * SMALL CARD OPTIONS:
 * - color combos - light gold background with purple headings and black text, white button; white background with purple headings and black text, purple button; purple background with white text, heading, light gold button.
 * - alignment options: none - nest in grid: [row][col].
 * - cards all same height: use height="equal" on [row] shortcode.
 *
 * LARGE CARDS (with image).
 * - white background.
 * - purple background.
 * - gold background.
 *
 * FULL-WIDTH CARDS (with image).
 * - gold, left.
 * - gold, right.
 */
class UW_Card {
	/**
	 * Card constructor.
	 */
	public function __construct() {
		add_shortcode( 'uw_card', array( $this, 'card_handler' ) );
	}

	/**
	 * Undocumented function
	 *
	 * @param [type] $atts
	 * @param [type] $content
	 * @return void
	 */
	public function card_handler( $atts, $content = null ) {
		// get shortcode attributes.
		$card_atts = shortcode_atts(
			array(
				'style'    => '', // different nanes for small + large, full-width.
				'align'    => '', // left, right, center.
				'color'    => '', // pull these options from STM Fast Facts?
				'image'    => '', // url for the image from the media library.
				'alt'      => '', // alt text for the image.
				'icon'     => '', // used for step style card only.
				'title'    => '', // required. headline.
				'titletag' => 'h2', // title tag, only coded for h2, h3 and h4
				'subtitle' => '', // used for step style card only.
				'button'   => '', // button text.
				'link'     => '', // button link.
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

		// if the style is set, get the style.
		if ( empty( $card_atts['style'] ) ) {
			$card_class = 'inset';
			$text_class = 'text-center';
			$style = $card_atts['style'];
		} else {
			$style = $card_atts['style'];

			// set the $card_class and $text_class for each style.
			switch ( $style ) {
				case 'no-image':
					$card_class = 'no-image';
					$text_class = 'text-left';
					break;
				case 'image-top':
					$card_class = 'image-top';
					$text_class = 'text-left';
					break;
				case 'block':
					$card_class = 'block-top';
					$text_class = 'text-left';
					break;
				case 'text-link':
					$card_class = 'white text-button';
					$text_class = 'text-left';
					break;
				case 'step':
					$card_class = 'step white text-button';
					$text_class = 'text-left';
					break;
				case 'large':
					$card_class = 'large';
					$text_class = 'text-left';
					break;
				case 'full-width':
					$card_class = 'full-width uw-slant-border';
					$text_class = 'text-left';
					break;
				default:
					$card_class = 'inset';
					$text_class = 'text-center';
			}
		}

		// get the color option and set.
		if ( 'purple' === $card_atts['color']) {
			$card_color = 'purple';
			$button_color = 'secondary light-gold';
		} elseif ( 'white' === $card_atts['color'] ) {
			$card_color = 'white';
			$button_color = 'primary purple';
		} elseif ( 'inset' === $card_class && empty( $card_atts['color'] ) ) {
			$card_color = 'lightgold';
			$button_color = 'purple';
		} elseif ( 'block' === $style ) {
			if ( 'gold' === $card_atts['color'] ) {
				$card_color = 'gold';
			} else {
				$card_color = 'purple';
			}
		} else {
			$card_color = 'lightgold';
			$button_color = 'white';
		}

		// set the widths for the cards.
		if ( 'full-width' === $style ) {
			$card_width = '100vw';
		} elseif ( 'large' === $style ) {
			$card_width = '100%';
		} else {
			$card_width = '100%';
		}

		// if the image is set, get the image.
		if ( ! empty( $card_atts['image'] ) ) {
			$image = $card_atts['image'];

			if ( ! empty( $card_atts['alt'] ) ) {
				$alt = $card_atts['alt'];
			} else {
				$alt = '';
			}
		}

		// do background image stuff for large and full-width cards.
		if ( 'large' === $style || 'full-width' === $style ) {
			if ( ! empty( $card_atts['image'] ) ) {
				$background = ' style="background-image: url(' . $image . ');"';
			} else {
				$background = '';
			}
		}

		// get the button text. use default prompting if not provided.
		if ( $card_atts['button'] ) {
			$button_text = $card_atts['button'];
		} else {
			$button_text = 'Add button text!';
		}

		// get the card title.
		if ( $card_atts['title'] ) {
			$card_title = $card_atts['title'];
		} else {
			$card_title = 'Add a title!';
		}

		// get the alignment for large and full width cards and set up classes accordingly.
		if ( 'full-width' === $style || 'large' === $style ) {
			if ( 'left' === $card_atts['align'] ) {
				$align_class = 'img-right';
			} else {
				$align_class = 'img-left';
			}
		} else {
			// nada yet.
		}

		// build the SVG slash pattern for full-width cards.
		$svg_slash = '<div><svg class="slant-pattern"><defs><pattern id="pattern-stripe" width="14" height="10" patternUnits="userSpaceOnUse" patternTransform="rotate(15)"><rect width="1" height="10" transform="translate(0,0)" fill="white"></rect></pattern><mask id="mask-stripe"><rect x="0" y="0" width="100%" height="100%" fill="url(#pattern-stripe)" /></mask></defs><rect class="hbar purple-lines" x="0" y="0" width="100%" height="100"></rect></svg></div>';

		// build the shortcode output. what a mess!
		ob_start();
		?>
		<div class="card <?php echo esc_attr( $text_class ); ?> <?php echo esc_attr( $card_class ); ?> <?php echo esc_attr( $card_color ); ?> <?php if ( 'large' === $style || 'full-width' === $style ) { echo esc_attr( $align_class ); } ?>" style="width: <?php echo esc_attr( $card_width ); ?>">
			<?php
			// image-top card.
			if ( ! empty( $card_atts['image'] ) && 'image-top' === $card_class ) {
				?>
				<div><img src="<?php echo esc_attr( $image ); ?>" class="card-img-top" alt="<?php echo esc_attr( $alt ); ?>"></div>
				<?php
			}
			// large cards.
			if ( 'large' === $style || 'full-width' === $style ) {
				?>
				<div class="image-large"<?php echo wp_kses_post( $background ); ?>></div>
				<?php
			}
			// block head card.
			if ( 'block' === $style ) {
				?>
				<<?php echo esc_attr( $card_atts['titletag'] ); ?> class="card-title"><?php echo wp_kses_post( $card_title ); ?></<?php echo esc_attr( $card_atts['titletag'] ); ?>>
			<?php } ?>
			<div class="card-body">
				<?php
				// large card.
				if ( 'large' === $style || 'full-width' === $style ) {
					?>
				<div class="inner-card-body">
				<?php }
				// step card.
				if ( ! empty( $card_atts['subtitle'] ) && 'step' === $style ) {
					?>
				<div class="subtitle"><?php echo esc_attr( $card_atts['subtitle'] ); ?></div>
					<?php
				}
				// also step card.
				if ( ! empty( $card_atts['icon'] ) && 'step' === $style ) {
					?>
				<div class="icon <?php echo esc_attr( $card_atts['icon'] ); ?>" aria-hidden="true"></div>
					<?php
				}
				// inset image card.
				if ( ! empty( $card_atts['image'] ) && 'inset' === $card_class ) { ?>
					<div><img src="<?php echo esc_attr( $image ); ?>" class="card-img card-img-inset" alt="<?php echo esc_attr( $alt ); ?>"></div>
					<?php
				}
				// block card.
				if ( 'block' !== $style ) {
					?>
					<<?php echo esc_attr( $card_atts['titletag'] ); ?> class="card-title <?php if ( 'no-image' === $card_class || 'image-top' === $card_class || 'text-link' === $card_class || 'step' === $style ) { echo esc_attr( 'card-title-slant' ); } ?>"><?php echo wp_kses_post( $card_title ); ?></<?php echo esc_attr( $card_atts['titletag'] ); ?>>
					<?php
					// no-image, image-top, text-link, or step card.
					if ( 'no-image' === $card_class || 'image-top' === $card_class || 'text-link' === $card_class || 'step' === $style ) {
						?>
					<div class="udub-slant-divider"><span></span></div>
						<?php
					}
				}
				?>
				<?php echo wp_kses_post( $content ); ?>
				<?php
				// inset card, small button.
				if ( ! empty( $card_atts['link'] ) && 'inset' === $card_class ) { ?>
					<p class="button"><a href="<?php echo esc_url( $card_atts['link'] ); ?>" class="btn btn-sm <?php echo esc_attr( $button_color ); ?>"><span><?php echo esc_attr( $button_text ); ?></span></a></p></div></div>
				<?php }
				// arrow button.
				elseif ( ! empty( $card_atts['link'] ) && ( 'no-image' === $card_class || 'image-top' === $style || 'large' === $style ||
				'full-width' === $style ) ) { ?>
					<p class="button"><a href="<?php echo esc_url( $card_atts['link'] ); ?>" class="btn btn-lg arrow <?php echo esc_attr( $button_color ); ?>"><span><?php echo esc_attr( $button_text ); ?></span><span class="arrow-box"><span class="arrow"></span></span></a></p></div></div>
				<?php
				}
				// text link button.
				elseif ( ! empty( $card_atts['link'] ) && ( 'text-link' === $style || 'step' === $style ) ) { ?>
					<p><a class="link-arrow-box" href="<?php echo esc_url( $card_atts['link'] ); ?>"><?php echo esc_attr( $button_text ); ?><span class="arrow-box"><span class="arrow"></span></span></a></p></div></div>
				<?php } else { ?>
					</div></div>
					<?php
				}

				// add one more </div> for the large card and svg for full-width.
				if ( 'large' === $style || 'full-width' === $style ) {
					if ( 'full-width' === $style ) {
						echo wp_kses( $svg_slash, $allowed_tags );
					}
					?></div>
				<?php } ?>

		<?php
		// return the shortcode output.
		return ob_get_clean();
	}
}
