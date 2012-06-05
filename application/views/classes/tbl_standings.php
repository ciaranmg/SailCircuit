<table class="table table-striped">
	<thead>
		<tr>
			<th>Position</th>
			<th>Sail #</th>
			<th>Boat</th>
			<th class="hidden-phone">Owner(s)</th>
			<? if($class->handicap_name != 'Level'):?>
				<th>Handicap</th>
			<? endif;?>
			<th>Series Points</th>
			<? foreach($races as $r): if($r->status == 'completed'):?>
				<th class="hidden-phone"><?=$r->name;?></th>
			<? endif; endforeach;?>
		</tr>
	</thead>
	<tbody>
		<? foreach($points_table as $p):?>
			<tr>
				<td>
					<?=($p->tie_fixed) ? '<span class="tooltip" data-original-title="' . $p->tie_fixed .'">' : '';?>
						<?=$p->position;?>
					<?=($p->tie_fixed) ? '</span>' : '';?>
				</td>
				<td><?=$p->sail_number;?></td>
				<td><?=$p->name;?></td>
				<td class="hidden-phone"><?=$p->owner;?></td>
				<td><?=hcap_format($p->handicap, $class->handicap_name);?></td>
				<td><?=$p->series_points;?></td>
				<? foreach($p->race_results as $rr):?>
					<td class="hidden-phone <?=($rr->discarded == 1) ? 'inactive' : '' ;?>"><?=$rr->points;?></td>
				<? endforeach;?>
			</tr>
		<? endforeach;?>
	</tbody>
</table>