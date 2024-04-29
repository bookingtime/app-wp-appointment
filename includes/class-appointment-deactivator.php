<?php

require_once ABSPATH . 'wp-admin/includes/upgrade.php';

/**
 * Fired during plugin deactivation
 *
 * @link       https://www.bookingtime.com/
 * @since      1.0.0
 *
 * @package    Appointment
 * @subpackage Appointment/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Appointment
 * @subpackage Appointment/includes
 * @author     bookingtime <appointment@bookingtime.com>
 */
class Appointment_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		self::dropDBAppointment();
	}

	/**
	 * dropDBAppointment
	 *
	 */
	private static function dropDBAppointment() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'appointment';
		$sql = "DROP TABLE IF EXISTS $table_name";
		$wpdb->query($sql);
		delete_option("appointment_db_version");
	}
}
