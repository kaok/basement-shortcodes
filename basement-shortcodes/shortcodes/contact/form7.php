<?php
defined('ABSPATH') or die();

class Basement_Shortcode_Contact_Form7 extends Basement_Shortcode {

	protected $override = false;

	public function section_config( $config = array() ) {

		if ( !post_type_exists( 'wpcf7_contact_form' ) ) {
			// TODO: make errors notifying
			return $config;
		}

		// TODO: replace with Shortcodes function to get items
		$items = get_posts(array(
			'post_type' => 'wpcf7_contact_form',
			'posts_per_page' => -1
		));

		if ( count( $items ) ) {
			$post_type_object = get_post_type_object( 'wpcf7_contact_form' );
			$config = array(
				'description' => __( 'Renders Contact Form 7 form if according plugin is installed.', BASEMENT_SHORTCODES_TEXTDOMAIN ),
				'blocks' => array(
					array(
						'title' => __( 'Forms', BASEMENT_SHORTCODES_TEXTDOMAIN ),
						'description' => __( 'Click on squares to choose Contact form you want to display.', BASEMENT_SHORTCODES_TEXTDOMAIN ),
						'type' => 'posts',
						'param' => 'id',
						'input' => array(
							'posts' => $items,
							// TODO: is no_hidden need?
							'no_hidden' => true,
							// TODO: if one element set current_value
						)
					)
				)
			);
		}
		
		return $config;
	}

}