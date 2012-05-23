<table class="table table-striped">
	<thead>
		<tr>
			<th>Sail No.</th>
			<th>Name</th>
			<th>Owner(s)</th>
			<th>Type</th>
			<? if(isset($show_handicap)):?>
			<th class="alignright"><?=(isset($class->handicap_name)) ? $class->handicap_name : 'Handicap' ;?></th>
			<? endif;?>
			<th class="alignright">Length (m)</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<? 
		if($boats) : foreach ($boats as $boat): ?>
			<tr action="boat/show/<?=$boat->id?>">
				<td>
					<a href="<?=base_url('boats/view') . '/' .$boat->id?>" title="<?=$boat->name?>">
						<?=$boat->sail_number?>
					</a>
				</td>
				<td><?=$boat->name?></td>
				<td class="hidden-phone"><?=$boat->owner;?></td>
				<td class="hidden-phone"><?=$boat->model?></td>
				<? if(isset($show_handicap)):?>
				<td class="editable alignright" id="hc_edit_handicap_<?=$boat->id;?>" target="<?=base_url('ajax/edit/classes/handicap/text') . '/' . $boat->field_id;?>">
					<?=number_format(floatval($boat->handicap), 3, '.', ',');?>
				</td>
				<? endif;?>
				<td class="alignright"><?=number_format(floatval($boat->length), 2, '.', ',');?></td>
				<td>
					<?
						$boat_buttons = array(
									array(
										'title' => '',
										'action' => 'boats/view',
										'classes' => 'btn-mini',
										'parameters' => $boat->id,
										'icon' => 'eye-open',
										'attributes' => 'data-original-title="View '. $boat->name .'"'
									)
								);
						$this->load->view('common/toolbar', array('buttons' => $boat_buttons));
					?>
				</td>
			</tr>
		<? endforeach; endif; ?>
	</tbody>
</table>