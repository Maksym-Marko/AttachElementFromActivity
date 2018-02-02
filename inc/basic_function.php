<?php
/**
* @package AttachElementFromActivity
*/

/**
*	Trigger this file on Plugin uninstall
*
*/

// Clear Database 
class BasicFunctions
{

	private static $table_name_slug = MX_TABLE_SLUG;

	public static function activate() {

		// create table
		global $wpdb;

		$table_name = $wpdb->prefix . self::$table_name_slug;

		if ( $wpdb->get_var( "SHOW TABLES LIKE '" . $table_name . "'" ) !=  $table_name ) {

			$sql = "CREATE TABLE IF NOT EXISTS `$table_name`
				(
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`attach_id` varchar(40) NOT NULL,
					PRIMARY KEY (`id`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

			$wpdb->query( $sql );

			// insert dummy data
			$wpdb->insert( 
				$table_name, 
				array(
					'attach_id' => 0, 
				) 
			);

		}

		// rewrite rules
		flush_rewrite_rules();
	}

	public static function deactivate() {

		// CODE...

		// rewrite rules
		flush_rewrite_rules();
	}

	public static function uninstall() {

		if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
			die;
		}

		// remove table
		global $wpdb;

		$table_name = $wpdb->prefix . self::$table_name_slug;

		$sql = "DROP TABLE IF EXISTS $table_name";

		$wpdb->query($sql);
		
	}
}