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
		'action' => base_url("owner/create/$boat_id"),
		'submit' => 'submit'
		);
	echo form_open($hidden['action'], array('class' => 'well form-inline frm-ajax-save'), $hidden); 
?>
	<button class="close btn-ajax-cancel">×</button>
	<fieldset class="control-group">
		<div class="control-group warning">
			<label class="control-label" for="name">Name *</label>
			<div class="controls">	
				<input data-original-title="Name is required" placeholder="Name is required" class="input-large required" type="text" name="name" id="name" value="<?=set_value('name'); ?>">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="email">Email </label>
			<div class="controls">
				<input data-original-title="Must be a valid email address" placeholder="Email address" class="input-large email" type="text" name="email" id="email" value="<?=set_value('email'); ?>">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="phone">Phone </label>
			<div class="controls">
				<input placeholder="Phone number" class="input-large" type="text" name="phone" id="phone" value="<?=set_value('phone'); ?>">
			</div>
		</div>
		<button type="submit" class="btn btn-primary btn-ajax-save">Save</button>
	</fieldset>

<?=form_close();?>
