<?php
defined('ABSPATH') or die();

define( 'BASEMENT_SHORTCODES_TEXTDOMAIN', 'basement_shortcodes' );

class Basement_Shortcodes {

	private $shortcodes = array();
	private static $instance = null;

	public $panel = null;

	public static function init() {
		if ( !in_array( 'basement/basement.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && 
			!current_theme_supports( 'basement' ) ) {
			add_action( 'admin_notices', array( &$this, 'no_basement_notice' ) );
			return;
		}
		add_action( 'basement_plugins_loaded', array( self::instance(), 'init_shortcodes' ) );
		add_action( 'basement_plugins_loaded', array( self::instance(), 'init_panel' ) );
	}

	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new Basement_Shortcodes();
		}
		return self::$instance;
	}

	public function no_basement_notice() { ?>
		<div class="error">
			<p><?php _e( 'Your theme doesn\'t support Basement Framework. Basement Shortcodes plugin will not be available.', BASEMENT_SHORTCODES_TEXTDOMAIN ); ?></p>
		</div>
	<?php }

	public function init_shortcodes() {
		require_once 'shortcode.php';

		$shortcodes_configs = apply_filters( 
			'basement_shortcodes_config', 
			array_merge( require 'configs/shortcodes.php', Basement_Config::section( 'shortcodes' ) ) 
		);

		foreach ( $shortcodes_configs as $shortcode_tag => $shortcode_config) {
			if ( !empty( $shortcode_config[ 'config' ] ) && array_key_exists( $shortcode_config[ 'config' ], $shortcodes_configs ) ) {
				$shortcode_config = wp_parse_args( $shortcode_config, $shortcodes_configs[ $shortcode_config[ 'config' ] ] );
			}
			if ( empty( $shortcode_config[ 'class' ] ) ) {
				continue;
			}
			if ( empty( $shortcode_config[ 'name' ] ) ) {
				$shortcode_config[ 'name' ] = $shortcode_tag;
			}
			if ( !empty( $shortcode_config[ 'path' ] ) && file_exists( $shortcode_config[ 'path' ] ) ) {
				require_once $shortcode_config[ 'path' ];
			}
			if ( class_exists( $shortcode_config[ 'class' ] ) ) {
				$this->shortcodes[ $shortcode_tag ] = new $shortcode_config[ 'class' ]( $shortcode_config );
			}
		}



		return $this;
	}

	public function init_panel() {
		if ( is_admin() && $this->count() ) {
			require_once 'panel.php';
			require_once 'group.php';
			
			Shortcode_Panel::init();

			Basement_Asset::add_style( 
				BASEMENT_SHORTCODES_TEXTDOMAIN . '_css', 
				Basement_Url::of_file( __DIR__ . '/assets/css/production.min.css' )
			);
			Basement_Asset::add_footer_script( 
				BASEMENT_SHORTCODES_TEXTDOMAIN . '_js', 
				Basement_Url::of_file( __DIR__ . '/assets/javascript/production.min.js' ),
				array( BASEMENT_TEXTDOMAIN . '_js' ) 
			);
		}
	}

	public function collection() {
		return $this->shortcodes;
	}

	public function count() {
		return count( $this->shortcodes );
	}

}

Basement_Shortcodes::init();