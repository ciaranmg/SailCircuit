<table class="table table-bordered">
	<tbody>
		<? foreach($handicaps as $h):?>
			<tr>
				<th width="30%"><?=$h->name;?></th>
				<td><?=$h->value;?></td>
			</tr>
		<? endforeach; ?>
	</tbody>
</table>