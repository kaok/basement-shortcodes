<?php

defined('ABSPATH') or die();

class Shortcode_Group {

	public static function all() {
		$initial_groups = apply_filters( 
			'basement_shortcodes_groups_config', 
			require 'configs/groups.php'  
		);
		$groups = array();
		$shortcodes = Basement_Shortcodes::instance()->collection();
		foreach ( $shortcodes as $shortcode ) {
			$shortcode_group = $shortcode->group();
			if ( !in_array( $shortcode_group, $groups ) ) {
				if ( !empty( $initial_groups[ $shortcode_group ] ) )  {
					$shortcode_group_title = $initial_groups[ $shortcode_group ];
				} else {
					$shortcode_group_title = $shortcode_group;
				}
				$groups[ $shortcode_group ] = $shortcode_group_title;
			}

		}
		return $groups;
	}

}