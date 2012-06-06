<? $this->load->view('public/header');?>
<? if(isset($regatta)):?>
	<section class="portlet leading span6">
		<header>
			<h2><?=$regatta->name;?></h2>
			<div class="clearfix"></div>
		</header>
		<section>
			<table class="table table-bordered">
				<tr>
					<th class="">Start Date</th>
					<td class="editable" id="fc_start_date" target="<?=base_url('ajax/edit/regatta/start_date/date') . '/' . $regatta->id;?>">
						<?=sc_date_format($regatta->start_date);?>
					</td>
				</tr>
				<tr>
					<th class="">End Date</th>
					<td class="editable" id="fc_end_date" target="<?=base_url('ajax/edit/regatta/end_date/date') . '/' . $regatta->id;?>"><?=sc_date_format($regatta->end_date);?></td>
				</tr>
				<tr>
					<th class="">Description</th>
					<td class="editable" id="fc_description" target="<?=base_url('ajax/edit/regatta/description/textarea') . '/' . $regatta->id;?>"><?=$regatta->description;?></td>
				</tr>
			</table>
		</section>
	</section>
<? endif;?>
<section class="portlet leading span6">
	<header>
		<h2>Classes</h2>
		<div class="clearfix"></div>
	</header>
	<section>
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
								<a href="<?=base_url('clubs/view_class/' . $club->name . '/'. $club->id .'/' . $class->id);?>" title="<?=$class->name?>">
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
	</section>
</section>
<? $this->load->view('public/footer');?>