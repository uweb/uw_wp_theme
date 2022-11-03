<?php
/**
 * A widget to add a banner at the top of each page.
 *
 */
class UW_Widget_Area{

	const NAME          = 'UW Widget Area';
	const ID            = 'uw-widget-area';
	const DESCRIPTION   = 'Widget area at the top of a page. Use the "UW Sitewide Banner" only';
	const BEFORE_WIDGET = '<span role="complementary" aria-label="banner HELLO?" id="%1$s" class="widget %2$s">';
	const AFTER_WIDGET  = '</span>';

	function __construct() {
		add_action( 'widgets_init', array( $this, 'register_sidebar' ) );
	}


	function register_sidebar() {
		register_sidebar(
			array(
				'name'          => esc_html__( self::NAME, 'uw_wp_theme' ),
				'id'            => self::ID,
				'description'   => esc_html__( self::DESCRIPTION, 'uw_wp_theme' ),
				'before_widget' => self::BEFORE_WIDGET,
				'after_widget'  => self::AFTER_WIDGET,
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4><span class="udub-slant-divider gold"><span></span></span>',
			)
		);
	}

}


new UW_Widget_Area;
