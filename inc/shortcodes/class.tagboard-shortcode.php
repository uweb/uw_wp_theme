<?php

/**
 * UW Tagboard shortcode.
 * Embeds a Tagboard feed onto the page.
 *
 * Structure: [tagboard id="435487"]
 *
 *
 */

class UW_Tagboard
{
  function __construct()
  {
    add_shortcode('tagboard', array($this, 'tagboard_handler'));
  }

  function tagboard_handler( $atts )
  {
    $tagboard_atts = shortcode_atts( array(
      'id' => ''
    ), $atts);
    if ($tagboard_atts['id'] == '') {
      return '<div>Missing parameter: Tagboard embed id</div>';
    } else {
      return sprintf('<div class="tagboard-embed" tgb-embed-id="%s"></div>

                    <script src="https://static.tagboard.com/embed/assets/js/embed.js"></script>', $tagboard_atts['id']);
    }
  }
}
?>
