<?php
/**
* @package AttachElementFromActivity
*/

class CrudAttachmentItems
{

	private $table_name_slug = MX_TABLE_SLUG;
	
	public function item_add( $attach_id )
	{

		global $wpdb;

		$attach_id = trim( $attach_id );

		if( $attach_id == '' ){
			return false;
		}

		$table_name = $wpdb->prefix . $this->table_name_slug;

		$t = "INSERT INTO $table_name (attach_id) VALUES(%d)";
		$query = $wpdb->prepare( $t, $attach_id );
		$result = $wpdb->query( $query );

		if( $result === false ){
			die( 'Ошибка БД' );
		}

		return true;

	}

	public function item_delete( $de_attach_id )
	{

		global $wpdb;

		$table_name = $wpdb->prefix . $this->table_name_slug;

		$t = "DELETE FROM $table_name WHERE attach_id='%d'";
		$query = $wpdb->prepare($t, $de_attach_id);
		$result = $wpdb->query($query);

		if( $result === false ){
			die( 'Ошибка БД' );
		}

		return true;
	}

}