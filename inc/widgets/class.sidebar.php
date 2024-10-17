<?php

class UW_Sidebar
{

  const NAME          = 'Sidebar';
  const ID            = 'sidebar';
  const DESCRIPTION   = 'Right column widgets';
  const BEFORE_WIDGET = '<section aria-label="%2$s" id="%1$s" class="widget %2$s">';
  const AFTER_WIDGET  = '</section>';

  function __construct() {
    add_action( 'widgets_init', array( $this, 'register_sidebar' ) );
	add_action( 'wp_enqueue_scripts', array($this, 'uw_wp_theme_enqueue_sidebar_widgets_script' ) );
  }

  	/**
	 * Load sidebar menu JS.
	 */
	function uw_wp_theme_enqueue_sidebar_widgets_script() {
		$template_directory = get_bloginfo( 'template_directory' );
		$theme_version = wp_get_theme( get_template( ) )->get( 'Version' );

		wp_register_script( 'uw_wp_theme-sidebar-widgets-script', $template_directory . '/js/sidebar-widgets.js', array( 'jquery', 'uw_wp_theme-bootstrap' ), $theme_version, true );
	}

  function register_sidebar() {
    register_sidebar(array(
      'name'          => esc_html__( self::NAME, 'uw_wp_theme' ),
      'id'            => self::ID,
      'description'   => esc_html__( self::DESCRIPTION, 'uw_wp_theme' ),
      'before_widget' => self::BEFORE_WIDGET,
      'after_widget'  => self::AFTER_WIDGET,
      'before_title'  => '<h2 class="widget-title h4">',
      'after_title'   => '</h2><span class="udub-slant-divider gold"><span></span></span>',
    ));
  }
}

new UW_Sidebar;
