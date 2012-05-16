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
				'action'=> base_url('boats/add_handicaps') . '/' . $boat_id,
				'submit' => 'submit'
				);

echo form_open($hidden['action'], array('class' => 'well form-inline frm-ajax-save'), $hidden);
?>
	<button class="close btn-ajax-cancel">×</button>
	<fieldset class="control-group">
		<label for="system_name">System:</label>
		<?=form_dropdown('system_name', $options, ' ', 'class="input-medium required" data-original-title="You must select a handicap system"');?>
		<label for="handicap_value">Handicap:</label>
		<input type="text" class="input-small required" placeholder="Value" name="handicap_value" id="handicap_value" data-original-title="Must be a number greater than 0">
		<button type="submit" class="btn btn-primary btn-ajax-save">Save</button>
	</fieldset>
	
<?=form_close(); ?>