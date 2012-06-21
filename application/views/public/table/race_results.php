<table class="table table-striped table-condensed">
	<thead>
		<tr>
			<th>Points</th>
			<th>Place</th>
			<th>Sail #</th>
			<? if($class->meta['_race_columns']->value['alt_sail_number'] == 1):?>
				<th>Alt. Sail #</th>
			<? endif; ?>
			<? if($class->meta['_race_columns']->value['bow_number'] == 1):?>
				<th>Bow #</th>
			<? endif; ?>
			<th>Boat</th>
			<? if($class->meta['_race_columns']->value['elapsed'] == 1):?>
				<th>Elapsed</th>
			<? endif;?>
			<? if($class->meta['_race_columns']->value['handicap'] == 1):?>
				<th>Handicap</th>
			<? endif; ?>			
			<? if($race->handicap_name !== 'Level'):?>
				<th>Corrected</th>
			<? endif; ?>
			<? if($class->meta['_race_columns']->value['time_to_win'] == 1):?>
				<th class="hidden-phone">To Win</th>
			<? endif; ?>
			<? if($class->meta['_race_columns']->value['discarded'] == 1):?>
				<th class="hidden-phone">Discarded</th>
			<? endif; ?>
			<? if($class->meta['_race_columns']->value['age'] == 1):?>
				<th>Age</th>
			<? endif; ?>
			<? if($class->meta['_race_columns']->value['age_group'] == 1):?>
				<th>Age Group</th>
			<? endif; ?>
			<? if($class->meta['_race_columns']->value['boat_type'] == 1):?>
				<th class="hidden-phone">Boat Type</th>
			<? endif; ?>
			<? if($class->meta['_race_columns']->value['helm'] == 1):?>
				<th>Helm</th>
			<? endif; ?>
			<? if($class->meta['_race_columns']->value['crew'] == 1):?>
				<th class="hidden-phone">Crew</th>
			<? endif; ?>
			<? if($class->meta['_race_columns']->value['fleet'] == 1):?>
				<th class="hidden-phone">Fleet</th>
			<? endif; ?>
			<? if($class->meta['_race_columns']->value['owner'] == 1):?>
				<th class="hidden-phone">Owner(s)</th>
			<? endif; ?>
			<? if($class->meta['_race_columns']->value['club'] == 1):?>
				<th class="hidden-phone">Club</th>
			<? endif; ?>
			<? if($class->meta['_race_columns']->value['category'] == 1):?>
				<th class="hidden-phone">Category</th>
			<? endif; ?>
			<? if($class->meta['_race_columns']->value['length'] == 1):?>
				<th class="hidden-phone">LOA</th>
			<? endif; ?>
			<th>Comments</th>
		</tr>
	</thead>
	<tbody>
		<? foreach($results as $r): if($class->meta['_race_settings']->value['show_dnc'] != 1 && strtolower($r->status) == 'dnc'): continue; else: ?>
			<tr>
				<td><?=($r->points != 0) ? $r->points : '&nbsp;' ;?></td>
				<td><?=($r->position == 0) ? '&nbsp;' : $r->position;?></td>
				<td><?=$r->sail_number;?></td>
				<? if($class->meta['_race_columns']->value['alt_sail_number'] == 1):?>
					<td><?=(isset($r->alt_sail_number)) ? $r->alt_sail_number : '';?></td>
				<? endif; ?>
				<? if($class->meta['_race_columns']->value['bow_number'] == 1):?>
					<td><?=(isset($r->bow_number)) ? $r->bow_number : '';?></td>
				<? endif; ?>
				<td><?=$r->boat_name;?></td>
				<? if($class->meta['_race_columns']->value['elapsed'] == 1):?>
					<td><?=($r->elapsed_time == 0) ? '&nbsp;' : sec2time($r->elapsed_time);?></td>
				<? endif;?>
				<? if($class->meta['_race_columns']->value['handicap'] == 1):?>
					<td><?=($r->handicap == 0) ? '&nbsp;' : hcap_format($r->handicap, $race->handicap_name);?></td>
				<? endif;?>
				<? if($race->handicap_name !== 'Level'): ?>
					<td><?=($r->corrected_time != 0) ? sec2time($r->corrected_time) : '&nbsp;';?></td>
				<? endif;?>
				<? if($class->meta['_race_columns']->value['time_to_win'] == 1):?>
					<td class="hidden-phone">
						<?
							if($r->corrected_time !=0){
								$sec_to_win = $r->corrected_time - $results[0]->corrected_time;
								if($sec_to_win !=0){
									
									$fn = $race->handicap_name . '_calc';
									$to_win = $fn($sec_to_win, $r->handicap, true);
									echo sec2time($to_win);
								}
							}
						?>
					</td>
				<? endif; ?>
				<? if($class->meta['_race_columns']->value['discarded'] == 1):?>
					<td class="hidden-phone aligncenter"><?=($r->discarded == 1) ? '<i class="icon-ban-circle"></i>' : '';?> </td>
				<? endif; ?>
				<? if($class->meta['_race_columns']->value['age'] == 1):?>
					<td><?=(isset($r->age)) ? $r->age : '';?></td>
				<? endif; ?>
				<? if($class->meta['_race_columns']->value['age_group'] == 1):?>
					<td><?=(isset($r->age_group)) ? $r->age_group : '';?></td>
				<? endif; ?>
				<? if($class->meta['_race_columns']->value['boat_type'] == 1):?>
					<td><?=(isset($r->boat_type)) ? $r->boat_type : '';?></td>
				<? endif; ?>
				<? if($class->meta['_race_columns']->value['helm'] == 1):?>
					<td><?=(isset($r->helm)) ? $r->helm : '';?></td>
				<? endif; ?>
				<? if($class->meta['_race_columns']->value['crew'] == 1):?>
					<td><?=(isset($r->crew)) ? $r->crew : '';?></td>
				<? endif; ?>
				<? if($class->meta['_race_columns']->value['fleet'] == 1):?>
					<td><?=(isset($r->fleet)) ? $r->fleet : '';?></td>
				<? endif; ?>
				<? if($class->meta['_race_columns']->value['owner'] == 1):?>
					<td><?=(isset($r->owner)) ? $r->owner : '';?></td>
				<? endif; ?>
				<? if($class->meta['_race_columns']->value['club'] == 1):?>
					<td><?=(isset($r->club)) ? $r->club : '';?></td>
				<? endif; ?>
				<? if($class->meta['_race_columns']->value['category'] == 1):?>
					<td><?=(isset($r->category)) ? $r->category : '';?></td>
				<? endif; ?>
				<? if($class->meta['_race_columns']->value['length'] == 1):?>
					<td><?=(isset($r->length)) ? $r->length : '';?></td>
				<? endif; ?>
				<td><?=($r->status !== 'completed') ? $r->status : '&nbsp;' ;?></td>
			</tr>
		<? endif; endforeach;?>
	</tbody>
</table>