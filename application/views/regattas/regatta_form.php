<? $this->load->view('common/header');?>
	<div class="row">
		<header class="span12">
			<h1><?=$title;?></h1>
			<? if(isset($intro)):?>
				<p class="lead"><?=$intro;?></p>
			<? endif;?>
		</header>
	</div>
	<div class="row">
		<div class="span12">
			<? $this->load->view('form/dynamic_form');?>
		</div>
	</div>
<? $this->load->view('common/footer');?>