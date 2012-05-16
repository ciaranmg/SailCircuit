			<table class="table table-striped">
				<thead>
					<tr>
						<th>Race Name</th>
						<th>Start Date/Time</th>
						<th class="aligncenter">Discard</th>
						<th>&nbsp;</th>
					</tr>
				</thead>
				<tbody>
					<? 
					if($races) : foreach ($races as $race): ?>
						<tr class="<?=alternator('odd', 'even');?>" action="race/show/<?=$race->id?>">
							<td>
								<a href="<?=base_url('race/show') .'/'.$race->id;?>" title="<?=$race->name?>">
									<?=$race->name?>
								</a>
							</td>
							<td>
								<?=sc_db_datetime_format($race->start_date);?>
							</td>
							<td class="aligncenter">
								<?if($race->discard == 1):?>
									<i class="icon-ok"></i>
								<? else: ?>
									<i class="icon-remove"></i>
								<? endif;?>
							</td>
							<td>
								<?
									$buttons = array(
												0 => array(
													'title' => '',
													'tooltip'=>'Input Race Data',
													'action' => 'race/input',
													'classes' => 'btn-mini',
													'parameters' => $race->id,
													'icon' => 'plus'
												),
												1 => array(
													'title' => '',
													'tooltip' => 'Delete this race',
													'action' => 'race/delete',
													'classes' => 'btn-mini',
													'parameters' => $race->id,
													'icon' => 'trash'
												)
									);
		
									$this->load->view('common/toolbar', array('buttons' => $buttons));
								?>
							</td>
						</tr>
					<? endforeach; endif; ?>
				</tbody>
			</table>