<? if(is_array($classes)): ?>
<table class="display full">
	<thead>
		<tr>
			<th>Name</th>
			<th>Races</th>
			<th>Scoring</th>
		</tr>
	</thead>
	<tbody>
		<? foreach($classes as $class): ?>
			<tr class="<?=alternator('odd', 'even');?>">
				<td>
					<a href="#classes/view/<?=$class->id?>" title="<?=$class->name?>">
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