<?php
defined('ABSPATH') or die();

class Basement_Shortcode_Taxonomy_Name extends Basement_Shortcode {

	public function section_config( $config = array() ) {
		$config = array(
			'description' => __( 'Print current taxonomy name if possible.', BASEMENT_SHORTCODES_TEXTDOMAIN )
		);

		return $config;
	}

	public function render( $atts = array(), $content = '' ) {
		$queried_object = get_queried_object();
		if ( is_object( $queried_object ) && property_exists( $queried_object, 'name' ) ) {
			return $queried_object->name;
		}
		return '';
	}

}
