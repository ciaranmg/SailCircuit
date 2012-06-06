<? $this->load->view('public/header');?>
	<div class="span12">
		<section class="portlet leading">
			<header>
				<h2><?=$race->name;?></h2>

				<div class="clearfix"></div>
			</header>
			<section>
				<? $this->load->view('public/table/race_results');?>
			</section>
		</section>	
	</div>
<?$this->load->view('public/footer');?>