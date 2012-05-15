<? if(is_array($classes)): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Name</th>
			<th>Races</th>
			<th>Scoring</th>
		</tr>
	</thead>
	<tbody>
		<? foreach($classes as $class): ?>
			<tr>
				<td>
					<a href="<?=base_url();?>classes/view/<?=$class->id?>" title="<?=$class->name?>">
						<?=$class->name?>
					</a>
				</td>
				<td>
					<?=$class->race_count?>
				</td>
				<td>
					<?=$class->system_name?>
				</td>
			</tr>
		<? endforeach; ?>
	</tbody>
</table>
<? endif; ?>