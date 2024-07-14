<?php
/*
* Plugin Name: Simple Rest Form
* Plugin URI: https://github.com/rajan-lama/simple-rest-form
* Description: Make Magic
* Version: 1.0.0
* Requires at least: 6.5
* Requires PHP: 5.6
* Author: Rajan Lama
* Author URI: Https://rajanlama.com.np
* License: GPL 3.0
* License URI: https://www.gnu.org/licenses/gpl-3.0.txt
* Update URI: https://github.com/rajan-lama/simple-rest-form
* Text Domain: simple-rest-form
* Domain Path: /languages
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'SIMPLE_REST_FORM_VERSION', '1.0.0' );
define( 'SIMPLE_REST_FORM_BASE_PATH', plugin_dir_path( __FILE__ ) );
define( 'SIMPLE_REST_FORM_BASE_URL', plugin_dir_url( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-simple-rest-form-activator.php
 */
function activate_simple_rest_form() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-simple-rest-form-activator.php';
	Simple_Rest_Form_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-simple-rest-form-deactivator.php
 */
function deactivate_simple_rest_form() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-simple-rest-form-deactivator.php';
	Simple_Rest_Form_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_simple_rest_form' );
register_deactivation_hook( __FILE__, 'deactivate_simple_rest_form' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-srf.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
new SRF();