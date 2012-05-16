<? if(sizeof($handicaps) > 0):?>
<table class="table table-bordered">
	<tbody>
		<? foreach($handicaps as $h):?>
			<tr>
				<th width="30%"><?=$h->name;?></th>
				<td>
					<?=$h->value;?>
					<button class="sc-quick-delete flat-button pull-right" data-action="<?=base_url('boats/delete_handicap')?>" data-target-id="ctr-ajax-handicaps">
						<i class="icon-remove"></i>
					</button>
				</td>
			</tr>
		<? endforeach; ?>
	</tbody>
</table>
<? endif;?>