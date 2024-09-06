<?php

class UW_Sidebar
{

  const NAME          = 'Sidebar';
  const ID            = 'sidebar';
  const DESCRIPTION   = 'Right column widgets';
  const BEFORE_WIDGET = '<section aria-label="%2$s widget" id="%1$s" class="widget %2$s">';
  const AFTER_WIDGET  = '</section>';

  function __construct() {
    add_action( 'widgets_init', array( $this, 'register_sidebar' ) );
  }

  function register_sidebar() {
    register_sidebar(array(
      'name'          => esc_html__( self::NAME, 'uw_wp_theme' ),
      'id'            => self::ID,
      'description'   => esc_html__( self::DESCRIPTION, 'uw_wp_theme' ),
      'before_widget' => self::BEFORE_WIDGET,
      'after_widget'  => self::AFTER_WIDGET,
      'before_title'  => '<h4 class="widget-title">',
      'after_title'   => '</h4><span class="udub-slant-divider gold"><span></span></span>',
    ));
  }

}

new UW_Sidebar;
