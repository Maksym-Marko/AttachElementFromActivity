<?php
/**
* @package AttachElementFromActivity
*/

class AttachButton
{	

	public function create_form()
	{

		$new_crud = new CrudAttachmentItems();

		$name_attach_button = 'attach-' . bp_get_activity_id();
		$name_deattach_button = 'deattach-' . bp_get_activity_id();

		$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

		if( !empty( $_POST ) ){

			// attach item
			if( isset( $_POST[$name_attach_button] ) ){
				if( $new_crud->item_add( bp_get_activity_id() ) ){
					echo '<h2>Attached</h2>';
					echo "<script>";
					echo "window.location.href = '" . $actual_link . "?atach=" . bp_get_activity_id() . "'";
					echo "</script>";
				}
			}

			// deattach item
			if( isset( $_POST[$name_deattach_button] ) ){
				if( $new_crud->item_delete( bp_get_activity_id() ) ){
					echo '<h2>DeAttached</h2>';
					echo "<script>";
					echo "window.location.href = '" . $actual_link . "?deatach=" . bp_get_activity_id() . "'";
					echo "</script>";
				}
			}

		}?>
		
		<div class="mx-attach_forms_wrap">
			<form method="post" class="mx-attach_form" id="form_attachment-<?=bp_get_activity_id();?>">
				<input type="hidden" name="attach_id" value="<?=bp_get_activity_id();?>">
				<button type="submit" class="mx-attach_submit" title="Закрепить" name="<?=$name_attach_button?>"><i class="fas fa-object-group"></i></button>
		    </form>

		    <form method="post" class="mx-deattach_form" id="form_deattachment-<?=bp_get_activity_id();?>">
				<input type="hidden" name="deattach_id" value="<?=bp_get_activity_id();?>">
				<button type="submit" class="mx-deattach_submit" title="Открепить" name="<?=$name_deattach_button?>"><i class="far fa-object-ungroup"></i></button>
		    </form>
		</div>

	<?php }

}