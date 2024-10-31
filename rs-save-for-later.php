<?php

/**
 * @link     http://ratkosolaja.info/
 * @since    1.0.0
 * @package  RS_Save_For_Later
 *
 * Plugin Name: Simplicity Save for Later
 * Plugin URI:  https://wordpress.org/plugins/rs-save-for-later/
 * Description: Save content for later.
 * Version:     1.0.8
 * Author:      Simplicity LLC
 * Author URI:  http://www.simplicity.rs/
 * License:     GNU General Public License version 3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: rs-save-for-later
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 */
function activate_rs_save_for_later() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-rs-save-for-later-activator.php';
	RS_Save_For_Later_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_rs_save_for_later() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-rs-save-for-later-deactivator.php';
	RS_Save_For_Later_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_rs_save_for_later' );
register_deactivation_hook( __FILE__, 'deactivate_rs_save_for_later' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-rs-save-for-later.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_rs_save_for_later() {
	$plugin = new RS_Save_For_Later();
	$plugin->run();
}
run_rs_save_for_later();