<?php
/**
 * The file that defines the core plugin database Implementation.
 *
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

class Restapi {
    
    private $wpdb;

    private $table_name;

    /**
     * Define the core database functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the database table, if need table doesn't exist, will create the table
     *
     * @since    1.0.0
     */
    public function __construct()
    {
        global $wpdb;

        $this->wpdb = $wpdb;

        $this->table_name = $wpdb->prefix . 'business_table';

        $this->create_table();
        
        $this->insert_row('ps theme', 'kathmandu, Nepal', "prosysthemes.com");
    }

    /**
     * Function to Create Table
     * 
     * @since    1.0.0
     */
    public function create_table(){

        if( get_option('business_db_setup') == 1 ){
            return;
        }

        $table = $this->table_name;

        $charset_collate = $this->wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS $table (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            business_name tinytext NOT NULL,
            business_address text NOT NULL,
            website_url varchar(55) DEFAULT '' NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );

        update_option( "business_db_setup", 1 );
    }

    /**
     * Function to Create Table
     * 
     * @param $arr_data has array of data per row.
     * @since    1.0.0
     */
    public function insert_row( $name, $address, $url ){
        $currentDateTime = new \DateTime('now');
        $currentDate = $currentDateTime->format('Y-m-d H:i:s');

        $this->wpdb->insert( $this->table_name, [ 
            'time'=> $currentDate, 
            'business_name' => esc_html( $name ), 
            'business_address' => esc_html( $address ), 
            'website_url'=> esc_url( $url ) 
        ], ['%s','%s','%s','%s'] );
    }

    /**
     * Function to Update Table
     * 
     * @since    1.0.0
     */
    public function update_table( $id = false, $name='', $address='', $url=''){
        $arr = [];

        $arr_space = [];

        if( ! empty( $name ) ) {
            $arr['business_name'] = $name;
            $arr_space = '%s';
        }

        if( ! empty( $address ) ) {
            $arr['business_address'] = $address;
            $arr_space = '%s';
        }

        if( ! empty( $url ) ) {
            $arr['website_url'] = $url;
            $arr_space = '%s';
        }

        $wpdb->update( $this->table_name, $arr, array( 'ID' => $id ), $arr_space );
    }


    /**
     * Function to Delete Table
     * 
     * @since    1.0.0
     */
    public function delete_table(){
        if( get_option('business_db_setup') != 1 ){
            return;
        }

        $table = $this->table_name;

        $sql = "DROP TABLE $table;";
        $this->wpdb->get_results( $sql );
        update_option( "business_db_setup", 0 );
    }


    public function table_results(){
        $my_custom_table = $this->wpdb->prefix . "table_name";

        $table_content = $this->wpdb->get_results("SELECT * FROM $my_custom_table");
        return $table_content;
    }
}
