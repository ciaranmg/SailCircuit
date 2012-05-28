<?if(isset($message)):?>
	<div class="alert fade in">
		<button class="close" data-dismiss="alert">×</button>
		<?=$message;?>
	</div>
<? endif; ?>

<?if(isset($err_message)):?>
	<div class="alert alert-error fade in">
		<button class="close" data-dismiss="alert">×</button>
		<?=$err_message;?>
	</div>
<? endif; ?>

<?
	$hidden = array(
		'action' => base_url("race/ajax_add_races/$class_id"),
		'submit' => 'submit'
		);
	echo form_open($hidden['action'], array('class' => 'well form-inline frm-ajax-save'), $hidden); 
?>
	<button class="close btn-ajax-cancel">×</button>			
	<div class="controls">	
		<label class="control-label" for="name">Add Races </label>
		<?=form_dropdown('race_count', $race_count_options, 1, 'id="race_count" class="input-small"');?>
		<button type="submit" class="btn btn-primary btn-ajax-save">Save</button>
		<p class="help-block">You can have up to <?=$this->config->item('sc_class_max_races');?> races in a class</p>
	</div>
<?=form_close();?>