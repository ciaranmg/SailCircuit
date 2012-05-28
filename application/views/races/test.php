<table width="100%" border="1" cellpadding="4">
	<thead>
		<tr>
			<th>Points</th>
			<th>Sail Num</th>
			<th>Boat ID</th>
			<th>ID</th>
			<th>Race ID</th>
			<th>Elapsed</th>
			<th>Handicap</th>
			<th>Corrected</th>
			<th>Finish Position</th>
			
			<th>Status</th>
		</tr>
	</thead>
<? foreach($processed as $p) :?>
	<tr>
		<td><?=$p->points?></td>
		<td><?=$p->sail_number?></td>
		<td><?=$p->boat_id?></td>
		<td><?=$p->id?></td>
		<td><?=$p->race_id?></td>
		<td><?=sec2time($p->elapsed_time)?></td>
		<td><?=($p->handicap) ? $p->handicap : '&nbsp;';?></td>
		<td><?=sec2time($p->corrected_time)?></td>
		<td><?=($p->position) ? $p->position : '&nbsp;';?></td>
		
		<td><?=$p->status?></td>
	</tr>
<? endforeach;?>
</table>