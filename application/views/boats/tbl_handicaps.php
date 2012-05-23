<? if(sizeof($handicaps) > 0):?>
<table class="table table-bordered">
	<tbody>
		<? foreach($handicaps as $h):?>
			<tr>
				<th width="30%">
					<?=$h->name;?>
				</th>
				<td>
					<?=$h->value;?>
					<button href="#delete_handicap_modal" class="btn-mini sc-delete flat-button pull-right" rel="tooltip" data-original-title="Delete Handicap" data-subject-title="Are you sure you want to delete the <?=$h->name;?> handicap from this boat?" data-action="<?=base_url('boats/ajax_delete_handicap') . '/'. $h->boat_id; ?>" data-subject-id="<?=$h->id;?>" data-ajax="true">
						<i class="icon-remove"></i>
					</button>
				</td>
			</tr>
		<? endforeach; ?>
	</tbody>
</table>
<? endif;?>

<? 
	// Set up the bare bones for the modal. We'll populate the actual details using javascript.
	$data = array(
		'object_id' => '',
		'action' => 'boats/ajax_delete_handicap',
		'object_type' => 'boat',
		'modal_id' => 'delete_handicap_modal',
		'modal_header' => 'Confirm Delete',
		'modal_content' => 'Are you sure you want to remove this handicap rating?',
		'referrer' => 'boats'
		);
	$this->load->view('dialogs/confirm_delete', $data); 
?>