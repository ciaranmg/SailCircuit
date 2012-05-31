<table class="table table-striped">
	<thead>
		<tr>
			<th>Race</th>
			<th>Date</th>
			<th>Place/Status</th>
		</tr>
	</thead>
	<tbody>
		<? foreach($recent_races as $rr):?>
			<tr>
				<td><a href="<?=base_url('/race/view/'.$rr->id);?>"><?=$rr->name;?></a></td>
				<td><?=sc_date_format($rr->start_date);?></td>
				<td>
					<?
						if($rr->position == 0){
							echo $rr->status;
						}else{
							echo $rr->position;
						}
					?>
				</td>
			</tr>
		<? endforeach;?>
	</tbody>
</table>