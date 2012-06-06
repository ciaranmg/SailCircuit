<? $this->load->view('public/header');?>
<?if($points_table):?>
	<section class="portlet span12 leading">
		<header>
			<h2>Standings</h2>
			<div class="clearfix"></div>
		</header>
		<section>
			<? $this->load->view('public/table/standings');?>
		</section>
	</section>
<? endif;?>
</div>  <!-- Ending the row -->
<div class="row-fluid">
	<? if(isset($class)):?>
		<section class="portlet span7 leading">
			<header>
				<h2>Class Information</h2>
				<div class="clearfix"></div>
			</header>
			<section>
				<table class="table table-bordered">
					<tr>
						<th>Discards</th>
						<td><?=$class->discards;?></td>
					</tr>
					<tr>
						<th>Minimum number of races Before Discard</th>
						<td><?=$class->min_races_discard;?></td>
					</tr>
					<tr>
						<th>Rating System</th>
						<td><?=$class->handicap_name;?></td>
					</tr>
					<tr>
						<th>Tiebreak System</th>
						<td><?=$class->ties_name;?></td>
					</tr>
					<tr>
						<th>Scoring System</th>
						<td><?=$class->scoring_name;?></td>
					</tr>
				</table>
			</section>
		</section>
	<? endif;?>
	<? if(isset($races)):?>
		<section class="portlet span5 leading">
			<header>
				<h2>Races</h2>
				<div class="clearfix"></div>
			</header>
			<section>
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Race Name</th>
							<th>Start Date/Time</th>
							<th class="aligncenter">Discardable</th>
						</tr>
					</thead>
					<tbody>
						<? 
						if($races) : foreach ($races as $race): ?>
							<tr>
								<td>
									<? if($race->status =='completed'): ?>
										<a href="<?=base_url('clubs/view_race/' .strtolower($club->name) .'/' . $club->id . '/' . $race->id );?>">
											<?=$race->name?>
										</a>
									<? else: ?>
										<?=$race->name;?>
									<? endif;?>
								</td>
								<td>
									<?=sc_date_format($race->start_date) . ' ' . sc_time_format($race->start_date);?>
								</td>
								<td class="aligncenter">
									<?if($race->discard == 1):?>
										<i class="icon-ok"></i>
									<? else: ?>
										<i class="icon-remove"></i>
									<? endif;?>
								</td>
							</tr>
						<? endforeach; endif; ?>
					</tbody>
				</table>
			</section>
		</section>
	<? endif;?>
<? $this->load->view('public/footer');?>