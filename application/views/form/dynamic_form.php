<?
//
//	Template to dynamically generate forms
//
?>
<div class="defaultForm leading">
	<? if(validation_errors()): ?>
		<div class="alert alert-error">
			<button class="close" data-dismiss="alert">×</button>
			<?=validation_errors();?>
		</div>
	<? endif;?>
	<?
	$hidden_fields = array('action' => $form['action'], 'submit' => $form['submit'], 'parent' => $form['parent']);

	if(isset($form['upload'])){
		echo form_open($form['action'], array('class'=>'form-horizontal'), $hidden_fields);
	}else{
		echo form_open($form['action'], array('class'=>'form-horizontal'), $hidden_fields); 
	}
	?>
	<? foreach($form['fields'] as $field):?>
		<? if($field['type'] !== 'custom'):?>
			<fieldset>
				<div class="control-group <?=(isset($field['required']))? 'warning' : '' ;?> <? if(form_error($field['name'])) echo 'error'; ?>">
					<label class="control-label"><?=$field['label'];?> <?if(isset($field['required'])) echo "<em>*</em>"; ?></label>
					<div class="controls">
						<? 
						if($field['type'] == 'text') {
							echo form_input(array('name'=>$field['name'], 'id' => $field['name'], 'class'=> 'input-xlarge', 'value' => $field['value']));
						}elseif($field['type'] == 'textarea'){
							echo form_textarea(array('name'=>$field['name'], 'id' => $field['name'], 'class'=> 'input-xlarge', 'value' => $field['value'], 'rows' => 6, 'cols' => '40'));
						}elseif($field['type'] == 'file'){
							echo form_upload(array('name'=>$field['name'], 'id' => $field['name'], 'class'=> 'input-xlarge', 'value' => $field['value']));
						}elseif($field['type'] == 'checkbox'){
							echo form_upload(array('name'=>$field['name'], 'id' => $field['name'], 'class'=> 'input-xlarge', 'value' => $field['value']));
						}elseif($field['type'] == 'checkgroup'){
							echo form_checkbox(array('name'=>$field['name'], 'id' => $field['name'], 'class'=> 'input-xlarge', 'value' => $field['value'], 'checked' => $field['checked']));
						}elseif($field['type'] == 'radio'){
							echo form_checkbox(array('name'=>$field['name'], 'id' => $field['name'], 'class'=> 'input-xlarge', 'value' => $field['value'], 'checked' => $field['checked']));
						}elseif($field['type'] == 'dropdown'){
							echo form_dropdown($field['name'], $field['options'], $field['selected'], 'class="input-xlarge"');
						}elseif($field['type'] == 'password'){
							echo form_password(array('name'=>$field['name'], 'id' => $field['name'], 'class'=> 'input-xlarge', 'value' => $field['value']));
						}elseif($field['type'] =='multiselect'){
							
						}elseif($field['type'] == 'date'){
							?>
							<div class="input-prepend">
								<span class="add-on"><i class="icon-calendar"></i></span><?=form_input(array('name'=>$field['name'], 'id' => $field['name'], 'class'=> 'input-xlarge oneaddon datepicker', 'value' => $field['value']));?>
							</div>
							<?
						}
						?>
						<p class="help-block">
							<?=form_error($field['name']);?>
						</p>
					</div>
				</div>
			</fieldset>
		<? else: ?>
			<? $this->load->view('form/'.$field['custom_field'], array('custom_field' => $field));?>
		<? endif;?>
	<? endforeach; ?>
	<div class="form-actions">
		<?=form_reset(array('name' => 'reset', 'value' => 'Cancel', 'class' => 'btn btn-large'));?>
		<?=form_submit(array('name'=> 'form_submit', 'value' => $form['button_label'], 'class'=> 'btn btn-primary btn-large'));?>
	</div>
	<?=form_close()?>
</div>