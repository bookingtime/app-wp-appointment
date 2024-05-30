<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

require_once ABSPATH . 'wp-admin/includes/upgrade.php';


/**
 * Fired during plugin activation
 *
 * @link       https://www.bookingtime.com/
 * @since      1.0.0
 *
 * @package    Appointment
 * @subpackage Appointment/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Appointment
 * @subpackage Appointment/includes
 * @author     bookingtime <appointment@bookingtime.com>
 */
class Appointment_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		if (!defined('WP_HOME')) {
			$appointmentAdmin = new Appointment_Admin();
			$wp_home_array = $appointmentAdmin->getFromOptionsTable('home');
			if(!empty($wp_home_array)) {
				define('WP_HOME',$wp_home_array[0]->option_value);
			} else {
				define('WP_HOME','');
			}
		}

		self::jsonConfigFile();
		self::installDBAppointment();
	}

	private static function jsonConfigFile() {
		global $wp_filesystem;

		// Überprüfen, ob das Dateisystem initialisiert ist
		if ( ! is_wp_error( $wp_filesystem ) && WP_Filesystem() ) {
			$file = plugin_dir_path( __DIR__ ) . 'blocks/appointment_globals.json';
			$json = array(
					'wp_home' => WP_HOME
			);

			// Dateiinhalt vorbereiten
			$file_content = wp_json_encode( $json );

			// Datei schreiben
			if ( $wp_filesystem->put_contents( $file, $file_content, FS_CHMOD_FILE ) !== false ) {
					// Erfolgsmeldung oder weitere Aktionen bei Bedarf
					return;
			} else {
					// Fehlerbehandlung, falls das Schreiben der Datei fehlschlägt
					return;
			}
		}
	}



	/**
	 * installDBAppointment
	 *
	 */
	private static function installDBAppointment() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'appointment';
		$charset_collate = $wpdb->get_charset_collate();
		$sql = "CREATE TABLE IF NOT EXISTS $table_name (
			id int(11) unsigned NOT NULL auto_increment,
			title varchar(255) DEFAULT '' NOT NULL,
			url text DEFAULT '' NOT NULL,
			PRIMARY KEY  (id)
		) $charset_collate;";
		dbDelta( $sql );
	}
}
