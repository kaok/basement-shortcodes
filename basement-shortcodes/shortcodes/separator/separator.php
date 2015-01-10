<?php
defined('ABSPATH') or die();

class Basement_Shortcode_Separator extends Basement_Shortcode {

	public function section_config( $config = array() ) {

		$config = array(
			'description' => __( 'Creates transparent separator with certain height.', BASEMENT_SHORTCODES_TEXTDOMAIN ),
			'blocks' => array(
				array(
					'title' => __( 'Height', BASEMENT_SHORTCODES_TEXTDOMAIN ),
					'description' => __( 'Sets separator height in pixels. Use integer value without "px".', BASEMENT_SHORTCODES_TEXTDOMAIN ),
					'param' => 'height'
				)
			)
		);

		return $config;

	}


	public function render( $atts = array(), $content = '' ) {
		extract( $atts = wp_parse_args( $atts, array(
			'height' => '10'
		) ) );

		$dom = new DOMDocument( '1.0', 'UTF-8' );
		$separator = $dom->appendChild( $dom->createElement( 'div' ) );
		$separator->setAttribute( 'style', 'width: 100%; height: ' . (int)$height . 'px;' );
		
		return $dom->saveHTML();
	}
}
