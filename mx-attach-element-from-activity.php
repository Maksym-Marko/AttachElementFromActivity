<?php
/**
* @package AttachElementFromActivity
*/

/*
Plugin Name: Attach an element to an activity
Plugin URI: ...
Description: Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis ex, in laboriosam. Aspernatur ea deleniti quae, ut, sunt, esse modi earum cum autem, illo sequi dolores minus vitae inventore veritatis.
Author: Max
Version: 1.0
Author URI: ...
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

// slug database table
const MX_TABLE_SLUG = 'attach_element_activity';

// CRUD file
require_once plugin_dir_path( __FILE__ ) . 'inc/crud.php';

// main class
class AttachElementFromActivity
{

	function __construct() {
		$this->add_button_in_activity_item();
		$this->create_place_begin_activity_loop();

		// register function
		$this->register();
	}	

	/*******************
	* basic methods
	********************/
	// register function
	public function register() {

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );

	}

	/**********************
	* functions action
	***********************/
	/* add scripts and styles */
	public function enqueue() {

		wp_enqueue_style( 'attachElementFromActivityStyle', plugins_url( '/assets/css/attachElementFromActivity.css?' . time(), __FILE__ ) );

		wp_enqueue_script( 'attachElementFromActivityScript', plugins_url( '/assets/js/script.js', __FILE__ ) );

	}

	/* tools */
	// add button in activity item
	public function add_button_in_activity_item() {

		// BuddyPress hook
		add_action( 'bp_activity_entry_meta', array( $this, 'create_attach_button' ), 1 );
		
	}

		// create button for attach
		public function create_attach_button() { ?>

			<?php require_once plugin_dir_path( __FILE__ ) . 'inc/create_attach_button.php'; ?>

			<?php
				$new_button_attach = new AttachButton();
				$new_button_attach->create_form();
			?>

		<?php }

	// create place begin activity loop
	public function create_place_begin_activity_loop() {
		add_action( 'bp_before_directory_activity_list', array( $this, 'body_for_attach_item' ) );
	}

		// body fot attach activity item
		public function body_for_attach_item() { ?>

			<?php require_once plugin_dir_path( __FILE__ ) . 'inc/body_for_attach_item.php'; ?>

		<?php }

}

// initialize
if ( class_exists( 'AttachElementFromActivity' ) ) {
	$attachElementFromActivity = new AttachElementFromActivity();	
}

// require basic functions
require_once plugin_dir_path( __FILE__ ) . 'inc/basic_function.php';

// activation
register_activation_hook( __FILE__, array( 'BasicFunctions', 'activate' ) );

// deactivation
register_deactivation_hook( __FILE__, array( 'BasicFunctions', 'deactivate' ) );

// uninstall
// register_uninstall_hook( __FILE__, array( 'BasicFunctions', 'uninstall' ) );
