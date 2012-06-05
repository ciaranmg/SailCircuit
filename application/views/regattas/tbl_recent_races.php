<table class="table table-striped">
	<thead>
		<tr>
			<th>Race</th>
			<th>Date</th>
			<th>Competitors</th>
		</tr>
	</thead>
	<tbody>
		<? foreach($recent_races as $rr):?>
			<tr>
				<td><a href="<?=base_url('/race/view/'.$rr->id);?>"><?=$rr->name;?></a></td>
				<td><?=sc_date_format($rr->start_date);?></td>
				<td><?=$rr->competitors;?></td>
			</tr>
		<? endforeach;?>
	</tbody>
</table>