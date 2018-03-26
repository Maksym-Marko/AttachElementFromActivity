<?php
/**
* @package AttachElementFromActivity
*/

/*
Plugin Name: Attach an element to an activity
Plugin URI: https://github.com/Maxim-us/AttachElementFromActivity
Description: Plugin for BuddyPress. Allows you to attachment any item from the activity loop to the beginning. As in Vkontakte.
Author: Marko Maksym
Version: 1.1
Author URI: https://github.com/Maxim-us
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

// slug database table
const MX_TABLE_SLUG = 'attach_element_activity';

// CRUD file
require_once plugin_dir_path( __FILE__ ) . 'inc/crud.php';

// helpers
require_once plugin_dir_path( __FILE__ ) . 'inc/helpers.php';

// create button
require_once plugin_dir_path( __FILE__ ) . 'inc/create_attach_button.php';

// main class
class AttachElementFromActivity
{

	function __construct() {
		
		$this->add_button_in_activity_item();

		$this->create_place_begin_activity_loop();

		// register function
		$this->register();

		// watch to the $_POST
		$this->watch_post();
	}	

	/*******************
	* basic methods
	********************/
	// register function
	public function register() {

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );

	}

	/**************************
	* filter for activity loop
	***************************/
	public function set_filter_exclude_attach_items(){

		add_filter( 'bp_after_has_activities_parse_args', 'my_bp_activities_exclude_activity_item' );

	}

	/**********************
	* functions action
	***********************/
	/* add scripts and styles */
	public function enqueue() {

		wp_enqueue_style( 'attachElementFromActivityStyle', plugins_url( '/assets/css/attachElementFromActivity.css?' . time(), __FILE__ ) );

		wp_enqueue_script( 'attachElementFromActivityScript', plugins_url( '/assets/js/script.js?v=' . time(), __FILE__ ), array( 'jquery' ) );

	}

	// add button in activity item
	public function add_button_in_activity_item() {

		add_action('plugins_loaded', function() {

		  $user_meta = get_userdata( get_current_user_id() );

			$user_roles = $user_meta->roles;

			if( $user_roles[0] == 'administrator' ){
			    // BuddyPress hook
				add_action( 'bp_activity_entry_meta', array( $this, 'create_attach_button' ), 1 );
			}

		});
		
	}

		// create button for attach
		public function create_attach_button() {

			$new_button_attach = new AttachButton();

			$new_button_attach->create_form();
		}

	// create place begin activity loop
	public function create_place_begin_activity_loop() {

		add_action( 'bp_before_directory_activity_list', array( $this, 'body_for_attach_item' ), 20 );

	}

		// body fot attach activity item
		public function body_for_attach_item() { ?>

			<?php require_once plugin_dir_path( __FILE__ ) . 'inc/body_for_attach_item.php'; ?>

		<?php }

	public function watch_post()
	{

		$new_class_attach = new AttachButton();

		$new_class_attach->get_post_arr();

	}

}

// initialize
if ( class_exists( 'AttachElementFromActivity' ) ) {

	$attachElementFromActivity = new AttachElementFromActivity();

	$attachElementFromActivity->set_filter_exclude_attach_items();

}

// require basic functions
require_once plugin_dir_path( __FILE__ ) . 'inc/basic_function.php';

// activation
register_activation_hook( __FILE__, array( 'BasicFunctions', 'activate' ) );

// deactivation
register_deactivation_hook( __FILE__, array( 'BasicFunctions', 'deactivate' ) );

// uninstall
register_uninstall_hook( __FILE__, array( 'BasicFunctions', 'uninstall' ) );