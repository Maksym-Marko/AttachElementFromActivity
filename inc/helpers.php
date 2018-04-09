<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// An array of items that are included in the list of important.
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

// Filter for the activity cycle.
function mx_bp_activities_exclude_activity_item( $retval ) {
	    
    $exclude_items = mx_list_attachment_items( MX_TABLE_SLUG ); 

	$exclude_items_arr = explode(",", $exclude_items);

    $retval['exclude'] = $exclude_items_arr;
 
    return $retval;
    
}