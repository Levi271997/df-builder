<?php
/**
 * Plugin Name:       DF Builder
 * Description:       Oxygen-style page building inside the block editor: per-breakpoint style controls, global classes, conditional templates and dynamic data.
 * Version:           0.1.0
 * Requires at least: 6.6
 * Requires PHP:      8.1
 * Author:            Digitalfeet
 * License:           GPL-2.0-or-later
 * Text Domain:       df-builder
 *
 * @package DFBuilder
 */

defined( 'ABSPATH' ) || exit;

define( 'DFB_VERSION', '0.1.0' );
define( 'DFB_FILE', __FILE__ );
define( 'DFB_DIR', plugin_dir_path( __FILE__ ) );
define( 'DFB_URL', plugin_dir_url( __FILE__ ) );

spl_autoload_register(
	static function ( $class ) {
		if ( 0 !== strpos( $class, 'DFBuilder\\' ) ) {
			return;
		}
		$name = strtolower( str_replace( '_', '-', substr( $class, strlen( 'DFBuilder\\' ) ) ) );
		$file = DFB_DIR . 'includes/class-' . $name . '.php';
		if ( is_readable( $file ) ) {
			require $file;
		}
	}
);

add_action( 'plugins_loaded', array( 'DFBuilder\\Plugin', 'instance' ) );

register_activation_hook( __FILE__, array( 'DFBuilder\\Plugin', 'activate' ) );
