<?php
/**
 * The file that defines the core plugin database Implementation.
 *
 * @link       https://rajanlama.com.np
 * @since      1.0.0
 *
 * @package    Simple_Rest_Form
 * @subpackage Simple_Rest_Form/includes
 */

namespace SimpleRestForm;

/**
 * Database Implemetions for Plugin.
 *
 * This class defines all code necessary opreations for Database.
 *
 * @since      1.0.0
 * @package    Simple_Rest_Form
 * @subpackage Simple_Rest_Form/includes
 * @author     Rajan Lama <rajan.lama786@gmail.com>
 */

/**
 * DB is responsible for database activity
 */
final class DB {
	/**
	 * WordPress Core variable $wpdb.
	 *
	 * @var mixed
	 */
	private $wpdb;

	/**
	 * Setting a Table name table_name privately.
	 *
	 * @var mixed
	 */
	private $table_name;

	/**
	 * Define the core database functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the database table, if need table doesn't exist, will create the table
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		global $wpdb;

		$this->wpdb       = $wpdb;
		$this->table_name = $wpdb->prefix . 'business_table';
		$this->create_table();
	}

	/**
	 * Function to Create Table
	 *
	 * @since    1.0.0
	 */
	public function create_table() {

		if ( get_option( 'business_db_setup' ) === 1 ) {
			return;
		}

		// Define the table name.
		$table = $this->table_name;

		// Get the charset and collation.
		$charset_collate = $this->wpdb->get_charset_collate();

		// SQL statement to create the table.
		$sql = "CREATE TABLE IF NOT EXISTS $table (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            business_name tinytext NOT NULL,
            business_address text NOT NULL,
            website_url varchar(55) DEFAULT '' NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );

		update_option( 'business_db_setup', 1 );
	}

	/**
	 * Function to Insert row
	 *
	 * @param  mixed $name has business_name.
	 * @param  mixed $address has business_address.
	 * @param  mixed $url has business_url.
	 * @return int
	 */
	public function insert_row( $name, $address, $url ) {
		$this->wpdb->insert(
			$this->table_name,
			array(
				'time'             => current_time( 'mysql' ),
				'business_name'    => sanitize_text_field( $name ),
				'business_address' => sanitize_text_field( $address ),
				'website_url'      => esc_url_raw( $url ),
			),
			array( '%s', '%s', '%s', '%s' )
		);

		return $this->wpdb->insert_id;
	}

	/**
	 * Function to Delete Row.
	 *
	 * @param  mixed $id has integer value.
	 * @return void
	 */
	public function delete_row( $id ) {
		$this->wpdb->delete(
			$this->table_name,
			array( 'id' => absint( $id ) ),
			array( '%d' )
		);
	}

	/**
	 * Function to Update Table
	 *
	 * @param  mixed $id has integer value.
	 * @param  mixed $name has string value.
	 * @param  mixed $address has string value.
	 * @param  mixed $url has string value.
	 * @return void
	 */
	public function update_table( $id = false, $name = '', $address = '', $url = '' ) {
		$arr = array();

		$arr_space = array();

		if ( ! empty( $name ) ) {
			$arr['business_name'] = $name;
			$arr_space            = '%s';
		}

		if ( ! empty( $address ) ) {
			$arr['business_address'] = $address;
			$arr_space               = '%s';
		}

		if ( ! empty( $url ) ) {
			$arr['website_url'] = $url;
			$arr_space          = '%s';
		}

		$wpdb->update( $this->table_name, $arr, array( 'ID' => $id ), $arr_space );
	}

	/**
	 * Function to Delete Table
	 *
	 * @since    1.0.0
	 */
	public function delete_table() {
		if ( get_option( 'business_db_setup' ) !== 1 ) {
			return;
		}

		$table = $this->table_name;
		$sql   = "DROP TABLE $table;";
		$this->wpdb->get_results( $sql );
		update_option( 'business_db_setup', 0 );
	}

	/**
	 * This function perform sql query for to display all result.
	 *
	 * @param  mixed $search has a string value.
	 * @return array
	 */
	public function table_results( $search = '' ) {
		$my_custom_table = esc_sql( $this->table_name );

		if ( ! empty( $search ) ) {
			$search  = esc_sql( $search ); // Escape the $search variable.
			$content = $this->wpdb->get_results(
				$this->wpdb->prepare(
					"SELECT * FROM $my_custom_table WHERE business_name LIKE %s OR business_address LIKE %s",
					'%' . $search . '%',
					'%' . $search . '%'
				)
			);
		} else {
			$content = $this->wpdb->get_results( "SELECT * FROM $my_custom_table" );
		}
		return $content;
	}
}
