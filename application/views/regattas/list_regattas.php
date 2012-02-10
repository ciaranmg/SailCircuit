<script>
$(function() {
	$('#regattaTable').dataTable({
			"sPaginationType": "full_numbers"
	});
});
</script>

	<table class="display" id="regattaTable">
		<thead>
			<tr>
				<th>
					Name
				</th>
				<th>
					Description
				</th>
				<th>
					Start Date
				</th>
				<? if(isset($regattas[0]->club_name)): ?>
				<th>
					Club
				</th>
				<? endif; ?>
			</tr>
		</thead>
		<tbody>
			<? foreach($regattas as $regatta): ?>
			<tr class="<?=alternator('odd', 'even');?>">	
				<td>
					<a href="#regatta/view/<?=$regatta->id?>" title="<?=$regatta->name;?>">
						<?=$regatta->name;?>
					</a>
				</td>
				<td>
					<?=$regatta->description?>
				</td>
				<td>
					<?=sc_date_format($regatta->start_date);?>
				</td>
				<? if(isset($regatta->club_name)): ?>
				<td>
					<?=anchor('club/view/'.$regatta->club_id, $regatta->club_name);?>
				</td>
				<? endif;?>
			</tr>
			<? endforeach; ?>
		</tbody>
	</table>