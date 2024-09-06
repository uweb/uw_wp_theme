<?php
/**
 * Adds a media credit capability to images in the media library.
 */
class UW_Media_Credit
{

	function __construct() {

		add_filter( 'img_caption_shortcode', array( $this, 'add_media_credit_to_caption_shortcode_filter'), 10, 3 );

		add_filter( 'mce_external_plugins', array( $this, 'add_media_credit_shortcode_to_tinymce' ) );

		add_filter( 'image_send_to_editor', array( $this, 'mediacredit_tinymce_html'), 10, 7 );

		add_shortcode( 'mediacredit', array( $this, 'mediacredit_shortcode') );

		add_filter( "attachment_fields_to_edit", array( $this, "image_attachment_fields_to_edit"), 100, 2);

		add_filter( "attachment_fields_to_save", array( $this, "custom_image_attachment_fields_to_save" ), 10, 2);
	}

	/**
	 * Adds a media credit shortcode to tinymce so they can be shown on visual
	 * editor
	 */

	function add_media_credit_shortcode_to_tinymce( $plugins ) {
		$plugin_array[ 'mediacredit' ] = get_template_directory_uri() . '/assets/admin/js/media-credit.js';
		return $plugin_array;
	}

	/**
	 * Override the editor html to include media credit even if the photo caption
	 *  is empty. By default, WordPress core deletes the [caption] shortcode
	 *  if no caption is present.
	 *
	 *  to do: completely override the code media caption functionality,
	 *  including the TinyMCE plugins, to handle this.
	 */

	function mediacredit_tinymce_html( $html, $id, $caption, $title, $align, $url, $size ) {

		if ( $caption )
			return $html;

		$credit = get_post_meta( $id, '_media_credit', true);
		$img    = wp_get_attachment_image_src( $id, $size );
		$width = $img[1];
		$height = $img[2];

		return $credit ?
		'[mediacredit id="attachment_' . $id . '" align="align' . $align . '" width="' . $width . '" credit="' . $credit . '"]<a href="' . $img[0] . '"><img src="' . $img[0] . '" alt="' . $caption . '" width="' . $width . '" height="' . $height . '" class="figure-img size-' . $size . ' wp-image-' . $id . '" /></a> ' . $caption . '[/mediacredit]' : $html;

	}


	/**
	 * Builds the HTML 5 bootstrap output for media captions and media credit.
	 * This code was adapted from the img_caption_shortcode() function in
	 * WordPress core
	 * https://developer.wordpress.org/reference/functions/img_caption_shortcode/
	 *
	 * @param      array   $atts     the shortcode atributes array
	 * @param      string  $content  The content of the shortcode, which should
	 *                                contain the image
	 *
	 * @return     string  HTML of the fully built image + caption
	 */

	function caption_credit_html ( $atts, $content ) {
		wp_enqueue_script( 'uw-gallery-script' );

		$atts['width'] = (int) $atts['width'];

		preg_match('/([\d]+)/', $atts['id'] , $match);

		$credit = get_post_meta( $match[0], '_media_credit', true );

		if ( ( $atts['width'] < 1 || empty( $atts['caption'] ) ) && empty($credit) ) {
			return $content;
		}

		$id          = '';
		$caption_id  = '';
		$describedby = '';

		if ( $atts['id'] ) {
			$atts['id'] = sanitize_html_class( $atts['id'] );
			$id         = 'id="' . esc_attr( $atts['id'] ) . '" ';
		}

		if ( $atts['caption_id'] ) {
			$atts['caption_id'] = sanitize_html_class( $atts['caption_id'] );
		} elseif ( $atts['id'] ) {
			$atts['caption_id'] = 'caption-' . str_replace( '_', '-', $atts['id'] );
		}
		if ( $atts['caption_id'] ) {
			$caption_id  = 'id="' . esc_attr( $atts['caption_id'] ) . '" ';
			$describedby = 'aria-describedby="' . esc_attr( $atts['caption_id'] ) . '" ';
		}

		$class = trim( 'figure-caption wp-caption ' . $atts['align'] . ' ' . $atts['class'] );

		$html5 = current_theme_supports( 'html5', 'caption' );

		// HTML5 captions never added the extra 10px to the image width.
		$width = $html5 ? $atts['width'] : ( 10 + $atts['width'] );

		$caption_width = apply_filters( 'img_caption_shortcode_width', $width, $atts, $content );

		$style = '';

		if ( $caption_width ) {
			$style = 'style="width: ' . (int) $caption_width . 'px" ';
		}


		$source_url = get_post_meta( $match[0], "_source_url", true );


		if ( $source_url != '' ) {
			$credit = '<a href="'. ( $source_url ) .'">'. $credit .'</a>';
		} else {
			$credit = ( $source_url ) . $credit ;
		}
		if ( $credit ) $credit = '<span class="wp-media-credit">Photo: '. $credit . '</span>';

		$html = sprintf(
			'<figure %s%s%sclass="figure %s">%s %s</figure>',
			$id,
			$describedby,
			$style,
			esc_attr( $class ),
			do_shortcode( $content ),
			sprintf(
				'<figcaption %sclass="wp-caption-text">%s %s</figcaption>',
				$caption_id,
				$atts['caption'],
				$credit
			)
		);

		return $html;

	}

	/**
	 * Media Credit shortcode output.
	 */

	function mediacredit_shortcode( $attr, $content ) {
		$atts = shortcode_atts(
			array(
				'id'         => '',
				'caption_id' => '',
				'align'      => 'alignnone',
				'width'      => '',
				'caption'    => '',
				'class'      => '',
			),
			$attr
		);

		return $this->caption_credit_html( $atts, $content );

	}

	/**
	 * Filter to modify the caption shortcode ourput to include media caption.
	 */

	function add_media_credit_to_caption_shortcode_filter( $val, $attr, $content ) {
		$atts = shortcode_atts(
			array(
				'id'         => '',
				'caption_id' => '',
				'align'      => 'alignnone',
				'width'      => '',
				'caption'    => '',
				'class'      => '',
			),
			$attr
		);

		return $this->caption_credit_html( $atts, $content );

	}

	/**
	* Adding the custom fields to the $form_fields array.
	*/

	function image_attachment_fields_to_edit($form_fields, $post) {
		if ( ! in_array('custom-header', get_post_meta($post->ID, "_wp_attachment_context") ) && wp_attachment_is_image( $post->ID ) )
		{
			$form_fields["media_credit"] = array(
				"label" => __("Image Credit"),
				"input" => "text",
				"value" => get_post_meta($post->ID, "_media_credit", true)
			);

			$form_fields["source_url"] = array(
				"label" => __("Credit URL"),
				"input" => "text",
				"value" => get_post_meta( $post->ID, '_source_url', true ),
			);


			$form_fields["media_credit"]["label"] = __( "Image Credit" );
			$form_fields["media_credit"]["input"] = "text";
			$form_fields["media_credit"]["value"] = get_post_meta( $post->ID, "_media_credit", true );

			$form_fields["source_url"]["label"] = __( "Credit URL" );
			$form_fields["source_url"]["input"] = "text";
			$form_fields["source_url"]["value"] = get_post_meta( $post->ID, "_source_url", true );

		}

		return $form_fields;
	}

	/**
	 * Save action for the addition media credit fields.
	 */
	function custom_image_attachment_fields_to_save( $post, $attachment ) {

		if ( isset( $attachment['media_credit'] ) ) {
			update_post_meta( $post['ID'], '_media_credit', $attachment['media_credit'] );
		}

		if ( isset( $attachment['source_url'] ) ) {
			update_post_meta( $post['ID'], '_source_url', esc_url( $attachment['source_url'] ) );
		}

		return $post;
	}

}







