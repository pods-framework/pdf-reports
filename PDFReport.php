<?php
namespace PDFReport;
/*
 * Plugin Name: PDF Reports
 * Description: PDF Reports
 * Version: 0.0.1
 * Author: Pods Framework Team
 * Author URI: http://pods.io
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

// Abort if this file is called directly
if ( !defined( 'WPINC' ) ) {
	die;
}

define( __NAMESPACE__ . '\PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( __NAMESPACE__ . '\PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
require_once PLUGIN_DIR . 'tcpdf/tcpdf.php';

/**
 * Autoloader
 */
spl_autoload_register(
	function ( $cls ) {

		$cls = ltrim( $cls, '\\' );
		if ( strpos( $cls, __NAMESPACE__ . '\\' ) !== 0 ) {
			return;
		}

		$cls = str_replace( __NAMESPACE__, '', $cls );
		$cls = ltrim( $cls, '\\' );

		$path = PLUGIN_DIR . str_replace( '\\', DIRECTORY_SEPARATOR, $cls ) . '.php';

		// ToDo: Should any action be taken for class files that cannot be found? 
		if ( file_exists( $path ) ) {
			require_once( $path );	
		}		
	}
);

/**
 * Bootstrap
 */
if ( is_admin() && ( !defined( 'DOING_AJAX' ) || !DOING_AJAX ) ) {
	add_action( 'plugins_loaded', array( __NAMESPACE__ . '\\Plugin', 'plugins_loaded' ) );
}

/**
 * Class Plugin
 *
 * @package PDFReport
 */
class Plugin {

	/**
	 * Called on plugins_loaded
	 */
	public static function plugins_loaded() {
		// ToDo
	}
}
