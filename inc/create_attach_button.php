<?php
/**
* @package AttachElementFromActivity
*/

class AttachButton
{	

	public function create_form()
	{ 

		$name_attach_button = 'attach-' . bp_get_activity_id();
		
		$name_deattach_button = 'deattach-' . bp_get_activity_id();

		?>		
		
		<div class="mx-attach_forms_wrap">
			<form method="post" action="<?php echo home_url(); ?>/" class="mx-attach_form" id="form_attachment-<?=bp_get_activity_id();?>">
				<input type="hidden" name="attach_id" value="<?=bp_get_activity_id();?>">
				<button type="submit" class="mx-attach_submit" title="Закрепить" name="<?=$name_attach_button?>"><i class="fas fa-object-group"></i></button>
		    </form>

		    <form method="post" action="<?php echo home_url(); ?>/" class="mx-deattach_form" id="form_deattachment-<?=bp_get_activity_id();?>">
				<input type="hidden" name="deattach_id" value="<?=bp_get_activity_id();?>">
				<button type="submit" class="mx-deattach_submit" title="Открепить" name="<?=$name_deattach_button?>"><i class="far fa-object-ungroup"></i></button>
		    </form>
		</div>

	<?php }

	public function get_post_arr()
	{ 

		$new_crud = new CrudAttachmentItems();

		if( !empty( $_POST ) ){

			// attach item
			if( isset( $_POST['attach_id'] ) ){
				if( $new_crud->item_add( $_POST['attach_id'] ) ){
					echo '<h2>Закреплено!</h2>';
					echo "<script>";
					echo "window.location.href = '" . home_url() . "/?atach=" . $_POST['attach_id'] . "'";
					echo "</script>";
				}
			}

			// deattach item
			if( isset( $_POST['deattach_id'] ) ){
				if( $new_crud->item_delete( $_POST['deattach_id'] ) ){
					echo '<h2>Откреплено</h2>';
					echo "<script>";
					echo "window.location.href = '" . home_url() . "/?deatach=" . $_POST['deattach_id'] . "'";
					echo "</script>";
				}
			}

		}

	}

}