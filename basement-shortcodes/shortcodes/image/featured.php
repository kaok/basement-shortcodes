<?php
defined('ABSPATH') or die();

class Basement_Shortcode_Image_Featured extends Basement_Shortcode {

	public function section_config( $config = array() ) {
		$config = array(
			'description' => __( 'Print current featured image if possible', BASEMENT_SHORTCODES_TEXTDOMAIN ),
			'blocks' => array(
				array(
					'type' => 'toggler',
					'param' => 'circle',
					'title' => __( 'Circle', BASEMENT_SHORTCODES_TEXTDOMAIN ),
					'description' => __( 'Make image circle.', BASEMENT_SHORTCODES_TEXTDOMAIN )
				)
			)
		);

		return $config;

	}

	public function render( $atts = array(), $content = '' ) {
		global $post;

		$src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
		if ( $src && isset( $src[ 0 ] ) ) {
			$dom = new DOMDocument( '1.0', 'UTF-8' );
			$image = $dom->appendChild( $dom->createElement( 'img' ) );
			$image->setAttribute( 'src', $src[ 0 ] );
			if ( is_array( $atts ) && in_array( 'circle', $atts ) ) {
				$image->setAttribute( 'class', 'img-circle' );
			}
			return $dom->saveHTML();
		}
		return '';
	}
}
