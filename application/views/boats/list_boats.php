<? $this->load->view('common/header');?>	
<div class="row">
	<header class="span6">
		<h1><?=$title;?></h1>
		<p class="lead"><?=$intro;?></p>
	</header>
	<div class="span6">
		<div id="demo" class="clearfix">
			<? 
				$buttons = array(
							array(
								'title' => 'Add New Boat',
								'action' => 'boats/create',
								'classes' => '',
								'parameters' => '',
								'icon' => 'plus'
							)
				);
				$this->load->view('common/toolbar', array('buttons'=>$buttons));
			?>
		</div>
	</div>
</div>
<div class="row">
	<div class="span12">
		<?=$this->load->view('boats/tbl_list_boats');?>
	</div>
</div>
<? $this->load->view('common/footer');?>