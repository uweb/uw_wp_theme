<?php

/**
 * This shortcode allows iFrames for editors.
 * [iframe src='' width='' height='']
 */
class UW_Iframes
{

  function __construct()
  {
    add_shortcode( 'iframe', array( $this, 'add_iframe' ) );
  }

  function add_iframe($atts)
  {

      $params = shortcode_atts( array(
        'src' => '',
        'height' => get_option('embed_size_h'),
        'width' => get_option('embed_size_w')
      ), $atts );

      $params['src'] = esc_url($params['src'], array('http','https'));
      if ( $params['src'] == '' )
        return '';

      $parsed = parse_url($params['src']);

	  /**
	   * Remove the require iFrame allow list unless the CMS_Iframes class exists.
	   */
	  if ( class_exists( 'CMS_Iframes' ) ) {

		if ( array_key_exists( 'host', $parsed ) && !in_array( $parsed['host'], $this->get_iframe_domains() ) )
		  return '';
	}

      $iframeSrc = html_entity_decode($params['src']);
      $iframeQueryString = parse_url($iframeSrc, PHP_URL_QUERY);
      $parentQueryString = http_build_query($_GET);

      if($iframeQueryString != '' && $parentQueryString != '')
      {
        $iframeQuery = parse_str($iframeQueryString, $iframeQueryParams);
        $parentQuery = parse_str($parentQueryString, $parentQueryParams);
        $query_merged = array_merge($iframeQueryParams, $parentQueryParams);
        $iframeSrc = str_replace($iframeQueryString, http_build_query($query_merged), $iframeSrc);
      }
      else if ($parentQueryString != '')
      {
        $iframeSrc .= "?" . $parentQueryString;
      }

      $iframeSrc = esc_url($iframeSrc, array('http', 'https'));

      return "<iframe src=\"$iframeSrc\" width=\"{$params['width']}\" height=\"{$params['height']}\" style=\"border:0\"></iframe>";
  }

}
