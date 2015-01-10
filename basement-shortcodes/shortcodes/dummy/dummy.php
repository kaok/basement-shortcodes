<?php
defined('ABSPATH') or die();

class Basement_Shortcode_Dummy extends Basement_Shortcode {

	protected function panel_markup_dom( $container ) {
		// Filter: basement_shortcode_dummy_{ $this->tag }_markup
		$container = apply_filters( $this->textdomain . '_dummy_' . $this->tag . '_markup', $container, $this->tag );
	}

	public function render( $atts = array(), $content = '' ) {
		// Filter: basement_shortcode_render_dummy_{ $this->tag }_markup
		return apply_filters( $this->textdomain . '_render_dummy_' . $this->tag . '_markup', $content, $atts  );
	}
}