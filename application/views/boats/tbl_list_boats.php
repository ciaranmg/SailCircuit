			<script>
			$(function() {
				$('#boatTable').dataTable({
						"sPaginationType": "full_numbers"
				});
			});
			</script>
			
			<table class="display" id="boatTable">
				<thead>
					<tr>
						<th>Sail No.</th>
						<th>Name</th>
						<th>Type</th>
					</tr>
				</thead>
				<tbody>
					<? 
					if($boats) : foreach ($boats as $boat): ?>
						<tr class="<?=alternator('odd', 'even');?>" action="boat/show/<?=$boat->id?>">
							<td>
								<a href="#boat/show/<?=$boat->id?>" title="<?=$boat->name?>">
									<?=$boat->sail_number?>
								</a>
							</td>
							<td><?=$boat->name?></td>
							<td><?=$boat->model?></td>
						</tr>
					<? endforeach; endif; ?>
				</tbody>
			</table>