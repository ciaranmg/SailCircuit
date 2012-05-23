	<table class="table table-striped" id="regattaTable">
		<thead>
			<tr>
				<th>
					Name
				</th>
				<th class="hidden-phone">
					Description
				</th>
				<th>
					Start Date
				</th>
				<th>
					End Date
				</th>
				<? if(isset($regattas[0]->club_name)): ?>
					<th>
						Club
					</th>
				<? endif; ?>
				<th>
					Classes
				</th>
				<th>
				</th>
				
			</tr>
		</thead>
		<tbody>
			<? foreach($regattas as $regatta): ?>
			<tr class="<?=($regatta->end_date < time()) ? 'inactive' : '';?>">
				<td>
					<a href="<?=base_url('regatta/view') .'/'. $regatta->id?>" title="<?=$regatta->name;?>">
						<?=$regatta->name;?>
					</a>
				</td>
				<td class="hidden-phone">
					<?=$regatta->description?>
				</td>
				<td>
					<?=sc_date_format($regatta->start_date);?>
				</td>
				<td class="hidden-phone">
					<?=sc_date_format($regatta->end_date);?>
				</td>
				<? if(isset($regatta->club_name)): ?>
				<td>
					<?=anchor('club/view/'.$regatta->club_id, $regatta->club_name);?>
				</td>
				<? endif;?>
				<td>
					<?=$regatta->classes;?>
				</td>
				<td>
					<div class="btn-group">
						<a data-original-title="View Regatta <?=$regatta->name;?>" rel="tooltip" class="btn btn-mini" href="regatta/view/<?=$regatta->id;?>">
							<i class="icon-eye-open"></i>
						</a>
						<a data-original-title="Delete Regatta <?=$regatta->name;?>" rel="tooltip" data-subject-title="Are you Sure you want to Delete <?=$regatta->name;?>? All classes and races will be deleted too. This cannot be undone" data-subject-id="<?=$regatta->id;?>" class="btn btn-mini sc-delete" href="#delete_regatta_modal">
							<i class="icon-trash"></i>
						</a>
						<a data-original-title="Open Public Regatta Page" class="btn btn-mini" href="<?=base_url('display/regatta') . '/' . $regatta->id;?>" target="_blank">
							<i class="icon-share"></i>
						</a>
					</div>
				</td>
			</tr>
			<? endforeach; ?>
		</tbody>
	</table>
	<?=$this->pagination->create_links();?>
	<? 
		// Set up the bare bones for the modal. We'll populate the actual details using javascript.
		$data = array(
			'object_id' => '',
			'action' => 'regatta/delete',
			'object_type' => 'regatta',
			'modal_id' => 'delete_regatta_modal',
			'modal_header' => 'Confirm Delete',
			'modal_content' => '',
			'referrer' => 'regatta'
			);
		$this->load->view('dialogs/confirm_delete', $data); 
	?>