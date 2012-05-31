<?
$datetime = array('field' => 'race_datetime', 'value' => array('22/05/2012', '17:00'));
?>

<fieldset>
	<legend>Pick a race</legend>
	<label for="regatta_picker">Regatta</label>
	<?=form_dropdown('regatta_picker', $regattas, 0, 'id="regatta_picker"');?>
	<label for="class_picker">Class</label>
	<?=form_dropdown('class_picker', array('0' => ''), 0, 'id="class_picker"');?>
	<label for="race_picker">Race</label>
	<? 
		if(isset($race)){
			echo form_dropdown('race_picker', array($race->id => $race->name), $race->id, 'id="race_picker" class="required" data-original-title="You must Pick a Race"');
		}else{
			echo form_dropdown('race_picker', array(''=> ''), 0, 'id="race_picker" class="required" data-original-title="You must Pick a Race"');
		}
	?>
</fieldset>
<fieldset>
	<legend>Race Parameters</legend>
		<div class="controls">
			<label for="timer-elapsed" class="radio"><input type="radio" name="timer" id="timer-elapsed" value="elapsed" checked="checked"> Timer Records Elapsed Time</label>
			<label for="timer-time" class="radio"><input type="radio" name="timer" id="timer-time" value="finishtime"> Timer Records Finish Time</label>
		</div>
	<div id="datetimepicker" class="hidden">
		<label for="<?=$datetime['field'];?>">Start date &amp; time</label>
		<? $this->load->view('ajax_form/datetime', $datetime);?>
	</div>
</fieldset>