<?php
/*
* Class for creating buttons for attaching and detaching an item.
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

class AttachButton
{

	public function create_form()
	{ 

		$name_attach_button = 'attach-' . bp_get_activity_id();
		
		$name_detach_button = 'detach-' . bp_get_activity_id();

		?>		
		
		<div class="mx-attach_forms_wrap">

			<form method="post" data-attach="attach" class="mx-attach_form" id="form_attachment-<? echo bp_get_activity_id();?>">

				<input type="hidden" name="id_item" value="<?php echo bp_get_activity_id(); ?>" />
				
				<button type="submit" class="mx-attach_submit" title="Attach" name="<? echo $name_attach_button?>"><i class="fa fa-object-group"></i></button>

		    </form>

		    <form method="post" data-attach="detach" class="mx-detach_form" id="form_detachment-<? echo bp_get_activity_id();?>">

				<input type="hidden" name="id_item" value="<?php echo bp_get_activity_id(); ?>" />
				
				<button type="submit" class="mx-detach_submit" title="Detach" name="<? echo $name_detach_button?>"><i class="fa fa-object-ungroup"></i></button>

		    </form>

		</div>

	<?php }

}