<div class="container_12 clearfix leading">
	<?=anchor('regatta/create', "Create New Regatta", array('class'=>'button')); ?>
	<? $this->load->view('regattas/list_regattas')?>
	<div class="clear"></div>
	<a href="#regatta/create" class="button">Create New Regatta</a>
</div>
