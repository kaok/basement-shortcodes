<?php
defined('ABSPATH') or die();

class Basement_Shortcode_Author_Name extends Basement_Shortcode {

	public function section_config( $config = array() ) {
		$config = array(
			'description' => __( 'Print current author name if possible.', BASEMENT_SHORTCODES_TEXTDOMAIN )
		);

		return $config;
	}

	public function render( $atts = array(), $content = '' ) {
		return get_the_author();
	}

}
