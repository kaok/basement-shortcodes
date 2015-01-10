<?php
/**
 * Plugin Name: Basement Shortcodes
 * Plugin URI: http://aisconverse.com
 * Description: A Basement Framework shortcodes builder
 * Version: 1.0
 * Author: Aisconverse team
 * Author URI: http://aisconverse.com
 * License: GPL2
 */


defined('ABSPATH') or die();

add_action( 'basement_loaded', 'basement_shortcodes_init', 999 );

function basement_shortcodes_init() {
	require 'shortcodes.php';
}
