<?php

/**
 * UW Tile Box Shortcode.
 * boxes contain tiles. boxes support only tiles inside and only between 1 and 12 tiles.
 *
 * structure: [box][tile]tile 1 content[/tile][tile]tile 2 content[/tile][/box]
 */

class UW_TileBox
{
	const MAXTILES = 12;
	private $count = 0;
	private $NumbersArray = array('zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven', 'twelve'); //arrays can't be constants in PHP.  Privates at least can't be changed

	function __construct()
	{
		add_shortcode( 'box', array( $this, 'box_handler' ) );
		add_shortcode( 'tile', array( $this, 'tile_handler' ) );
	}

	function box_handler( $atts, $content )
	{
		$boxCenter = shortcode_atts( array(
			'alignment' => 'none',
			'color' => '',
			'padding' => '',
			'shadow' => '',
			'custom' => ''
		), $atts );

		$color = '';
		if ( !empty($boxCenter['color'] ) ) {
			$color = ' box-' . $boxCenter['color'];
		};

		$padding = '';
		if ( !empty($boxCenter['padding'] ) ) {
			$padding = ' nopad';
		};

		$shadow = '';
		if ( !empty( $boxCenter['shadow'] ) ) {
			$shadow = ' noshadow';
		};

		$custom = '';
		if ( !empty( $boxCenter['custom'] ) ) {
			$custom = $boxCenter['custom'];
		};

		$center = 'box-' . $boxCenter['alignment'];

		$this->count = 0;

		if ( empty( $content ) )
			return 'No content inside the box element. Make sure your close your box element. Required stucture: [box][tile]content[/tile][/box]';

		$output = do_shortcode( $content );
		return sprintf( '<div class="box-outer"><div class="box %s %s%s%s%s%s">%s</div></div>', $this->NumbersArray[$this->count], $center, $color, $padding, $shadow, $custom, $output);
	}

	function tile_handler( $atts, $content )
	{
		$this->count++;
		$tile_atts = shortcode_atts( array(
			'empty' => 'false',
		), $atts );

		$classes = 'tile';

		if ( $this->count > self::MAXTILES ) {
			$content = 'Too many [tile]s.  Only up 12 are supported)';
		}

		if ( filter_var( $tile_atts['empty'], FILTER_VALIDATE_BOOLEAN ) ) {
			$classes = $classes . ' empty';
		}
		else if ( empty( $content ) ){
			$content = 'No content for this tile.  Make sure you wrap your content like this: [tile]Content here[/tile]';
		}

		return sprintf( '<div class="%s">%s</div>', $classes, apply_filters( 'the_content', $content ) );
	}
}
