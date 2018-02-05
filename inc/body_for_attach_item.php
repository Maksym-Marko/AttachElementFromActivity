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
		
		$array_attachment_elements = mx_list_attachment_items( $this->table_name_slug );

		?>

		<?php if ( bp_has_activities( 'display_comments=threaded&show_hidden=true&include=0,' . $array_attachment_elements ) ) : ?>

		<div class="activity" id="attachItemActivityWrap">

			<h2>Закрепленные записи</h2>
			<ul class="mx-attach_item_activity"><!--activity-list item-list  -->

				<?php while ( bp_activities() ) : bp_the_activity(); ?>

					<!--attach-->
					<?php bp_get_template_part( 'activity/entry' ); ?>
					
					<?php
					/*
					* If you want to customize attachment elements, you can edit this file. After power on.
					*/
					//include('attach_boby.php'); ?>

				<?php endwhile; ?>

			</ul>
		</div>

		<?php endif; ?>

	<?php }
}

?>


<?php
	$get_attachment_items = new AttachmentItems();
	$get_attachment_items->listItems();
?>
	
