<? $this->load->view('common/header');?>
<div class="row">
	<header class="span12">
		<h1><?=$race->name;?></h1>
		<p class="lead"><?=sc_date_format($race->start_date);?> <?=sc_time_format($race->start_date);?></p>
	</header>
</div>
<div class="row">
	<div class="span12">
		<section class="portlet leading">
			<header>
				<h2><?=$race->name;?></h2>
					<?
						$add_handicap = array(
							array(
							'type' => 'button',
							'title' => 'Edit Results',
							'action' => 'race/edit',
							'classes' => 'btn-ajax-activate',
							'parameters' => $race->id,
							'icon' => 'pencil',
							'attributes' => 'data-target-id="ctr-race-results" data-target="'. base_url('race/edit/' .$race->id) .'"'
							)
						);
						$this->load->view('common/toolbar', array('buttons' => $add_handicap));
					?>
				<div class="clearfix"></div>
			</header>
			<section id="ctr-race-results">
				<? $this->load->view('races/tbl_race_results');?>
			</section>
		</section>	
	</div>
</div>
<?$this->load->view('common/footer');?>