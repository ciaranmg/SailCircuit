<? /*
	Delete record Dialog.

	Parameters:
		array(
			'object_id' => 0,
			'object_type' => '',
			'action' => '',
			'modal_id' =>'',
			'modal_header' => '',
			'modal_content' => '',
		)
*/?>
<div class="modal fade" id="<?=$modal_id;?>">
	<div class="modal-header">
		<button class="close" data-dismiss="modal">×</button>
		<h3><?=$modal_header;?></h3>
	</div>
	<div class="modal-body">
		<?=$modal_content;?>
	</div>
	<div class="modal-footer">
		<?  
			$hidden = array(
					'action' => $action,
					'submit' => 'submit',
					'object_id' => $object_id,

				);
			if(isset($referrer)) $hidden['referrer'] = $referrer;

			echo form_open($action, '', $hidden);
		?>
			<button class="btn btn-danger" type="submit" name="confirm_delete" value="form_submit"><i class="icon-trash icon-white"></i> Yes</button>
			<button class="btn" data-dismiss="modal"><i class="icon-remove"></i> No</button>
		<?
			echo form_close();
		?>		
		
	</div>
</div>