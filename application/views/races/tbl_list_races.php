			<table class="table table-striped">
				<thead>
					<tr>
						<th>Race Name</th>
						<th>Start Date/Time</th>
						<th class="aligncenter">Discardable</th>
						<th>&nbsp;</th>
					</tr>
				</thead>
				<tbody>
					<? 
					if($races) : foreach ($races as $race): ?>
						<tr class="<?=alternator('odd', 'even');?>" action="race/show/<?=$race->id?>">
							<td class="editable" id="hc_edit_race_name<?=$race->id;?>" target="<?=base_url('ajax/edit/race/name/text') . '/' . $race->id;?>">
								<?=$race->name?>
							</td>
							<td class="editable" id="hc_edit_race_datetime_<?=$race->id;?>" target="<?=base_url('ajax/edit/race/start_date/datetime/'.$race->id);?>">
								<?=sc_date_format($race->start_date) . ' ' . sc_time_format($race->start_date);?>
							</td>
							<td class="editable aligncenter" id="hc_edit_race_discard<?=$race->id;?>" target="<?=base_url('ajax/edit/race/discard/checkbox') . '/' . $race->id;?>">
								<?if($race->discard == 1):?>
									<i class="icon-ok"></i>
								<? else: ?>
									<i class="icon-remove"></i>
								<? endif;?>
							</td>
							<td>
								<?
								unset($buttons);
									if($race->status == 'open'){
										$buttons[] = array(
													'title' => '',
													'tooltip'=>'Input Race Data',
													'action' => 'race/input',
													'classes' => 'btn-mini',
													'parameters' => $race->id,
													'icon' => 'plus',
													'attributes' => 'data-original-title="Input Race Data For '. $race->name .'" rel="tooltip"'
												);
									}else{
										$buttons[] = array(
													'title' => '',
													'tooltip'=>'View Race Data',
													'action' => 'race/view',
													'classes' => 'btn-mini',
													'parameters' => $race->id,
													'icon' => 'eye-open',
													'attributes' => 'data-original-title="View Race Results For '. $race->name .'" rel="tooltip"'
												);
									}
									$buttons[] = array(
													'type' => 'button',
													'title' => '',
													'tooltip' => 'Delete this race',
													'action' => 'classes/edit',
													'classes' => 'btn-mini sc-delete',
													'parameters' => $race->id,
													'icon' => 'trash',
													'attributes' => 'data-action="'.base_url('race/ajax_delete_race/'.$race->class_id) .'"
																	 data-subject-id="'.$race->id .'"
																	 href="#delete_race_modal" 
																	 data-original-title="Delete '. $race->name .'"
																	 data-ajax="true" 
																	 data-toggle="modal" 
																	 data-target="#delete_race_modal" 
																	 data-subject-title="Are you sure you want to delete ' .$race->name .' <br>All results for this race will be lost." 
																	 rel="tooltip"'
												);
		
									$this->load->view('common/toolbar', array('buttons' => $buttons));
									unset($buttons);
								?>
							</td>
						</tr>
					<? endforeach; endif; ?>
				</tbody>
			</table>
<?			
	$confirm_race_delete = array(
			'object_id' => '',
			'action' => 'classes/ajax_delete_race',
			'object_type' => 'race',
			'modal_id' =>'delete_race_modal',
			'modal_header' => 'Confirm Delete',
			'modal_content' => 'Are you sure you want to delete this race?',
			'referrer' => 'classes'
		);
	$this->load->view('dialogs/confirm_delete', $confirm_race_delete);
?>