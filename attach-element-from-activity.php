<?php
/*
Plugin Name: Attach an item to the activity stream
Plugin URI: https://github.com/Maxim-us/AttachElementFromActivity
Description: The plugin complements BuddyPress. Allows you to insert an element from the activity cycle to the beginning.
Author: Marko Maksym
Version: 1.0
Author URI: https://github.com/Maxim-us
*/

/*
* The plugin complements the BuddyPress plugin.
* Before installing, you need to install the buddypress plugin.
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// Slug database table.
const MX_TABLE_SLUG = 'attach_element_activity';

// CRUD file.
require_once plugin_dir_path( __FILE__ ) . 'inc/crud.php';

// Helper functions.
require_once plugin_dir_path( __FILE__ ) . 'inc/helpers.php';

// Create buttons for attaching and detaching elements in the activity stream.
require_once plugin_dir_path( __FILE__ ) . 'inc/create_attach_button.php';

// Includes the main functions to run this plugin.
require_once plugin_dir_path( __FILE__ ) . 'inc/basic_function.php';

// List of attached elements.
require_once plugin_dir_path( __FILE__ ) . 'inc/body_for_attach_item.php';

// Main class.
class AttachElementFromActivity
{

	function __construct() {
		
		// Add button.
		$this->add_button_in_activity_item();

		// Create a place before the activity cycle.
		$this->create_place_before_activity_loop();

		// Registration of scripts and styles.
		$this->register();

		// Look at the $ _POST array.
		$this->observe_the_elements();

	}	

	/*******************
	* Basic methods.
	********************/
	// Register function.
	public function register() {

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );

	}

	/**************************
	* Filter for activity loop.
	***************************/
	public function set_filter_exclude_attach_items(){

		// Function "mx_bp_activities_exclude_activity_item" located in the "./inc/helpers.php" file.
		add_filter( 'bp_after_has_activities_parse_args', 'mx_bp_activities_exclude_activity_item' );

	}

	/**********************
	* Functions action.
	***********************/
	// Add scripts and styles to the queue.
	public function enqueue() {

		wp_enqueue_style( 'load-fa', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css' );

		wp_enqueue_style( 'attachElementFromActivityStyle', plugins_url( '/assets/css/attachElementFromActivity.css', __FILE__ ) );

		wp_enqueue_script( 'attachElementFromActivityScript', plugins_url( '/assets/js/script.js', __FILE__ ), array( 'jquery' ) );

		wp_localize_script( 'attachElementFromActivityScript', 'ajax_object', array(

			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'nonce' => wp_create_nonce( 'nonce_attach_request' )

		) );

	}

	// Add a button to an activity item.
	public function add_button_in_activity_item() {

		add_action( 'plugins_loaded', function() {

			$user_meta = get_userdata( get_current_user_id() );

			$user_roles = $user_meta->roles;

			// Run BuddyPress hook if the current user is an administrator.
			if( $user_roles[0] == 'administrator' ){
			    
				add_action( 'bp_activity_entry_meta', array( $this, 'create_attach_button' ), 1 );

			}

		} );
		
	}

		// Create a button to attach.
		public function create_attach_button() {

			$new_button_attach = new AttachButton();

			$new_button_attach->create_form();
		}

	// Create a place before the activity cycle.
	public function create_place_before_activity_loop() {

		add_action( 'bp_before_directory_activity_list', array( $this, 'body_for_attach_item' ), 20 );

	}

		// Place for important activities.
		public function body_for_attach_item() {			

			$get_attachment_items = new AttachmentItems();
	
			$get_attachment_items->list_items();

		}

	// Attach|Detach element.
	public function observe_the_elements()
	{

		add_action( 'wp_ajax_attach-element', array( $this, 'attach_func' ) );

	}

		// CRUD.
		function attach_func()
		{ 

			if( empty( $_POST['nonce'] ) ) wp_die( '0' );

			// If nonce is checked.
			if( wp_verify_nonce( $_POST['nonce'], 'nonce_attach_request' ) ){

				$attach_class = new CrudAttachmentItems();

				if( $_POST['type_attach'] === 'attach' ){

					$attach_class->item_add( $_POST['id_item'] );

				} else if(  $_POST['type_attach'] === 'detach'  ){

					$attach_class->item_delete( $_POST['id_item'] );

				} else{

					die( 'Error!' );

				}

			}

			wp_die();
		}

}

// Initialize.
if ( class_exists( 'AttachElementFromActivity' ) ) {

	$attachElementFromActivity = new AttachElementFromActivity();

	$attachElementFromActivity->set_filter_exclude_attach_items();

}

// Activation.
register_activation_hook( __FILE__, array( 'BasicFunctions', 'activate' ) );

// Deactivation.
register_deactivation_hook( __FILE__, array( 'BasicFunctions', 'deactivate' ) );

// Uninstall.
register_uninstall_hook( __FILE__, array( 'BasicFunctions', 'uninstall' ) );