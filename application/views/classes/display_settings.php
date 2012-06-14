<? $this->load->helper('inflector'); ?>
<?=form_open(base_url('/classes/save_display_settings/' . $class->id), array('class' => 'well form-inline', 'id'=> 'frm-column-picker'), array('class_id' => $class->id));?>
		<fieldset>
			<legend>Display Settings for Overall Class Results</legend>
			<? foreach($class->meta['_class_columns']->value as $col => $value): ?>
				<div class="control">
					<?=form_checkbox(array('name' => 'class_col_'.$col, 'id' => 'class_col_'.$col, 'value'=> 1, 'checked' => $value));?>
					<?=form_label(humanize($col), 'class_col_'.$col);?>
				</div>
			<? endforeach;?>
		</fieldset>
		<fieldset>
			<legend>Display Settings for Individual Race Results</legend>
				<fieldset>
					<p><strong>General Settings</strong></p>
					<? foreach($class->meta['_race_settings']->value as $setting => $value):?>
						<div class="control">
							<?=form_checkbox(array('name' => $setting , 'value'=> 1, 'checked' => $value, 'id' => $setting));?>
							<?=form_label(humanize($setting), $setting);?>
						</div>
					<? endforeach;?>
				</fieldset>
				<p><strong>Columns</strong></p>
			<? foreach($class->meta['_race_columns']->value as $col => $value):?>
				<div class="control">
					<?=form_checkbox(array('name' => 'race_col_' . $col, 'id' => 'race_col_'.$col, 'value'=> 1, 'checked' => $value));?>
					<?=form_label(humanize($col), 'race_col_'.$col);?>
				</div>
			<? endforeach;?>
		</fieldset>
		<div class="leading btn-group pull-right">
			<a class="btn show-hide" data-target-id="ctr-column-chooser" title="Hide Display Settings">
				<i class="icon-remove"></i> Close
			</a>
			<button class="btn btn-primary" type="submt"><i class="icon-ok icon-white"></i> Save</button>
		</div>
		<div class="clearfix"></div>
<?=form_close();?>