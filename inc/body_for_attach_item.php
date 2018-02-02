<?php
/**
* @package AttachElementFromActivity
*/
class AttachmentItems
{

	private $table_name_slug = MX_TABLE_SLUG;

	public function listItems()
	{ 
		global $wpdb;

		$table_name = $wpdb->prefix . $this->table_name_slug;	

		$attachment_elements = $wpdb->get_results( "SELECT attach_id FROM " . $table_name . " ORDER By id DESC" );

		$array_attachment_elements = array();

		foreach( $attachment_elements as $attach_element ){
			$array_attachment_elements[] = $attach_element->attach_id;
		}

		$array_attachment_elements = implode( ',', $array_attachment_elements );

		// add_filter( 'bp_activity_get', 'set_exclude_for_attachment_items' );

		// function set_exclude_for_attachment_items( $args ){
			
		// }

		var_dump($array_attachment_elements);

		?>

		<?php if ( bp_has_activities( 'display_comments=threaded&show_hidden=true&include=0,' . $array_attachment_elements ) ) : ?>

			<ul id="attachItemActivityWrap" class="mx-attach_item_activity" style="border: 1px solid green"><!-- activity-list item-list  -->

			<?php while ( bp_activities() ) : bp_the_activity(); ?>		

				<?php bp_get_template_part( 'activity/entry' ); ?>
				<?php //require_once plugin_dir_path( __FILE__ ) . 'inc/attach_boby.php'; ?>

			<?php endwhile; ?>
			</ul>

		<?php endif; ?>

	<?php }
}

?>


<?php
	$get_attachment_items = new AttachmentItems();
	$get_attachment_items->listItems();
?>
	
