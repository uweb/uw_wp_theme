<?php
/**
 * Shortcode for embedding tabs/tours style module
 *
 * Template:
 * [uw_tabs name="web name"]
 * [tabs_section title="section title"] content [/tabs_section]
 * [tabs_section title="section title"] content [/tabs_section]
 * [tabs_section title="section title"] content [/tabs_section]
 * [/uw_tabs]
 */
class UW_Tabs_Tours {
	/**
	 * Tabs constructor.
	 */
	public function __construct() {
		add_shortcode( 'uw_tabs', array( $this, 'tabs_tours_handler' ) );
		add_shortcode( 'tabs_section', array( $this, 'tabs_section_handler' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'uw_wp_theme_register_tabs_script' ) );
	}

	/**
	 * Register tabs JS.
	 *
	 * @return void
	 */
	public function uw_wp_theme_register_tabs_script() {
		$template_directory = get_bloginfo( 'template_directory' );
		$theme_version = wp_get_theme( get_template( ) )->get( 'Version' );

		wp_register_script( 'uw_wp_theme-tabs-script', $template_directory . '/js/shortcodes/tabs-tours.js', array( 'jquery', 'uw_wp_theme-bootstrap' ), $theme_version, true );
	}

	/**
	 * Tabs/tours handler.
	 *
	 * @param string $atts attributes from shortcode: name, style.
	 * @param string $content content from shortcode.
	 * @return string
	 * Inspiration from https://github.com/vinorodrigues/wp-bootstrap4/blob/master/plugins/inc/tabs.php
	 */
	public function tabs_tours_handler( $atts, $content = null ) {
		global $uw_tabs_tours;

		// only enqueue script when shortcode is present!
		wp_enqueue_script( 'uw_wp_theme-tabs-script' );

		if ( ! isset( $uw_tabs_tours ) ) {
			$uw_tabs_tours = array();
		}

		// if there are no nested tabs, stop here.
		if ( isset( $uw_tabs_tours['in_tabs'] ) && $uw_tabs_tours['in_tabs'] ) {
			return 'No content inside the tab element. Make sure your close your tab element. Required stucture: [uw_tabs][tabs_section title="section title"]content[/tabs_section][/uw_tabs]';
		}

		// get the number of tabs, increment for each one.
		if ( ! isset( $uw_tabs_tours['tabs_count'] ) ) {
			$uw_tabs_tours['tabs_count'] = 0;
		}
		$uw_tabs_tours['tabs_count']++; // this is always 0 or 1 now...

		$uw_tabs_tours['in_tabs'] = true;
		// get tab content.
		do_shortcode( $content );
		$uw_tabs_tours['in_tabs'] = false;

		// count the number of tabs.
		$count = isset( $uw_tabs_tours['tabs_content'] ) ?
			count( $uw_tabs_tours['tabs_content'] ) : 0;
		if ( 0 === $count ) {
			// if there is no content, display message.
			return 'No content inside the tab element. Make sure your close your tab element. Required stucture: [uw_tabs][tabs_section title="section title"]content[/tabs_section][/uw_tabs]';
		}

		// check for active tabs.
		$tab_active_item = isset( $uw_tabs_tours['tabs_active_item'] ) ?
			$uw_tabs_tours['tabs_active_item'] :
			0;
		unset( $uw_tabs_tours['tabs_active_item'] );  // clean up!

		// name and style are both optional flags.
		// style will be for optional style for each tab and tour.
		// default layout is tabs. set tour to true to enable tour layout.
		$tabs_atts = shortcode_atts(
			array(
				'name'  => '', // set the name for the tabs.
				'style' => '', // set the style for the tabs.
				'tour'  => false, // set the shortcode to tour. Default is false (tabs).
				'id'    => '', // optional ID.
			),
			$atts
		);

		// if id is set, use that. If not, check for name or use default.
		if ( $tabs_atts['id'] ) {
			$tabs_name = strtolower( $tabs_atts['id'] );
		} else {
			if ( empty( $tabs_atts['name'] ) ) {
				$tabs_name = 'tab-tour';
			} else {
				// otherwise, get the name from the atts.
				$tabs_name = strtolower( $tabs_atts['name'] );
			}

			// Make name alphanumeric (removes all other characters).
			$tabs_name = preg_replace( '/[^a-z0-9_\s-]/', '', $tabs_name );
			// Clean up multiple dashes or whitespaces in name.
			$tabs_name = preg_replace( '/[\s-]+/', ' ', $tabs_name );
			// Convert whitespaces and underscore to dash.
			$tabs_name = preg_replace( '/[\s_]/', '-', $tabs_name );

			// check if the $tabs_name starts with a number and if so, prepend tabs- so it doesn't start with a number (not allowed).
			if ( preg_match( '/^[0-9]+/', $tabs_name ) ) {
				$tabs_name = 'tabs-' . $tabs_name;
			}
		}

		$uw_tabs_tours['tabs_name'] = $tabs_name;

		// if we are doing a tour instead of a tab...
		if ( 'true' === $tabs_atts['tour'] ) {
			$tour_flag = true;
			$tour_class = ' vertical-tour';
		} else {
			$tour_flag = false;
			$tour_class = '';
		}

		if ( 'alt-tab' === $tabs_atts['style'] ) {
			$tab_style_class = ' alt-tab';
		} else {
			$tab_style_class = '';
		}

		ob_start();
		?>
		<div class="tab-tour <?php echo esc_attr( $tab_style_class ); ?><?php echo esc_attr( $tour_class ); ?>" id="tabs-tour-container">
		<div class="screen-reader-text"><?php echo esc_attr( $tabs_atts['name'] ); ?></div>
			<?php
			if ( $tour_flag ) {
				?>
				<div class="row">
					<div class="col-3">
				<?php
			}

			// Initialize an array to store the tab IDs
		$tab_ids = array();

		// for loop for each of the tab titles.
		$i = 0;
		foreach ($uw_tabs_tours['tabs_titles'] as $title) {
			$tid = $uw_tabs_tours['tabs_ids'][$i];
			$tid = preg_replace('![^0-9A-Za-z_]+!u', "-", $tid);
			// Store the $tid in the array
			$tab_ids[] = $tid;

			$i++;
		}
		// ** Define the ID to be used for the <ul> element
		$ul_id = !empty($tid) ? esc_attr($tabs_name). $tid : esc_attr($tabs_name);
			?>

			<ul class="nav <?php echo esc_attr( $tour_flag ? 'flex-column nav-pills' : 'nav-tabs' ); ?>" id="<?php echo esc_attr( $ul_id); ?>" role="tablist" <?php echo wp_kses_post( $tour_flag ? 'aria-orientation="vertical"' : '' ); ?><?php echo wp_kses_post( $tabs_atts['name'] ? 'aria-label="' . $tabs_atts['name'] . '"' : '' ); ?>>
			<?php
			// for loop for each of the tab titles.
			$i = 0;
			foreach ( $uw_tabs_tours['tabs_titles'] as $title ) {
				$tid = $uw_tabs_tours['tabs_ids'][ $i ];

				if ( ! $tid ) {
					$tid = $tabs_name . '-' . ( $i + 1 );
					$uw_tabs_tours['tabs_ids'][ $i ] = $tid;
				}
				if ( ! $title ) {
					$title = $tid;
					$uw_tabs_tours['tabs_titles'][ $i ] = $title;
				}

				if ( $i === $tab_active_item ) {
					$tab_class = ' active';
				} else {
					$tab_class = '';
				}
				$tid = preg_replace('![^0-9A-Za-z_]+!u', "-", $tid);
				?>
				<li class="nav-item" role="presentation"><button role="tab" class="nav-link<?php echo esc_attr( $tab_class ); ?>" type="button" id="title-<?php echo esc_attr( $tid ); ?>" data-toggle="tab" href="#<?php echo esc_attr( $tid ); ?>"  aria-controls="<?php echo esc_attr( $tid ); ?>" aria-selected="<?php echo esc_attr( '' === $tab_class ? 'false' : 'true' ); ?>" <?php echo wp_kses_post( $i === $tab_active_item ? '' : 'tabindex="-1"' ); ?>><?php echo esc_attr( $title ); ?></button></li>
				<?php
				$i++;
			}
			?>
			</ul>
			<?php
			if ( $tour_flag ) {
				// closing .col-3.
				?>
				</div>
				<div class="col-9">
			<?php } ?>
			<div class="tab-content" id="tab-content-<?php echo esc_attr( $tabs_name ); ?>">
			<?php
			// for loop for each of the tab contents.
			$i = 0;
			foreach ( $uw_tabs_tours['tabs_content'] as $content ) {
				$tid = $uw_tabs_tours['tabs_ids'][ $i ];
				$tid = preg_replace('![^0-9A-Za-z_]+!u', "-", $tid);
				if ( $i === $tab_active_item ) {
					$tab_class = ' active';
				} else {
					$tab_class = '';
				}

				?>
				<div class="tab-pane fade show<?php echo esc_attr( $tab_class ); ?>" id="<?php echo esc_attr( $tid ); ?>" role="tabpanel" aria-labelledby="title-<?php echo esc_attr( $tid ); ?>" tabindex="0"><?php echo wp_kses_post( $content ); ?></div><?php
				// running php tags and closed </div> together to make WP happy by making phpcs angry. this removes empty <p></p> tag!
				$i++;
			} ?></div>
			<?php
			if ( $tour_flag ) {
				// closing .col-9 and .row.
				?>
				</div>
				</div>
			<?php } ?>
		</div>

		<?php

		$uw_tabs_tours = array();

		return ob_get_clean();
	}

	/**
	 * Tabs section handler
	 *
	 * @param [type] $atts
	 * @param [type] $content
	 * @return void
	 */
	public function tabs_section_handler( $atts, $content = null ) {
		global $uw_tabs_tours;

		if ( ! isset( $uw_tabs_tours ) ) {
			return 'Something went wrong! Make sure your tabs look like this: [uw_tabs][tabs_section title="section title"]content[/tabs_section][/uw_tabs]';
		}

		$tabs_section_atts = shortcode_atts(
			array(
				'id'     => false,
				'title'  => '',
				'active' => false,
			),
			$atts
		);

		if ( ! isset( $uw_tabs_tours['tabs_titles'] ) ) {
			$uw_tabs_tours['tabs_titles'] = array();
		}
		if ( ! isset( $uw_tabs_tours['tabs_content'] ) ) {
			$uw_tabs_tours['tabs_content'] = array();
		}
		if ( ! isset( $uw_tabs_tours['tabs_ids'] ) ) {
			$uw_tabs_tours['tabs_ids'] = array();
		}

		if ( $tabs_section_atts['active'] ) {
			$uw_tabs_tours['tabs_active_item'] = count( $uw_tabs_tours['tabs_content'] );
		}

		$uw_tabs_tours['tabs_titles'][]  = $tabs_section_atts['title'];
		$uw_tabs_tours['tabs_content'][] = do_shortcode( $content );
		$uw_tabs_tours['tabs_ids'][]     = $tabs_section_atts['id'] ? $tabs_section_atts['id'] : null;

		return '';  // no output.

	}

}
