<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.bookingtime.com/
 * @since             1.0.0
 * @package           Appointment
 *
 * @wordpress-plugin
 * Plugin Name:       bookingtime appointment
 * Plugin URI:        https://github.com/bookingtime/app-wp-appointment
 * Description:       Conveniently integrate bookingtime's online appointment booking into your wordpress website.

 * Version:           6.0.7
 * Author:            bookingtime
 * Author URI:        https://www.bookingtime.com/
 * License: 			 MIT
 * License URI: 		 https://opensource.org/licenses/GPL-3.0
 * Text Domain:       bt_appointment
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This function register_block_type_from_metadata
 */
function bta_blocks_bookingtime_appointment_init() {
	register_block_type_from_metadata( __DIR__ . '/blocks');
}

add_action( "init", "bta_blocks_bookingtime_appointment_init" );

function bt_appointment_output_buffer() {
	$routes = [
		'appointment-init',
        'appointment-step1',
        'appointment-step2',
        'appointment-step3',
        'appointment-getbookingtimepageurls',
        'appointment-list',
        'appointment-edit',
        'appointment-add',
        'appointment-preview'
	];
    foreach ($routes as $route) {
        if(strpos($_SERVER['REQUEST_URI'],$route) !== FALSE) {
            ob_start();
            //start session
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
        }
    }
}
add_action('init', 'bt_appointment_output_buffer');

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'APPOINTMENT_VERSION', '6.0.7' );

if ( ! defined( 'APPOINTMENT_PLUGIN_URL' ) ) {
	define( 'APPOINTMENT_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-appointment-activator.php
 */
function bta_activate_appointment() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-appointment-activator.php';
	Appointment_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-appointment-deactivator.php
 */
function bta_deactivate_appointment() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-appointment-deactivator.php';
	Appointment_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'bta_activate_appointment' );
register_deactivation_hook( __FILE__, 'bta_deactivate_appointment' );




// In Ihrer theme oder plugin Datei
function bta_plugin_enqueue_scripts() {
    wp_enqueue_script(
        'bta-plugin-script',
        plugins_url( 'blocks/src/edit.js', __FILE__ ),
        array( 'wp-blocks', 'wp-element', 'wp-editor' ),
        filemtime( plugin_dir_path( __FILE__ ) . 'blocks/src/edit.js' ),
		  false
    );

    wp_localize_script(
        'bta-plugin-script',
        'btaPluginData',
        array(
            'nonce' => wp_create_nonce( 'bt_appointment_restApi' ),
				'home_url' => home_url()
        )
    );
}
add_action( 'enqueue_block_editor_assets', 'bta_plugin_enqueue_scripts' );






/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-appointment.php';


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function bta_run_appointment() {

	$plugin = new BTA_Appointment();
	$plugin->run();
}
bta_run_appointment();
