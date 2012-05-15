<?
$this->load->view('common/header');
?>
<div class="row">
	<header class="span6">
		<h1><?=$title;?></h1>
		<p class="lead"><?=$intro;?></p>
	</header>
	<div class="span6">	
		<? $buttons = array(
					array(
						'title' => 'New Regatta',
						'action' => 'regatta/create',
						'classes' => '',
						'parameters' => '',
						'icon' => 'plus'
					),
				);
			$this->load->view('common/toolbar', array('buttons' => $buttons));
		?>
	</div>
</div>
<div class="row">
	<div class="span12">
		<? $this->load->view('regattas/tbl_list_regattas'); ?>
	</div>
</div>
<? $this->load->view('common/footer'); ?>