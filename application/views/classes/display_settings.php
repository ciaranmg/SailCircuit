<? $this->load->helper('inflector'); ?>

<?=form_open('url', array('class' => 'well form-inline', 'id'=> 'frm-column-picker'), array('class_id' => $class->id));?>
		<fieldset>
			<legend>Display Settings for Overall Class Results</legend>
			<? foreach($class->meta['_class_columns']->value as $col => $value): ?>
				<div class="control">
					<?=form_checkbox(array('name' => 'class_col_'.$col, 'id' => 'class_col_'.$col, 'value'=> $value, 'checked' => $value));?>
					<?=form_label(humanize($col), 'class_col_'.$col);?>
				</div>
			<? endforeach;?>
		</fieldset>
		<fieldset>
			<legend>Display Settings for Individual Race Results</legend>
				<fieldset>
					<p><strong>General Settings</strong></p>
					<div class="control">
						<? if(isset($class->meta['_hide_dnc'])):?>
							<?=form_checkbox(array('name' => '_hide_dnc', 'value'=> '1', 'checked' => $class->meta['_hide_dnc']->value));?>
						<? else: ?>
							<?=form_checkbox(array('name'=> 'hide_dnc', 'value'=>'1', 'checked' => false));?>
						<? endif;?>
							<?=form_label('Hide DNC results', '_hide_dnc');?>
					</div>
				</fieldset>
				<p><strong>Columns</strong></p>
			<? foreach($class->meta['_race_columns']->value as $col => $value):?>
				<div class="control">
					<?=form_checkbox(array('name' => 'race_col_' . $col, 'id' => 'race_col'.$col, 'value'=> $value, 'checked' => $value));?>
					<?=form_label(humanize($col), 'race_col_'.$col);?>
				</div>
			<? endforeach;?>
		</fieldset>
		<div class="leading btn-group pull-right">
			<a class="btn show-hide" data-target-id="ctr-column-chooser" title="Hide Display Settings">
				<i class="icon-remove"></i> Cancel
			</a>
			<button class="btn btn-primary" type="submt"><i class="icon-ok icon-white"></i> Save</button>
		</div>
		<div class="clearfix"></div>
<?=form_close();?>

