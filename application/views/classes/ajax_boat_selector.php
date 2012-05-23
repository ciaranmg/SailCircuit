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
<div class="defaultForm form-horizontal">
	<?
		$hidden = array(
			'action' => base_url("/classes/ajax_boat_selector/$class_id"),
			'submit' => 'submit'
			);
		echo form_open($hidden['action'], array('class' => 'well form-inline frm-ajax-save'), $hidden); 
	?>
	<button class="close btn-ajax-cancel">×</button>
	<?
		$this->load->view('form/class_boat_selector');
	?>
	<div class="form-actions">
		<button type="submit" class="btn btn-large btn-primary btn-ajax-save">Save</button>
	</div>
	<?
		echo form_close();
	?>
</div>
