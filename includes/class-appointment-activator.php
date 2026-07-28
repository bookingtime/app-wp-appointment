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
		// Der frueher hier stehende Block definierte WP_HOME ueber
		// "new Appointment_Admin()" - ein Aufruf ohne Argumente, obwohl der
		// Konstruktor $plugin_name und $version ohne Standardwerte erwartet.
		// Unter PHP 8 haette das einen ArgumentCountError ausgeloest, sobald
		// WP_HOME zum Aktivierungszeitpunkt nicht bereits definiert gewesen
		// waere. Zusaetzlich haette der Konstruktor damals API-Requests
		// waehrend der Aktivierung angestossen.
		//
		// WP_HOME wird jetzt in bt_appointment.php gesetzt und liegt hier
		// bereits vor.
		self::installDBAppointment();
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
