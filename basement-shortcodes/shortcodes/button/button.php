<?php
defined('ABSPATH') or die();

/**
 * Params:
 * hide_colors | hide button colors
 * hide_styles | hide button styles
 */

class Basement_Shortcode_Button extends Basement_Shortcode {
	protected $enclosing = true;

	public function section_config( $config = array() ) {

		$config = array(
			'description' => 'Creates a simple button.',
			'blocks' => array(
				array(
					'type' => 'content',
					'title' => __( 'Text', BASEMENT_SHORTCODES_TEXTDOMAIN ),
					'description' => __( 'Text to display on button', BASEMENT_SHORTCODES_TEXTDOMAIN )
				),
				array(
					'title' => __( 'Link', BASEMENT_SHORTCODES_TEXTDOMAIN ),
					'description' => __( 'URL address to use for button link.', BASEMENT_SHORTCODES_TEXTDOMAIN ),
					'param' => 'link'
				)
			)
		);

		// Filter: basement_shortcode_button_{ $this->name }_after_link
		$config = apply_filters( $this->textdomain . '_button_' . $this->name . '_after_link_config', $config, $this->params );

		if ( empty( $this->params[ 'hide_styles' ] ) || !$this->params[ 'hide_styles' ] ) {
			$config[ 'blocks' ][] = array(
				'type' => 'radio',
				'title' => __( 'Style', BASEMENT_SHORTCODES_TEXTDOMAIN ),
				'description' => __( 'Sets button style.', BASEMENT_SHORTCODES_TEXTDOMAIN ),
				'param' => 'style',
				'input' => array(
					'type' => 'radios',
					'name' => $this->name . '_style',
					'values' => array(
						'0' => __( 'Solid color button', BASEMENT_SHORTCODES_TEXTDOMAIN ),
						'border' => __( 'Border transparent button', BASEMENT_SHORTCODES_TEXTDOMAIN )
					),
					'current_value' => '0'
				)
			);
		}

		if ( empty( $this->params[ 'hide_colors' ] ) || !$this->params[ 'hide_colors' ] ) {
			$config[ 'blocks' ][] = array(
				'type' => 'colorpicker',
				'title' => __( 'Main color', BASEMENT_SHORTCODES_TEXTDOMAIN ),
				'description' => __( 'A color used for current button border and background. Depends on selected style.', BASEMENT_SHORTCODES_TEXTDOMAIN ),
				'param' => 'color'
			);

			$config[ 'blocks' ][] = array(
				'type' => 'colorpicker',
				'title' => __( 'Main hover color', BASEMENT_SHORTCODES_TEXTDOMAIN ),
				'description' => __( 'Sets color of border and background on hover. Depends on selected style.', BASEMENT_SHORTCODES_TEXTDOMAIN ),
				'param' => 'color_hover'
			);

			$config[ 'blocks' ][] = array(
				'type' => 'colorpicker',
				'title' => __( 'Text color', BASEMENT_SHORTCODES_TEXTDOMAIN ),
				'description' => __( 'Sets text color of current button.', BASEMENT_SHORTCODES_TEXTDOMAIN ),
				'param' => 'text_color'
			);

			$config[ 'blocks' ][] = array(
				'type' => 'colorpicker',
				'title' => __( 'Text hover color', BASEMENT_SHORTCODES_TEXTDOMAIN ),
				'description' => __( 'Sets text color on hover.', BASEMENT_SHORTCODES_TEXTDOMAIN ),
				'param' => 'text_color_hover'
			);

		}

		return $config;

	}

	public function render( $atts = array(), $content = '' ) {
		extract( $atts = wp_parse_args( $atts, array(
			'link' => '#',
			'style' => '',
			'color' => '',
			'color_hover' => '',
			'text_color' => '',
			'text_color_hover' => ''
		) ) );

		$dom = new DOMDocument( '1.0', 'UTF-8' );
		$button = $dom->appendChild( $dom->createElement( 'a', $content ) );
		$button_classes = array( 'btn' );

		if ( $style === 'border') {
			$button_classes[] = 'btn-info';
		} else if ( empty( $style ) ) {
			$button_classes[] = 'btn-default';
		}

		// Filter: basement_shortcode_render_button_{ $this->name }_classes
		$button_classes = apply_filters( $this->textdomain . '_render_button_' . $this->name . '_classes', $button_classes, $atts );
		
		$button->setAttribute( 'class', implode( ' ', array_unique( $button_classes ) ) );
		$button->setAttribute( 'href', $link );

		$css = '';
		if ( $color || $color_hover || $text_color || $text_color_hover ) {
			$default_color_style = '';
			$hover_color_style = '';

			if ( $color ) {
				$default_color_style .= ( $style ? 'border-color' : 'background-color' ) . ':' . $color . ';';
			}

			if ( $color_hover ) {
				if ( $style ) {
					$hover_color_style .= 'border-color:' . $color_hover . ';';
					$hover_color_style .= 'border-color:' . $color_hover . ';';
				}
				$hover_color_style .= 'background-color:' . $color_hover . ';';

			}

			if ( $text_color ) {
				$default_color_style .= 'color:' . $text_color . ';';
			}

			if ( $text_color_hover ) {
				$hover_color_style .= 'color:' . $text_color_hover . ';';
			}

			$selector = 'button_' . mt_rand() * mt_rand();

			if ( $default_color_style ) {
				$css .= '#' . $selector . '{' . $default_color_style . '}';
			}

			if ( $hover_color_style ) {
				$css .= '#' . $selector . ':hover{' . $hover_color_style . '}';
			}

			if ( $css ) {
				$dom->appendChild( $dom->createElement( 'style', '#' . $selector . '_style' ) );
				$button->setAttribute( 'id', $selector );
			}

		}
		return $css ? str_replace( '#' . $selector . '_style', $css, $dom->saveHTML() ) : $dom->saveHTML();
	}
}
