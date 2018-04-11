<?php
/*
* Class for activating, deactivating and removing the plugin.
*/

// Exit if accessed directly.
if ( !defined( 'ABSPATH' ) ) exit;

class AitasBasicFunctions
{

	private static $table_name_slug = MX_TABLE_SLUG;

	public static function aitas_activate()
	{

		// Create table.
		global $wpdb;

		// Table name.
		$table_name = $wpdb->prefix . self::$table_name_slug;

		if ( $wpdb->get_var( "SHOW TABLES LIKE '" . $table_name . "'" ) !=  $table_name ) {

			$sql = "CREATE TABLE IF NOT EXISTS `$table_name`
			(
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`attach_id` varchar(40) NOT NULL,
				PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=$wpdb->charset AUTO_INCREMENT=1;";

			$wpdb->query( $sql );

			// Insert dummy data.
			$wpdb->insert(

				$table_name,

				array(

					'attach_id' => 0,

				)

			);

		}

		// Rewrite rules.
		flush_rewrite_rules();

	}

	public static function aitas_deactivate()
	{

		// Rewrite rules.
		flush_rewrite_rules();

	}

	public static function aitas_uninstall()
	{

		if ( __FILE__ != WP_UNINSTALL_PLUGIN ) {

			return;
			
		}
		
	}

}