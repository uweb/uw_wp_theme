<?php
/**
 * Shortcode for embedding cards style module
 *
 * Template:
 * [uw_card style="" align="" color="" image="" alt="" icon="" title="" subtitle="" button="" link="" image_and_title_link=""]content goes here[/uw_card]
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
				'style'    => '', // different names for small + large, full-width.
				'align'    => '', // left, right, center.
				'color'    => '', // pull these options from STM Fast Facts?
				'image'    => '', // url for the image from the media library.
				'alt'      => '', // alt text for the image.
				'icon'     => '', // used for step style card only.
				'title'    => '', // required. headline.
				'titletag' => 'h2', // title tag, only coded for h2, h3 and h4.
				'subtitle' => '', // used for step style card only.
				'button'   => '', // button text.
				'link'     => '', // button link.
				'stretched_link'   => '', // if set to true, the image and title will also activate the link provided.
				'id'       => '', // optional ID.
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

		// if there's an ID, set it up. otherwise, leave empty.
		if ( ! empty( $card_atts['id'] ) ) {
			$card_id = 'id="' . esc_attr( strtolower( $card_atts['id'] ) ) . '"';
		} else {
			$card_id = '';
		}

		// if the style is set, get the style.
		if ( empty( $card_atts['style'] ) ) {
			$card_class = 'inset';
			$text_class = 'text-center';
			$style      = strtolower( $card_atts['style'] );
		} else {
			$style = strtolower( $card_atts['style'] );

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
				case 'half-block-large':
					$card_class = 'large half-block';
					$text_class = 'text-left';
					break;
				case 'full-width':
					$card_class = 'full-width uw-slant-border';
					$text_class = 'text-left';
					break;
				case 'half-block-full':
					$card_class = 'full-width half-block';
					$text_class = 'text-left';
					break;
				case 'half-block-full-width':
					$card_class = 'full-width half-block';
					$text_class = 'text-left';
					break;
				default:
					$card_class = 'inset';
					$text_class = 'text-center';
			}
		}

		// get the color option and set.
		if ( 'purple' === strtolower( $card_atts['color'] ) ) {
			$card_color   = 'purple';
			$button_color = 'secondary light-gold';
		} elseif ( 'white' === strtolower( $card_atts['color'] ) ) {
			$card_color   = 'white';
			$button_color = 'primary purple';
		} elseif ( 'inset' === strtolower( $card_class ) && empty( $card_atts['color'] ) ) {
			$card_color   = 'lightgold';
			$button_color = 'purple';
		} elseif ( 'block' === strtolower( $style ) ) {
			if ( 'gold' === strtolower( $card_atts['color'] ) ) {
				$card_color = 'gold';
			} else {
				$card_color = 'purple';
			}
		} else {
			$card_color   = 'lightgold';
			$button_color = 'white';
		}

		// set the widths for the cards.
		if ( 'full-width' === strtolower( $style ) || 'half-block-full' === strtolower( $style ) || 'half-block-full-width' === strtolower( $style ) ) {
			$card_width = '100vw';
		} elseif ( 'large' === strtolower( $style ) || 'half-block-large' === strtolower( $style ) ) {
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
		if ( 'large' === strtolower( $style ) || 'full-width' === strtolower( $style ) || 'half-block-large' === strtolower( $style ) || 'half-block-full' === strtolower( $style ) || 'half-block-full-width' === strtolower( $style ) ) {
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
		if ( 'full-width' === strtolower( $style ) || 'large' === strtolower( $style ) || 'half-block-large' === strtolower( $style ) || 'half-block-full' === strtolower( $style ) || 'half-block-full-width' === strtolower( $style ) ) {
			if ( 'left' === strtolower( $card_atts['align'] ) ) {
				$align_class = 'img-right';
			} else {
				$align_class = 'img-left';
			}
		} else {
			$align_class = null;
		}

		// add stretch-link to title and image.
		if ( 'true' === $card_atts['stretched_link'] ) {
			$link_class = 'stretched-link';
		} else {
			$link_class = '';
		}

		// build the shortcode output. what a mess!
		ob_start();

		$card_classes  = $text_class;
		$card_classes .= ' ' . $card_class;
		$card_classes .= ' ' . $card_color;
		$card_classes .= ' ' . $align_class;
		$random_id = rand(); // get a random number to append to id, in case of multiple cards on page.

		if ( 'inset' === strtolower( $style ) ) {
			// built out the image inset or default style card.
			$output  = '<div ' . $card_id . ' class="card ' . esc_attr( $card_classes ) . '" style="width:' . esc_attr( $card_width ) . '">';
			$output .= '<div class="card-body">';
			$output .= '<' . esc_attr( $card_atts['titletag'] ) . ' class="card-title">' . wp_kses_post( $card_title ) . '</' . esc_attr( $card_atts['titletag'] ) . '>';
			$output .= '<div class="card-image-inset"><img src="' . esc_attr( $image ) . '" class="card-img card-img-inset" alt="' . esc_attr( $alt ) . '"></div>';
			$output .= apply_filters( 'the_content', $content );
			if ( ! empty( $card_atts['link'] ) ) {
				$output .= '<p class="button"><a href="' . esc_url( $card_atts['link'] ) . '" class="btn btn-sm ' . esc_attr( $button_color ) . ' ' . esc_attr( $link_class ) .'"><span>' . esc_attr( $button_text ) . '</span></a></p>';
			}
			$output .= '</div></div>';
		} elseif ( 'image-top' === strtolower( $style ) ) {
			// build out the image top style card.
			$output  = '<div ' . $card_id . ' class="card ' . esc_attr( $card_classes ) . '" style="width:' . esc_attr( $card_width ) . '">';
			$output .= '<div class="card-body">';
			$output .= '<' . esc_attr( $card_atts['titletag'] ) . ' class="card-title mb-0">' . wp_kses_post( $card_title ) . '</' . esc_attr( $card_atts['titletag'] ) . '>';
			$output .= '<div class="card-image-top"><img src="' . esc_attr( $image ) . '" class="card-img card-img-top" alt="' . esc_attr( $alt ) . '"></div>';
			$output .= '<div class="udub-slant-divider"><span></span></div>';
			$output .= '<div class="card-content">' . apply_filters( 'the_content', $content ) . '</div>';
			if ( ! empty( $card_atts['link'] ) ) {
				$output .= '<p class="button"><a href="' . esc_url( $card_atts['link'] ) . '" class="btn btn-lg arrow ' . esc_attr( $button_color ) . ' ' . esc_attr( $link_class ) . '"><span>' . esc_attr( $button_text ) . '</span><span class="arrow-box"><span class="arrow"></span></span></a></p>';
			}
			$output .= '</div></div>';
		} elseif ( 'no-image' === strtolower( $style ) ) {
			// build out the no-image style card.
			$output  = '<div ' . $card_id . ' class="card ' . esc_attr( $card_classes ) . '" style="width:' . esc_attr( $card_width ) . '">';
			$output .= '<div class="card-body">';
			$output .= '<' . esc_attr( $card_atts['titletag'] ) . ' class="card-title mb-0">' . wp_kses_post( $card_title ) . '</' . esc_attr( $card_atts['titletag'] ) . '>';
			$output .= '<div class="udub-slant-divider"><span></span></div>';
			$output .= '<div class="card-content">' . apply_filters( 'the_content', $content ) . '</div>';
			if ( ! empty( $card_atts['link'] ) ) {
				$output .= '<p class="button"><a href="' . esc_url( $card_atts['link'] ) . '" class="btn btn-lg arrow ' . esc_attr( $button_color ) . '"><span>' . esc_attr( $button_text ) . '</span><span class="arrow-box"><span class="arrow"></span></span></a></p>';
			}
			$output .= '</div></div>';
		} elseif ( 'block' === strtolower( $style ) ) {
			// build out the block top style card.
			$output  = '<div ' . $card_id . ' class="card ' . esc_attr( $card_classes ) . '" style="width:' . esc_attr( $card_width ) . '">';
			$output .= '<' . esc_attr( $card_atts['titletag'] ) . ' class="card-title">' . wp_kses_post( $card_title ) . '</' . esc_attr( $card_atts['titletag'] ) . '>';
			$output .= '<div class="card-body">';
			$output .= '<div class="card-content">' . apply_filters( 'the_content', $content ) . '</div>';
			if ( ! empty( $card_atts['link'] ) ) {
				$output .= '<p class="button"><a href="' . esc_url( $card_atts['link'] ) . '" class="btn btn-sm ' . esc_attr( $button_color ) . ' ' . esc_attr( $link_class ) . '"><span>' . esc_attr( $button_text ) . '</span></a></p>';
			}
			$output .= '</div></div>';
		} elseif ( 'text-link' === strtolower( $style ) ) {
			// build out the text link style card.
			$output  = '<div ' . $card_id . ' class="card ' . esc_attr( $card_classes ) . '" style="width:' . esc_attr( $card_width ) . '">';
			$output .= '<div class="card-body">';
			$output .= '<' . esc_attr( $card_atts['titletag'] ) . ' class="card-title mb-0">' . wp_kses_post( $card_title ) . '</' . esc_attr( $card_atts['titletag'] ) . '>';
			$output .= '<div class="udub-slant-divider"><span></span></div>';
			$output .= '<div class="card-content">' . apply_filters( 'the_content', $content ) . '</div>';
			if ( ! empty( $card_atts['link'] ) ) {
				$output .= '<p><a href="' . esc_url( $card_atts['link'] ) . '" class="link-arrow-box"><span>' . esc_attr( $button_text ) . '<span class="arrow-box"><span class="arrow"></span></span></a></p>';
			}
			$output .= '</div></div>';
		} elseif ( 'step' === strtolower( $style ) ) {
			// build out the step style card.
			$output  = '<div ' . $card_id . ' class="card ' . esc_attr( $card_classes ) . '" style="width:' . esc_attr( $card_width ) . '">';
			$output .= '<div class="card-body">';
			if ( ! empty( $card_atts['subtitle'] ) ) {
				$output .= '<div class="subtitle">' . esc_attr( $card_atts['subtitle'] ) . '</div>';
			}
			if ( ! empty( $card_atts['icon'] ) ) {
				$output .= '<div class="icon ' . esc_attr( $card_atts['icon'] ) . '" aria-hidden="true"></div>';
			}
			$output .= '<' . esc_attr( $card_atts['titletag'] ) . ' class="card-title mb-0">' . wp_kses_post( $card_title ) . '</' . esc_attr( $card_atts['titletag'] ) . '>';
			$output .= '<div class="udub-slant-divider"><span></span></div>';
			$output .= '<div class="card-content">' . apply_filters( 'the_content', $content ) . '</div>';
			if ( ! empty( $card_atts['link'] ) ) {
				$output .= '<p><a href="' . esc_url( $card_atts['link'] ) . '" class="link-arrow-box"><span>' . esc_attr( $button_text ) . '<span class="arrow-box"><span class="arrow"></span></span></a></p>';
			}
			$output .= '</div></div>';
		} elseif ( 'large' === strtolower( $style ) || 'half-block-large' === strtolower( $style ) ) {
			// build out the large card.
			$output  = '<div ' . $card_id . ' class="card ' . esc_attr( $card_classes ) . '" style="width:' . esc_attr( $card_width ) . '">';
			$output .= '<div class="image-large"' . wp_kses_post( $background ) . '></div>';
			$output .= '<div class="card-body">';
			$output .= '<div class="inner-card-body">';
			$output .= '<' . esc_attr( $card_atts['titletag'] ) . ' class="card-title">' . wp_kses_post( $card_title ) . '</' . esc_attr( $card_atts['titletag'] ) . '>';
			$output .= apply_filters( 'the_content', $content );
			if ( ! empty( $card_atts['link'] ) ) {
				$output .= '<p class="button"><a href="' . esc_url( $card_atts['link'] ) . '" class="btn btn-lg arrow ' . esc_attr( $button_color ) . '"><span>' . esc_attr( $button_text ) . '</span><span class="arrow-box"><span class="arrow"></span></span></a></p>';
			}
			$output .= '</div></div></div>';
		} elseif ( 'full-width' === strtolower( $style ) || 'half-block-full' === strtolower( $style ) || 'half-block-full-width' === strtolower( $style ) ) {
			// build out the full-width card.
			$output  = '<div ' . $card_id . ' class="card ' . esc_attr( $card_classes ) . '" style="width:' . esc_attr( $card_width ) . '">';
			$output .= '<div class="image-large"' . wp_kses_post( $background ) . '></div>';
			$output .= '<div class="card-body">';
			$output .= '<div class="inner-card-body">';
			$output .= '<' . esc_attr( $card_atts['titletag'] ) . ' class="card-title">' . wp_kses_post( $card_title ) . '</' . esc_attr( $card_atts['titletag'] ) . '>';
			$output .= apply_filters( 'the_content', $content );
			if ( ! empty( $card_atts['link'] ) ) {
				$output .= '<p class="button"><a href="' . esc_url( $card_atts['link'] ) . '" class="btn btn-lg arrow ' . esc_attr( $button_color ) . '"><span>' . esc_attr( $button_text ) . '</span><span class="arrow-box"><span class="arrow"></span></span></a></p>';
			}
			$output .= '</div></div>';
			$output .= '<div><svg class="slant-pattern"><defs><pattern id="pattern-stripe-' . $random_id . '" width="14" height="10" patternUnits="userSpaceOnUse" patternTransform="rotate(15)"><rect width="1" height="10" transform="translate(0,0)" fill="white"></rect></pattern><mask id="mask-stripe"><rect x="0" y="0" width="100%" height="100%" fill="url(#pattern-stripe-' . $random_id . ')" /></mask></defs><rect class="hbar purple-lines" x="0" y="0" width="100%" height="100"></rect></svg></div>';
			$output .= '</div>';
		}

		if ( 'full-width' !== strtolower( $style ) ) {
			echo apply_filters( 'the_content', $output );
		} else {
			echo wp_kses( $output, $allowed_tags );
		}

		// return the shortcode output.
		return ob_get_clean();
	}
}
