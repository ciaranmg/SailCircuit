<? $this->load->view('races/tbl_race_results');?>
<div class="btn-group pull-right">
	<a href="<?=base_url('/classes/view/'.$race->class_id);?>" class="btn"><i class="icon-eye-open"></i> View Class</a>
	<a href="<?=base_url('/race/input/');?>" class="btn btn-primary"><i class="icon-plus icon-white"></i> Enter More Results</a>
</div>