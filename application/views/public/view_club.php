<? $this->load->view('public/header');?>
<div class="span12">
	<section class="portlet leading">
		<header>
			<h2>All Series for <?=$club->name;?></h2>
			<div class="clearfix"></div>
		</header>
		<section>
			<table class="table table-striped" id="regattaTable">
				<thead>
					<tr>
						<th>
							Name
						</th>
						<th class="hidden-phone">
							Description
						</th>
						<th class="hidden-phone">
							Start Date
						</th>
						<th class="hidden-phone">
							End Date
						</th>
						<th>
							Classes
						</th>
					</tr>
				</thead>
				<tbody>
					<? foreach($regattas as $regatta): ?>
					<tr>
						<td>
							<a href="<?=base_url('clubs/view_series/'.strtolower($club->name). '/'. $club->id .'/'. $regatta->id);?>" title="<?=$regatta->name;?>">
								<?=$regatta->name;?>
							</a>
						</td>
						<td class="hidden-phone">
							<?=$regatta->description?>
						</td>
						<td class="hidden-phone">
							<?=sc_date_format($regatta->start_date);?>
						</td>
						<td class="hidden-phone">
							<?=sc_date_format($regatta->end_date);?>
						</td>
						<td>
							<?=$regatta->classes;?>
						</td>
					</tr>
					<? endforeach; ?>
				</tbody>
			</table>
			<?=$this->pagination->create_links();?>
		</section>
	</section>
</div>
<? $this->load->view('public/footer');?>