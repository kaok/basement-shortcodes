<?php
defined('ABSPATH') or die();

class Basement_Shortcode_Link extends Basement_Shortcode {
	protected $enclosing = true;

	public function section_config( $config = array() ) {

		$config = array(
			'description' => __( 'Link is not very useful shortcode for WordPress editor, but it can help in widget contents to create a simple link.', 'domain' ),
			'blocks' => array(
				array(
					'type' => 'content',
					'title' => __( 'Text', BASEMENT_SHORTCODES_TEXTDOMAIN ),
					'description' => __( 'Link text user will see.', BASEMENT_SHORTCODES_TEXTDOMAIN ),
					'inputs' => array(
						array(
							'type' => 'text',
						)
					)
				),
				array(
					'type' => 'text',
					'title' => __( 'URL', BASEMENT_SHORTCODES_TEXTDOMAIN ),
					'description' => __( 'URL address of link.', BASEMENT_SHORTCODES_TEXTDOMAIN ),
					'param' => 'link',
					'inputs' => array(
						array(
							'type' => 'text',
						)
					)
				),
				array(
					'type' => 'toggler',
					'param' => 'mail',
					'title' => __( 'To email', BASEMENT_SHORTCODES_TEXTDOMAIN ),
					'description' => __( 'Sets if this link should open mail software to create an email.', BASEMENT_SHORTCODES_TEXTDOMAIN ),
					'inputs' => array(
						array(
							'type' => 'checkbox'
						)
					)
				),
				array(
					'type' => 'toggler',
					'param' => 'newwindow',
					'title' => __( 'New window', BASEMENT_SHORTCODES_TEXTDOMAIN ),
					'description' => __( 'Makes link to be opened in new browser window/tab', BASEMENT_SHORTCODES_TEXTDOMAIN ),
					'inputs' => array(
						array(
							'type' => 'checkbox'
						)
					)
				)
			)
		);

		return $config;
		
	}

	public function render( $atts = array(), $content = '' ) {
		extract( $atts = wp_parse_args( $atts, array(
			'link' => '#'
		) ) );

		$dom = new DOMDocument( '1.0', 'UTF-8' );
		if ( !$content ) {
			$content = $link;
		}

		// Filter: basement_shortcode_render_link_{ $this->name }_container
		$container = apply_filters( $this->textdomain . '_render_link_' . $this->name . '_container', $dom );
		$a = $container->appendChild( $dom->createElement( 'a', $content ) );
		if ( in_array( 'mail', $atts ) ) {
			$link = 'mailto:' . $link;
		}
		$a->setAttribute( 'href', $link );
		if ( in_array( 'newwindow', $atts ) ) {
			$a->setAttribute( 'target', '_blank' );
		}
		return $dom->saveHTML();
	}
}
