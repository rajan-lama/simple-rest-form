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

use SimpleRestForm\DB;

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
final class RestAPI extends \WP_REST_Controller {

	/**
	 * Define the core database functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the database table, if need table doesn't exist, will create the table
	 *
	 * @since    1.0.0
	 * @param  mixed $plugin_name has string value.
	 * @param  mixed $version has string value.
	 * @return void
	 */
	public function __construct( $plugin_name, $version ) {
		/**
		 * Register endpoint of rest api for the business card
		 */
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}

	/**
	 * Register the routes for the objects of the controller.
	 */
	public function register_routes() {
		$namespace = 'business/v1';
		$base      = 'cards';
		register_rest_route(
			$namespace,
			'/' . $base,
			array(
				array(
					'methods'             => \WP_REST_Server::READABLE,
					'callback'            => array( $this, 'get_items' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
					'args'                => array(),
				),
				array(
					'methods'             => \WP_REST_Server::CREATABLE,
					'callback'            => array( $this, 'create_item' ),
					'permission_callback' => array( $this, 'create_item_permissions_check' ),
					'args'                => $this->get_endpoint_args_for_item_schema( true ),
				),
			)
		);
		register_rest_route(
			$namespace,
			'/' . $base . '/(?P<id>[\d]+)',
			array(
				array(
					'methods'             => \WP_REST_Server::READABLE,
					'callback'            => array( $this, 'get_item' ),
					'permission_callback' => array( $this, 'get_item_permissions_check' ),
					'args'                => array(
						'context' => array(
							'default' => 'view',
						),
					),
				),
				array(
					'methods'             => \WP_REST_Server::EDITABLE,
					'callback'            => array( $this, 'update_item' ),
					'permission_callback' => array( $this, 'update_item_permissions_check' ),
					'args'                => $this->get_endpoint_args_for_item_schema( false ),
				),
				array(
					'methods'             => \WP_REST_Server::DELETABLE,
					'callback'            => array( $this, 'delete_item' ),
					'permission_callback' => array( $this, 'delete_item_permissions_check' ),
					'args'                => array(
						'force' => array(
							'default' => false,
						),
					),
				),
			)
		);
	}

	/**
	 * Get a collection of items
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|WP_REST_Response
	 */
	public function get_items( $request ) {
		$params = $request->get_params();

		$search = ( ! empty( $params ) && count( $params ) ) ? $search = $params['search'] : '';

		$db    = new DB();
		$items = $db->table_results( $search );
		$data  = array();
		foreach ( $items as $item ) {
			$itemdata = $this->prepare_item_for_response( $item, $request );
			$data[]   = $this->prepare_response_for_collection( $itemdata );
		}

		return new \WP_REST_Response( $data, 200 );
	}

	/**
	 * Get one item from the collection
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|WP_REST_Response
	 */
	public function get_item( $request ) {
		// get parameters from request.
		$params = $request->get_params();
		$item   = array();// do a query, call another class, etc.
		$data   = $this->prepare_item_for_response( $item, $request );

		// return a response or error based on some conditional.
		if ( 1 === 1 ) {
			return new \WP_REST_Response( $data, 200 );
		} else {
			return new \WP_Error( 'code', __( 'message', 'text-domain' ) );
		}
	}

	/**
	 * Create one item from the collection
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|WP_REST_Response
	 */
	public function create_item( $request ) {
		$item    = $this->prepare_item_for_database( $request );
		$db      = new DB();
		$last_id = $db->insert_row( $item['name'], $item['address'], $item['website'] );
		if ( ! empty( $last_id ) && is_int( $last_id ) ) {
			return new \WP_REST_Response( 'Successfully inserted row with id ' . $last_id, 200 );
		}

		return new \WP_Error( 'cant-create', __( 'message', 'text-domain' ), array( 'status' => 500 ) );
	}

	/**
	 * Update one item from the collection
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|WP_REST_Response
	 */
	public function update_item( $request ) {
		$item = $this->prepare_item_for_database( $request );
		// We can implement update logic here.
		return new \WP_Error( 'cant-update', __( 'message', 'text-domain' ), array( 'status' => 500 ) );
	}

	/**
	 * Delete one item from the collection
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|WP_REST_Response
	 */
	public function delete_item( $request ) {
		$item = $this->prepare_item_for_database( $request );
		// We can implement delete Logic here.
		return new \WP_Error( 'cant-delete', __( 'message', 'text-domain' ), array( 'status' => 500 ) );
	}

	/**
	 * Check if a given request has access to get items
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|bool
	 */
	public function get_items_permissions_check( $request ) {
		return true; // <--use to make readable by all
		// We can control permission here.
		// return current_user_can( 'edit_posts' );
	}

	/**
	 * Check if a given request has access to create items
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|bool
	 */
	public function create_item_permissions_check( $request ) {
		return current_user_can( 'edit_posts' );
	}

	/**
	 * Check if a given request has access to update a specific item
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|bool
	 */
	public function update_item_permissions_check( $request ) {
		return $this->create_item_permissions_check( $request );
	}

	/**
	 * Check if a given request has access to delete a specific item
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|bool
	 */
	public function delete_item_permissions_check( $request ) {
		return $this->create_item_permissions_check( $request );
	}

	/**
	 * Prepare the item for create or update operation.
	 *
	 * @param WP_REST_Request $request Request object.
	 * @return WP_Error|object $prepared_item
	 */
	protected function prepare_item_for_database( $request ) {
		return $request->get_json_params();
	}

	/**
	 * Prepare the item for the REST response
	 *
	 * @param mixed           $item WordPress representation of the item.
	 * @param WP_REST_Request $request Request object.
	 * @return mixed
	 */
	public function prepare_item_for_response( $item, $request ) {
		return rest_ensure_response( $item );
	}

	/**
	 * Get the query params for collections
	 *
	 * @return array
	 */
	public function get_collection_params() {
		return array(
			// pagination logic has not been implemented yet.
			'page' => array(
				'description'       => 'Current page of the collection.',
				'type'              => 'integer',
				'default'           => 1,
				'sanitize_callback' => 'absint',
			),
			// pagination logic has not been implemented yet.
			'per_page' => array(
				'description'       => 'Maximum number of items to be returned in result set.',
				'type'              => 'integer',
				'default'           => 10,
				'sanitize_callback' => 'absint',
			),
			/**
			 * Search logic has been implemented yet.
			 * http://exmaple.loc/wp-json/business/v1/cards/?search=hello
			 */
			'search'   => array(
				'description'       => 'Limit results to those matching a string.',
				'type'              => 'string',
				'sanitize_callback' => 'sanitize_text_field',
			),
		);
	}
}
