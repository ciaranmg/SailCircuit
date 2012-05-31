<table class="table table-striped ">
	<thead>
		<tr>
			<th>Place</th>
			<th>Sail #</th>
			<th>Boat</th>
			<th>Elapsed</th>
			<? if($race->handicap_name !== 'Level'):?>
				<th>Handicap</th>
				<th>Corrected</th>
				<th>To Win</th>
			<? endif; ?>
			<th>Points</th>
			<th>Comments</th>
		</tr>
	</thead>
	<tbody>
		<? foreach($results as $r): ?>
			<tr>
				<td><?=($r->position == 0) ? '&nbsp;' : $r->position;?></td>
				<td><?=$r->sail_number;?></td>
				<td><?=$r->boat_name;?></td>
				<td><?=($r->elapsed_time == 0) ? '&nbsp;' : sec2time($r->elapsed_time);?></td>
				<? if($race->handicap_name !== 'Level'): ?>
					<td><?=($r->handicap == 0) ? '&nbsp;' : hcap_format($r->handicap, $race->handicap_name);?></td>
					<td><?=($r->corrected_time != 0) ? sec2time($r->corrected_time) : '&nbsp;';?></td>
					<td>
						<?
							if($r->corrected_time !=0){
								$sec_to_win = $r->corrected_time - $results[0]->corrected_time;
								if($sec_to_win !=0){
									$this->load->model('handicap_model');
									$fn = $race->handicap_name . '_calc';
									$to_win = $fn($sec_to_win, $r->handicap, true);
									echo sec2time($to_win);
								}
							}
						?>
					</td>
				<? endif;?>
				<td><?=($r->points != 0) ? $r->points : '&nbsp;' ;?></td>
				<td><?=($r->status !== 'completed') ? $r->status : '&nbsp;' ;?></td>
			</tr>
		<? endforeach;?>
	</tbody>
</table>