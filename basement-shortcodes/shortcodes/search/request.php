<?php
defined('ABSPATH') or die();

class Basement_Shortcode_Search_Request extends Basement_Shortcode {

	public function section_config( $config = array() ) {
		$config = array(
			'description' => __( 'Print current search request if possible.', BASEMENT_SHORTCODES_TEXTDOMAIN )
		);

		return $config;
	}

	public function render( $atts = array(), $content = '' ) {
		return get_query_var( 's' );
	}

}
