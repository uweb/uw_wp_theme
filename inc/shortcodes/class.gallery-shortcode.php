<?php
/**
 * Shortcode for overriding the WordPress gallery to use Bootstrap carousel module
 *
 * Template:
 * [gallery size="full" uw_carousel="true" uw_carousel_fullwidth="false" uw_carousel_captions="true" columns="1" ids="comma_separated_ids_of_photos" orderby=""]
 */
class UW_Gallery {

	/**
	 * Gallery/Carousel constructor.
	 */
	public function __construct() {

		add_action( 'print_media_templates', array( $this, 'gallery_carousel_admin' ) );

		// Remove built-in shortcode.
		remove_shortcode( 'gallery', 'gallery_shortcode' );
		// add our version of the shortcode.
		add_shortcode( 'gallery', array( $this, 'uw_gallery_handler' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_gallery_script' ) );

	}

	/**
	 * Load gallery JS.
	 *
	 * @return void
	 */
	public function enqueue_gallery_script() {

		wp_enqueue_script( 'uw-gallery-script', get_bloginfo( 'template_directory' ) . '/js/shortcodes/gallery.js', array( 'jquery', 'uw_wp_theme-bootstrap' ), wp_get_theme( get_template( ) )->get( 'Version' ), true );

	}

	/**
	 * Add Carousel option to WP Gallery.
	 * https://wordpress.org/support/topic/how-to-add-fields-to-gallery-settings/
	 */
	public function gallery_carousel_admin() {
		?>
		<script type="text/html" id="tmpl-uw-gallery-setting">
			<label class="setting">
				<span>Masonry layout</span>
				<input type="checkbox" data-setting="uw_photo_masonry" />
			</label>
			<label class="setting">
				<span>Disable space between images</span>
				<input type="checkbox" data-setting="uw_photo_grid_gap" />
			</label>
			<label class="setting">
				<span>Enable simple captions</span>
				<input type="checkbox" data-setting="uw_carousel_captions" />
			</label><br />

			<h3 style="clear:both;">Carousel settings</h3>
			<span><em>Note: Link To, Columns, and "Disable space between images" from above are not used for carousel settings.</em></span>
			<label class="setting">
				<span>Enable carousel</span>
				<input type="checkbox" data-setting="uw_carousel" />
			</label>
			<label class="setting">
				<span>Enable full-width</span>
				<input type="checkbox" data-setting="uw_carousel_fullwidth" />
			</label>
		</script>

		<script>
			jQuery(document).ready(function(){

				// add your shortcode attribute and its default value to the
				// gallery settings list; $.extend should work as well...
				_.extend(wp.media.galleryDefaults, {
					uw_carousel: '',
					uw_carousel_fullwidth: '',
					uw_carousel_captions: '',
					uw_photo_grid_gap: '',
					uw_photo_masonry: ''
				});

				// merge default gallery settings template with yours
				wp.media.view.Settings.Gallery = wp.media.view.Settings.Gallery.extend({
					template: function(view){
						return wp.media.template('gallery-settings')(view) + wp.media.template('uw-gallery-setting')(view);
					}
				});
			});
		</script>
		<?php
	}

	/**
	 * Gallery/Carousel shortcode.
	 *
	 * @param [type] $attr
	 * @return void
	 * started from https://wordpress.stackexchange.com/questions/145377/rewriting-wordpress-gallery-shortcode-with-bootstrap-carousel
	 */
	public function uw_gallery_handler( $attr, $content = null ) {
		$post = get_post();

		// increment for each carousel on the page.
		static $instance = 0;
		$instance++;

		// get the attachment ids for the gallery/carousel.
		if ( ! empty( $attr['ids'] ) ) {
			if ( empty( $attr['orderby'] ) ) {
				$attr['orderby'] = 'post__in';
			}
			$attr['include'] = $attr['ids'];
		}

		$output = apply_filters( 'post_gallery', '', $attr );

		// if no output, we're done here.
		if ( '' !== $output ) {
			return $output;
		}

		// get orderby setting.
		if ( isset( $attr['orderby'] ) ) {
			$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
			if ( ! $attr['orderby'] ) {
				unset( $attr['orderby'] );
			}
		}

		// get carousel setting.
		if ( isset( $attr['uw_carousel'] ) ) {
			if ( 'true' === $attr['uw_carousel'] ) {
				$uw_carousel = true;
			} else {
				$uw_carousel = false;
			}
		} else {
			$uw_carousel = false;
		}

		// get settings for full-width (default is content-width).
		if ( isset( $attr['uw_carousel_fullwidth'] ) ) {
			if ( 'true' === $attr['uw_carousel_fullwidth'] ) {
				$fullwidth = true;
				$fullwidth_class = ' full-width';
			} else {
				$fullwidth = false;
				$fullwidth_class = '';
			}
		} else {
			$fullwidth = false;
			$fullwidth_class = '';
		}

		// get settings for simple captions (default is branded).
		if ( isset( $attr['uw_carousel_captions'] ) ) {
			if ( 'true' === $attr['uw_carousel_captions'] ) {
				$simple_captions = true;
				$captions_class = ' captions-simple';
			} else {
				$simple_captions = false;
				$captions_class = '';
			}
		} else {
			$simple_captions = false;
			$captions_class = '';
		}

		// get setting for disabling grid gap for gallery/grid.
		if ( isset( $attr['uw_photo_grid_gap'] ) ) {
			if ( 'true' === $attr['uw_photo_grid_gap'] ) {
				$grid_gap = true;
				$grid_gap_class = ' grid-gap-off';
			} else {
				$grid_gap = false;
				$grid_gap_class = '';
			}
		} else {
			$grid_gap = false;
			$grid_gap_class = '';
		}

		// get setting for turning on masonry layout for gallery/grid.
		if ( isset( $attr['uw_photo_masonry'] ) ) {
			if ( 'true' === $attr['uw_photo_masonry'] ) {
				$masonry = true;
				$masonry_class = ' gallery-masonry';
			} else {
				$masonry = false;
				$masonry_class = '';
			}
		} else {
			$masonry = false;
			$masonry_class = '';
		}

		// gallery/photo grid: get number of columns and set the grid column class based on that.
		if ( isset( $attr['columns'] ) ) {
			switch ( $attr['columns'] ) {
				case '1':
					$gallery_attr['columns'] = '1';
					$grid_columns_class = ' one-col';
					break;
				case '2':
					$gallery_attr['columns'] = '2';
					$grid_columns_class = ' two-col';
					break;
				case '4':
					$gallery_attr['columns'] = '4';
					$grid_columns_class = ' four-col';
					break;
				case '5':
					$gallery_attr['columns'] = '5';
					$grid_columns_class = ' five-col';
					break;
				case '6':
					$gallery_attr['columns'] = '6';
					$grid_columns_class = ' six-col';
					break;
				case '7':
					$gallery_attr['columns'] = '7';
					$grid_columns_class = ' seven-col';
					break;
				case '8':
					$gallery_attr['columns'] = '8';
					$grid_columns_class = ' eight-col';
					break;
				case '9':
					$gallery_attr['columns'] = '9';
					$grid_columns_class = ' nine-col';
					break;
				default:
					$gallery_attr['columns'] = '3';
					$grid_columns_class = ' three-col';
					break;
			}
		} else {
			$grid_columns = '3'; // default.
			$grid_columns_class = ' three-col';
		}

		// some internal shortcoding.
		$gallery_attr = shortcode_atts(
			array(
				'order'      => 'ASC',
				'orderby'    => 'menu_order ID',
				'id'         => $post->ID,
				'itemtag'    => '',
				'icontag'    => '',
				'captiontag' => '',
				'columns'    => 3,
				'size'       => 'thumbnail',
				'include'    => '',
				'link'       => '',
				'exclude'    => '',
			),
			$attr
		);

		// get the ID from the page for the carousel.
		$id = intval( $gallery_attr['id'] );

		if ( isset( $attr['order'] ) ) {
			if ( 'RAND' === $attr['order'] ) {
				$gallery_attr['orderby'] = 'none';
			}
		}

		if ( ! empty( $gallery_attr['include'] ) ) {
			$_attachments = get_posts(
				array(
					'include'        => $gallery_attr['include'],
					'post_status'    => 'inherit',
					'post_type'      => 'attachment',
					'post_mime_type' => 'image',
					'order'          => $gallery_attr['order'],
					'orderby'        => $gallery_attr['orderby'],
				)
			);

			$attachments = array();
			foreach ( $_attachments as $key => $val ) {
				$attachments[ $val->ID ] = $_attachments[ $key ];
			}
		} elseif ( ! empty( $exclude ) ) {
			$attachments = get_children(
				array(
					'post_parent'    => $id,
					'exclude'        => $exclude,
					'post_status'    => 'inherit',
					'post_type'      => 'attachment',
					'post_mime_type' => 'image',
					'order'          => $gallery_attr['order'],
					'orderby'        => $gallery_attr['orderby'],
				)
			);
		} else {
			$attachments = get_children(
				array(
					'post_parent'    => $id,
					'post_status'    => 'inherit',
					'post_type'      => 'attachment',
					'post_mime_type' => 'image',
					'order'          => $gallery_attr['order'],
					'orderby'        => $gallery_attr['orderby'],
				)
			);
		}

		if ( empty( $attachments ) ) {
			return '';
		}

		if ( is_feed() ) {
			$output = "\n";
			foreach ( $attachments as $att_id => $attachment ) {
				$output .= wp_get_attachment_link( $att_id, $size, true ) . "\n";
			}
			return $output;
		}

		// Bootstrap Output Begins Here.
		// Bootstrap needs a unique carousel id to work properly so we are adding $instance to each ID to make it unique.
		if ( $uw_carousel ) {
			$output .= '<div id="carousel-' . $id . '-' . $instance . '" class="carousel slide' . $fullwidth_class . $captions_class . '" data-ride="carousel" data-interval="false" role="region" aria-label="manual image" aria-roledescription="carousel" aria-live="polite">';
			$output .= '<div class="carousel-inner">';

			// Begin counting slides to set the first one as the active class.
			$slidecount = 1;
			foreach ( $attachments as $imgid => $attachment ) {
				$link = isset( $gallery_attr['link'] ) && 'file' === $gallery_attr['link'] ? wp_get_attachment_link( $imgid, $gallery_attr['size'], false, false ) : wp_get_attachment_link( $imgid, $gallery_attr['size'], true, false );

				// get image data.
				$image_src_url = wp_get_attachment_image_src( $imgid, $gallery_attr['size'] );
				$image_src_alt = get_post_meta( $imgid, '_wp_attachment_image_alt', true );
				$image_caption = wp_get_attachment_caption( $imgid );
				$credit = get_post_meta( $imgid, '_media_credit', true );
				$source_url = get_post_meta( $imgid, "_source_url", true );


				if ( 1 === $slidecount ) {
					$output .= '<figure class="carousel-item active" aria-roledescription="slide" aria-label="' . $image_src_alt . '">';
				} else {
					$output .= '<figure class="carousel-item" aria-roledescription="slide" aria-label="' . $image_src_alt . '">';
				}

				$output .= '<img src="' . $image_src_url[0] . '" class="d-block w-100" alt="' . $image_src_alt . '">';

				if ( $source_url != '' ) {
					$credit = '<a href="'. ( $source_url ) .'">'. $credit .'</a>';
				} else {
					$credit = ( $source_url ) . $credit ;
				}
				if ( $credit ) $credit = ' <span class="wp-media-credit">Photo: '. $credit . '</span>';

				// if a caption is set, output it.
				if ( $image_caption || $credit ) {
					$output .= '<figcaption class="carousel-caption d-none d-sm-block w-40"><p>' . wp_kses_post( $image_caption ) .  $credit . '</p></figcaption>';
				}

				$output .= '</figure>';

				$slidecount++;
			}

			$output .= '</div>';
			// Prev and Next buttons.
			$output .= '<button class="carousel-control-prev" href="#carousel-' . $id . '-' . $instance . '" type="button" data-slide="prev">';
			$output .= '<span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="sr-only">Previous image</span>';
			$output .= '</button>';
			$output .= '<button class="carousel-control-next" href="#carousel-' . $id . '-' . $instance . '" type="button" data-slide="next">';
			$output .= '<span class="carousel-control-next-icon" aria-hidden="true"></span><span class="sr-only">Next image</span>';
			$output .= '</button>';
			$output .= '</div>';

			return $output;
		} else {

			// if carousel is not checked we want to revert to a responsive photo grid.
			$output .= '<div id="photo-grid-' . $instance . '" class="photo-grid' . $grid_columns_class . $grid_gap_class . $masonry_class . '" tabindex="0">';

			// if linking to the image file, we want it to pop up in our modal, so let's set that up.
			if ( isset( $attr['link'] ) ) {
				if ( 'file' === $attr['link'] ) {
					// use modal for images.
					foreach ( $attachments as $att_id => $attachment ) {
						$image_src_url = wp_get_attachment_image_src( $att_id, $gallery_attr['size'] );
						$image_src_alt = get_post_meta( $att_id, '_wp_attachment_image_alt', true );
						$image_caption = wp_get_attachment_caption( $att_id );
						$credit = get_post_meta( $att_id, '_media_credit', true );
						$source_url = get_post_meta( $att_id, "_source_url", true );


						$output .= '<a href="#" data-toggle="modal" data-target="#photoGridModal"><img class="gallery-img" src="' . $image_src_url[0] . '" alt="' . $image_src_alt . '" data-image="' . $image_src_url[0] . '" data-caption="' . $image_caption . '" data-credit="' . $credit . '" data-source="' . $source_url . '"></a>';

					}

					// output the modal code.
					$output .= '<div class="modal fade" id="photoGridModal" tabindex="-1" role="dialog" aria-hidden="true"><div class="modal-dialog modal-dialog-centered w-90" role="document"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"></div></div></div></div>';

				} elseif ( 'none' === $attr['link'] ) {
					// just show the image on the page.
					foreach ( $attachments as $att_id => $attachment ) {
						$image_src_url = wp_get_attachment_image_src( $att_id, $gallery_attr['size'] );
						$image_src_alt = get_post_meta( $att_id, '_wp_attachment_image_alt', true );
						// Display the caption below the image if available.
						if ( isset( $attr['uw_carousel_captions'] ) ) {
							if ( 'true' === $attr['uw_carousel_captions'] ) {
								$image_caption = wp_get_attachment_caption( $att_id );
							} else {
								$image_caption = '';
							}
						}

						// Add an image container div for positioning.
						$output .= '<figure class="photo-container" tabindex="0">';
						// Add the caption overlay.

							$output .= '<img id="gallery-img-' . $att_id . '" src="' . $image_src_url[0] . '" data-caption=" ' . $image_caption . ' " alt="' . $image_src_alt . '">';
							$output .= '<figcaption class="caption-overlay">' . esc_html( $image_caption ) . '</figcaption>';

						// Close the photo container div.
						$output .= '</figure>';



					}
				} else {
					// link to the image attachment page.
					foreach ( $attachments as $att_id => $attachment ) {
						$output .= wp_get_attachment_link( $att_id, $gallery_attr['size'], true );
					}
				}
			} else {
				// if not set, link to attachment page (default).
				foreach ( $attachments as $att_id => $attachment ) {
					$output .= wp_get_attachment_link( $att_id, $gallery_attr['size'], true );

				}
			}

			$output .= '</div>'; // close .photo-grid.

			return $output;
		}
	}
}
