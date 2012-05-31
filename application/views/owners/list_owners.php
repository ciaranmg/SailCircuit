<dl>
	<? foreach($owners as $owner):?>
		<button href="#delete_owner_modal" class="btn-mini sc-delete flat-button pull-right" rel="tooltip" data-original-title="Delete Owner" data-subject-title="Are you sure you want to delete the owner <?=$owner->name;?> from this boat?" data-action="<?=base_url('boats/ajax_delete_owner') . '/'. $owner->boat_id; ?>" data-subject-id="<?=$owner->id;?>" data-ajax="true">
			<i class="icon-remove"></i>
		</button>
		<dt class="editable" id="hc_edit_owner_<?=$owner->id;?>" target="<?=base_url('ajax/edit/owner/name/text') . '/' . $owner->id;?>">
			<?=$owner->name?>
		</dt>
		<dd>Phone: <span class="editable" id="hc_edit_phone_<?=$owner->id;?>" target="<?=base_url('ajax/edit/owner/phone/text') . '/' . $owner->id;?>"><?=($owner->phone =='') ? 'Click to Enter a phone number' : $owner->phone;?></span></dd>
		<dd>Email: <span class="editable" id="hc_edit_email_<?=$owner->id;?>" target="<?=base_url('ajax/edit/owner/email/text') . '/' . $owner->id;?>"><?=($owner->email == '') ? 'Click to enter an email address' : $owner->email;?></span></dd>	
	<? endforeach;?>
</dl>

<? 
	// Set up the bare bones for the modal. We'll populate the actual details using javascript.
	$data = array(
		'object_id' => '',
		'action' => 'boats/ajax_delete_owner',
		'object_type' => 'boat',
		'modal_id' => 'delete_owner_modal',
		'modal_header' => 'Confirm Delete',
		'modal_content' => 'Are you sure you want to remove this owner?',
		'referrer' => 'boats'
		);
	$this->load->view('dialogs/confirm_delete', $data); 
?>