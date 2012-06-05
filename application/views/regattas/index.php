<?
$this->load->view('common/header');
$buttons = array(
					array(
						'title' => 'New Regatta',
						'action' => 'regatta/create',
						'classes' => '',
						'parameters' => '',
						'icon' => 'plus'
					),
				);
?>
<div class="row">
	<header class="span12">
		<h1><?=$title;?></h1>
		<p class="lead"><?=$intro;?></p>
	</header>
</div>
<div class="row">
	<div class="span12">
		<section class="portlet leading">
			<header>
				<h2><?=$title?></h2>
				<div class="btn-group pull-right">
					<? $this->load->view('common/toolbar', array('buttons' => $buttons));?>
				</div>
				<div class="clearfix"></div>
			</header>
			<section>
				<? $this->load->view('regattas/tbl_list_regattas'); ?>
			</section>
		</section>
	</div>
</div>
<? $this->load->view('common/footer'); ?>