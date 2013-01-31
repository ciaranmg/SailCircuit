<? $this->firephp->log($entries); ?>
<div class="step2">
	<div class="hidden">
		<input type="hidden" value="confirm" id="confirm" name="confirm">
		<?=form_hidden('race_id', $race->id);?>
		<?=form_hidden('handicap_id', $race->handicap_id);?>
		<?=form_hidden('race_date', $race_date);?>
		<?=form_hidden('race_time', $race_time);?>
		<?=form_hidden('timer', $timer);?>
	</div>
	<div id="tbl-race-input">
		<h2><?=$race->name;?> <small><?=$race_date;?> <?=$race_time;?></small> </h2>
		<div>Handicap System: <span class="label label-info"><?=$race->handicap_name;?></span></div>
		<div class="race-info">
			<span class="badge badge-info"><?=$count->total;?></span> Race Entries
			<span class="badge badge-success"><?=$count->found;?></span> Found
			<? if($count->matches > 0):?>
				<span class="badge badge-warning"><?=$count->matches;?></span> With Multiple Matches
			<? endif; ?>
			<? if($count->not_found > 0):?>
				<span class="badge badge-important"><?=$count->not_found;?></span> Not Found
			<? endif; ?>
		</div>
	</div>
	<table class="table">
		<thead>
			<tr>
				<td>Keep</td>
				<td>Sail #</td>
				<td>Boat</td>
				<td><?=($timer == 'elapsed') ? 'Elapsed' : 'Finish';?> Time</td>
				<td>Status</td>
			</tr>
		</thead>
		<tbody>
			<? foreach($entries as $entry): if($entry->boat !== false):?>
				<tr>
					<td><?=form_checkbox('entry[]', $entry->id, true);?></td>

					<td>
						<?=$entry->sail_number;?>
						<?=form_hidden('entry_sail_number_'.$entry->id, $entry->sail_number);?>
					</td>

					<td>
						<? if(isset($entry->boat->id)):?> 
							<?=form_hidden('entry_boat_id_'.$entry->id, $entry->boat->id);?>
							<?=$entry->boat->name;?>
						<? else: ?>
							<?
								foreach($entry->boat as $b){
									$options[$b->id] = $b->name . ' ' .$b->sail_number;
								}
							
								echo form_dropdown('entry_boat_id_'.$entry->id, $options);
							?>
						<? endif; ?>
					</td>

					<td>
						<? 
							if(isset($entry->date)):
								$this->firephp->log($entry);
								echo form_input('finish_date_' . $entry->id, $entry->date, 'class="input-small datepicker"');
								echo form_input('finish_time_' . $entry->id, $entry->time, 'class="input-small"');
							 else: 
								echo form_input('finish_time_' . $entry->id, $entry->time, 'class="input-small"');
							endif; 
						?>
					</td>

					<td>
						<? 
							if($entry->status) { 
								echo form_dropdown('entry_status_' . $entry->id, $this->config->item('race_status_options'), strtolower($entry->status), 'class="input-small"');
							}else{
								echo "Completed";
								echo form_hidden('entry_status_' . $entry->id, 'completed');
							}
						?>
					</td>
				</tr>
			<? else:?>
				<tr class="error">
					<td><?=form_checkbox(array('name' => 'entry[]','value' => $entry->id, 'checked' => false, 'class'=> 'disabled', 'disabled' => 'disabled'));?></td>
					<td><?=$entry->sail_number?></td>
					<td>Not Found</td>
					<td>
						<?
							if(isset($boat->date)):
								echo form_input('finish_date_'.$entry->id, $entry->date, 'class="input-small disabled" disabled="disabled"');
								echo form_input('finish_time_'.$entry->id, $entry->time, 'class="input-small disabled" disabled="disabled"');
							else:
								echo form_input('finish_time_'.$entry->id, $entry->time, 'class="input-small disabled" disabled="disabled"');
							endif;
						?>
					</td>
					<td>&nbsp;</td>
				</tr>
			<? endif; endforeach;?>
		</tbody>
	</table>
</div>