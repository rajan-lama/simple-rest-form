<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://rajanlama.com.np
 * @since      1.0.0
 *
 * @package    Simple_Rest_Form
 * @subpackage Simple_Rest_Form/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Simple_Rest_Form
 * @subpackage Simple_Rest_Form/admin
 * @author     Rajan Lama <rajan.lama786@gmail.com>
 */

namespace SimpleRestForm;

class SRF_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		/**
		 * Enqueue style and script in admin side.
		 */
		add_action('admin_enqueue_scripts',[$this,'enqueue_scripts']);
		add_action('admin_enqueue_scripts',[$this,'enqueue_styles']);

		/**
		 * aAdding custom menu on WP Dashboard
		 */
		add_action('admin_menu', [$this, 'SRF_menu']);

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Simple_Rest_Form_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Simple_Rest_Form_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Simple_Rest_Form_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Simple_Rest_Form_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Custom menu for WP Dashboard
	 */
	public function SRF_menu() { 

		/**
		 * Registering Admin side Menu
		 */
		add_menu_page( 
			'Page Title', 
			'Simple Rest Form', 
			'edit_posts', 
			'srf-form', 
			[ $this, 'SRF_menu_page' ], 
			'dashicons-media-spreadsheet',
			20
		   );
	}

	/**
	 * Display a custom menu page
	 */
	public function SRF_menu_page(){
		
		/**
		 * SRF Menu page for admin side
		 */
		include SIMPLE_REST_FORM_BASE_PATH . 'admin/partials/display.php';
	}

}