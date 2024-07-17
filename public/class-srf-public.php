<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://rajanlama.com.np
 * @since      1.0.0
 *
 * @package    Simple_Rest_Form
 * @subpackage Simple_Rest_Form/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Simple_Rest_Form
 * @subpackage Simple_Rest_Form/public
 * @author     Rajan Lama <rajan.lama786@gmail.com>
 */
namespace SimpleRestForm;

/**
 * This is a final class named SRF_Public for the public part for this plugins.
 */
final class SRF_Public {

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
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		// Register shortcode.
		add_shortcode( 'business_form', array( $this, 'business_form_shortcode_callback' ) );
		add_shortcode( 'business_info_list', array( $this, 'business_detail_shortcode_callback' ) );
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script(
			$this->plugin_name,
			'srfApiSettings',
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'root'    => esc_url_raw( rest_url() ),
				'nonce'   => wp_create_nonce( 'wp_rest' ),
			)
		);
	}

	/**
	 * Callback function for business detail entry form
	 *
	 * @param string $atts attributes of shortcode added during putting shortcode in post and page.
	 * @return string
	 */
	public function business_form_shortcode_callback( $atts ) {
		$attributes = shortcode_atts(
			array(
				'title' => false,
			),
			$atts
		);

		ob_start();
		include SIMPLE_REST_FORM_BASE_PATH . 'public/partials/display-form.php';
		return ob_get_clean();
	}

	/**
	 * This is the call back function for listing business details.
	 *
	 * @param  mixed $atts attributes of shortcode added during putting shortcode in post and page.
	 * @return string
	 */
	public function business_detail_shortcode_callback( $atts ) {
		$attributes = shortcode_atts(
			array(
				'search' => '',
			),
			$atts
		);

		ob_start();
		include SIMPLE_REST_FORM_BASE_PATH . 'public/partials/display-list.php';
		return ob_get_clean();
	}
}
