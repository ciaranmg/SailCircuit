<table class="table table-striped table-condensed">
	<thead>
		<tr>
			<th>Position</th>
			<th>Series Points</th>
			<th>Sail #</th>
			<? if($class->meta['_class_columns']->value['alt_sail_number'] == 1):?>
				<th class="hidden-phone">Alt Sail #</th>
			<? endif;?>
			<? if($class->meta['_class_columns']->value['bow_number'] == 1):?>
				<th class="hidden-phone">Bow #</th>
			<? endif;?>
			<? if($class->meta['_class_columns']->value['boat_name'] == 1):?>
				<th>Boat</th>
			<? endif;?>
			<? if($class->meta['_class_columns']->value['handicap'] == 1):?>
				<th>Handicap</th>
			<? endif;?>
			<? if($class->meta['_class_columns']->value['boat_type'] == 1):?>
				<th class="hidden-phone">Boat Type</th>
			<? endif;?>
			<? if($class->meta['_class_columns']->value['age'] == 1):?>
				<th>Age</th>
			<? endif;?>
			<? if($class->meta['_class_columns']->value['age_group'] == 1):?>
				<th>Age Group</th>
			<? endif;?>
			<? if($class->meta['_class_columns']->value['helm'] == 1):?>
				<th>Helm</th>
			<? endif;?>
			<? if($class->meta['_class_columns']->value['crew'] == 1):?>
				<th>Crew</th>
			<? endif;?>
			<? if($class->meta['_class_columns']->value['fleet'] == 1):?>
				<th>Fleet</th>
			<? endif;?>
			<? if($class->meta['_class_columns']->value['owner'] == 1):?>
				<th>Owner(s)</th>
			<? endif;?>
			<? if($class->meta['_class_columns']->value['club'] == 1):?>
				<th>Club</th>
			<? endif;?>
			<? if($class->meta['_class_columns']->value['category'] == 1):?>
				<th>Category</th>
			<? endif;?>
			<? if($class->meta['_class_columns']->value['length'] == 1):?>
				<th>LOA</th>
			<? endif;?>
			<? if($class->meta['_class_columns']->value['class'] == 1):?>
				<th>Class</th>
			<? endif;?>
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
				<td><?=$p->series_points;?></td>
				<td><?=$p->sail_number;?></td>
				<? if($class->meta['_class_columns']->value['alt_sail_number'] == 1):?>
					<td class="hidden-phone"><?=(isset($p->alt_sail_number)) ? $p->alt_sail_number : '' ;?></td>
				<? endif;?>
				<? if($class->meta['_class_columns']->value['bow_number'] == 1):?>
					<td class="hidden-phone"><?=(isset($p->bow_number)) ? $p->bow_number : '' ;?></td>
				<? endif;?>
				<? if($class->meta['_class_columns']->value['boat_name'] == 1):?>
					<td><?=$p->name;?></td>
				<? endif;?>
				<? if($class->meta['_class_columns']->value['handicap'] == 1):?>
					<td><?=hcap_format($p->handicap, $class->handicap_name);?></td>
				<? endif;?>
				<? if($class->meta['_class_columns']->value['boat_type'] == 1):?>
					<td class="hidden-phone"><?=$p->boat_type;?></td>
				<? endif;?>
				<? if($class->meta['_class_columns']->value['age'] == 1):?>
					<td><?=(isset($p->age)) ? $p->age : '' ;?></td>
				<? endif;?>
				<? if($class->meta['_class_columns']->value['age_group'] == 1):?>
					<td><?=(isset($p->age_group)) ? $p->age_group : '' ;?></td>
				<? endif;?>
				<? if($class->meta['_class_columns']->value['helm'] == 1):?>
					<td><?=(isset($p->helm)) ? $p->helm : '' ;?></td>
				<? endif;?>
				<? if($class->meta['_class_columns']->value['crew'] == 1):?>
					<td><?=(isset($p->crew)) ? $p->crew : '' ;?></td>
				<? endif;?>
				<? if($class->meta['_class_columns']->value['fleet'] == 1):?>
					<td><?=(isset($p->fleet)) ? $p->fleet : '' ;?></td>
				<? endif;?>
				<? if($class->meta['_class_columns']->value['owner'] == 1):?>
					<td><?=(isset($p->owner)) ? $p->owner : '' ;?></td>
				<? endif;?>
				<? if($class->meta['_class_columns']->value['club'] == 1):?>
					<td><?=(isset($p->club)) ? $p->club : '' ;?></td>
				<? endif;?>
				<? if($class->meta['_class_columns']->value['category'] == 1):?>
					<td><?=(isset($p->category)) ? $p->category : '' ;?></td>
				<? endif;?>
				<? if($class->meta['_class_columns']->value['length'] == 1):?>
					<td><?=(isset($p->length)) ? $p->length : '' ;?></td>
				<? endif;?>
				<? if($class->meta['_class_columns']->value['class'] == 1):?>
					<td><?=(isset($p->class)) ? $p->class : '' ;?></td>
				<? endif;?>
				<? foreach($p->race_results as $rr):?>
					<td class="hidden-phone <?=($rr->discarded == 1) ? 'inactive' : '' ;?>"><?=$rr->points;?></td>
				<? endforeach;?>
			</tr>
		<? endforeach;?>
	</tbody>
</table>