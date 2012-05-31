<?
	$hidden = array('submit' => 'submit', 'race_id' => $race->id);
?>
<?if(isset($message)):?>
	<div class="alert fade in">
		<button class="close" data-dismiss="alert">×</button>
		<?=$message;?>
	</div>
<? endif; ?>

<?if(isset($err_message)):?>
	<div class="alert alert-error fade in">
		<button class="close" data-dismiss="alert">×</button>
		<?=$err_message;?>
	</div>
<? endif; ?>
<?=form_open(base_url('/race/edit/' .$race->id), array('class' => 'frm-ajax-save'), $hidden);?>
<button class="close btn-ajax-cancel">×</button>
<table class="table table-striped ">
	<thead>
		<tr>
			<th>Finish Place</th>
			<th>Sail #</th>
			<? // <th>Boat</th> ?>
			<th>Elapsed</th>
			<? if($race->handicap_name !== 'Level'):?>
				<th>Handicap</th>
				<th>Corrected</th>
			<? endif; ?>
			<th>Points</th>
			<th>Comments</th>
		</tr>
	</thead>
	<tbody>
		<? foreach($results as $r): ?>
			<tr>
				<td>
					<?=($r->position == 0) ? '&nbsp;' : $r->position;?>
					<?=form_hidden('line_id['.$r->id.']', $r->id);?>
				</td>
				<td><?=$r->sail_number;?></td>
				<? /* <td><?=$r->boat_name;?></td> */?>
				<td>
					<?=form_input('elapsed_time['.$r->id.']', sec2time($r->elapsed_time), 'class="input-small"');?>
				</td>
				<? if($race->handicap_name !== 'Level'): ?>
					<td>
						<?=form_input('handicap['.$r->id.']', hcap_format($r->handicap, $race->handicap_name), 'class="input-tiny"');?>
					</td>
					<td>
						<?=($r->corrected_time != 0) ? sec2time($r->corrected_time) : '&nbsp;';?>
					</td>
				<? endif;?>
				<td>
					<?=form_input('points['.$r->id.']', $r->points, 'class="input-tiny required"');?>
				</td>
				<td>
					<?=form_dropdown('status['.$r->id.']', $this->config->item('race_status_options'), strtolower($r->status), 'class="input-small"');?>
				</td>
			</tr>
		<? endforeach;?>
	</tbody>
</table>
<div class="btn-group pull-right">
	<button type="submit" class="btn btn-primary btn-ajax-save">Save</button>
	<button class="btn btn-ajax-cancel">Cancel</button>
</div>
<div class="clearfix"></div>
<?=form_close();?>