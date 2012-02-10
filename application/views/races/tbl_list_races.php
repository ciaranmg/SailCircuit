			<script>
			/* $(function() {
				$('#raceTable').dataTable({
						"sPaginationType": "full_numbers"
				});
			}); */
			</script>
			
			<table class="display" id="raceTable">
				<thead>
					<tr>
						<th>Race Name</th>
						<th>Start Date/Time</th>
						<th>Discard</th>
						<th>&nbsp;</th>
					</tr>
				</thead>
				<tbody>
					<? 
					if($races) : foreach ($races as $race): ?>
						<tr class="<?=alternator('odd', 'even');?>" action="race/show/<?=$race->id?>">
							<td>
								<a href="#race/show/<?=$race->id?>" title="<?=$race->name?>">
									<?=$race->name?>
								</a>
							</td>
							<td>
								<?=sc_db_datetime_format($race->start_date);?>
							</td>
							<td>
								<?=$race->discard?>
							</td>
							<td>
								<?
									$buttons = array(
												0 => array(
													'title' => '',
													'tooltip'=>'Input Race Data',
													'action' => 'race/input',
													'classes' => 'icon-only',
													'parameters' => $race->id,
													'icon' => '78'
												),
									);
								
									$this->load->view('common/toolbar', array('buttons' => $buttons));
								?>
							</td>
						</tr>
					<? endforeach; endif; ?>
				</tbody>
			</table>