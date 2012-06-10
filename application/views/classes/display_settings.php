<? $this->load->helper('inflector'); 
	$race_columns = $this->config->item('race_columns');
	$class_columns = $this->config->item('class_columns');
?>

<?=form_open('url', array('class' => 'well form-inline', 'id'=> 'frm-column-picker'), array('class_id' => $class->id));?>
		<fieldset>
			<legend>Display Settings for Overall Class Results</legend>
			<? foreach($class_columns as $col => $value): ?>
				<div class="control">
					<?=form_checkbox(array('name' => 'class_col_'.$col, 'id' => 'class_col_'.$col, 'value'=> $value, 'checked' => false));?>
					<?=form_label(humanize($col), 'class_col_'.$col);?>
				</div>
			<? endforeach;?>
		</fieldset>
		<fieldset>
			<legend>Display Settings for Individual Race Results</legend>
				<div class="control">
					<?=form_checkbox(array('name'=> 'hide_dnc', 'value'=>'1', 'checked' => false);?>
					<?=form_label('Hide DNC results', 'hide_dnc');?>
				</div>
			<? foreach($race_columns as $col => $value):?>
				<div class="control">
					<?=form_checkbox(array('name' => 'race_col_' . $col, 'id' => 'race_col'.$col, 'value'=> $value, 'checked' => false));?>
					<?=form_label(humanize($col), 'race_col_'.$col);?>
				</div>
			<? endforeach;?>
		</fieldset>
		<div class="leading btn-group pull-right">
			<a href="#" class="btn "><i class="icon-remove"></i> Cancel</a>
			<button class="btn btn-primary" type="submt"><i class="icon-ok icon-white"></i> Save</button>
		</div>
		<div class="clearfix"></div>
<?=form_close();?>

