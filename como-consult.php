<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * Dashboard. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @author 				Como Creative LLC
 * @link 				https://comocreative.com
 * @since 				1.0.2
 * @package 			Como_Consult
 *
 * @wordpress-plugin
 * Plugin Name: 		Como Consult
 * Plugin URI: 			https://wordpress.comocreative.com/
 * Description: 		Endable pop-up consultstion form
 * Version: 			1.0.2
 * Author: 				Como Creative LLC
 * Author URI: 			https://comocreative.com
 * License: 			GPL-2.0+
 * License URI: 		http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: 		como-consult
 * Domain Path: 		/languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Include plugin updater.
require_once( trailingslashit( plugin_dir_path( __FILE__ ) ) . 'includes/updater.php' );

// Used for referring to the plugin file or basename
if ( ! defined( 'COMO_MERCHANTS_FILE' ) ) {
	define( 'COMO_MERCHANTS_FILE', plugin_basename( __FILE__ ) );
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-como-consult-activator.php
 */
function activate_Como_Consult() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-como-consult-activator.php';
	Como_Consult_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-como-consult-deactivator.php
 */
function deactivate_Como_Consult() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-como-consult-deactivator.php';
	Como_Consult_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_Como_Consult' );
register_deactivation_hook( __FILE__, 'deactivate_Como_Consult' );

/**
 * The core plugin class that is used to define internationalization,
 * dashboard-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-como-consult.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since 		1.0.0
 */
function run_Como_Consult() {

	$plugin = new Como_Consult();
	$plugin->run();

}
run_Como_Consult();
