<table class="table table-striped table-condensed">
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
				<th class="hidden-phone">
					<a href="<?=base_url('clubs/view_race/' .strtolower($club->name) .'/' . $club->id . '/' . $r->id );?>">
						<?=$r->name;?>
					</a>
				</th>
			<? endif; endforeach;?>
		</tr>
	</thead>
	<tbody>
		<? foreach($points_table as $p):?>
			<tr>
				<td <?=($p->tie_fixed) ? ' rel="tooltip" class="tool-tip" data-original-title="' . $p->tie_fixed .'"' : '';?>>
					<?=$p->position;?>
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