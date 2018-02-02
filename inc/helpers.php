<?php
function mx_list_attachment_items( $table_slug ) {

	global $wpdb;

	$table_name = $wpdb->prefix . $table_slug;

	$attachment_elements = $wpdb->get_results( "SELECT attach_id FROM " . $table_name . " ORDER By id DESC" );

	$array_attachment_elements = array();

	foreach( $attachment_elements as $attach_element ){
		$array_attachment_elements[] = $attach_element->attach_id;
	}

	$array_attachment_elements = implode( ',', $array_attachment_elements );

	return $array_attachment_elements;

}

/**************************
* filter for activity loop
***************************/
function mx_set_filter_exclude(){	

	add_filter( 'bp_after_has_activities_parse_args', 'my_bp_activities_exclude_activity_item' );

}

	function my_bp_activities_exclude_activity_item( $retval ) {
		    
	    $exclude_items = mx_list_attachment_items( MX_TABLE_SLUG ); 

		$exclude_items_arr = explode(",", $exclude_items);

	    $retval['exclude'] = $exclude_items_arr;
	 
	    return $retval;
	}