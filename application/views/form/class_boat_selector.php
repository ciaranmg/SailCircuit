<div class="row">
		<div class="span12">
			<h3 class="group-label"><?=$custom_field['label'];?></h3>
			<p>
				If you're using a handicap system to calculate corrected times, adding a boat to the class will take a snapshot of the handicap value as it stands now.
				Future adjustments to the handicap for that boat will need to be manually applied to the class.
			</p>

		</div>
		<div class="span5">
			<label for="boats_out" class="control-label"><strong>All Boats</strong></label>
			<select name="boats_out" id="boats_out" multiple="multiple" class="input-xlarge" size="10">
				<? foreach($custom_field['boats_out'] as $boat): ?>
					<option value="<?=$boat->id;?>"><?=$boat->name;?></option>
				<? endforeach; ?>
			</select>
		</div>
		<div class="span2 add-remove-buttons">
			<div class="btn-group">
				<button id="push_in" class="btn btn-large sc-icon-only" rel="tooltip" data-original-title="Add Selected Boat(s) to Class"><i class="icon-arrow-right"></i><span class="hidden-desktop"> Add</span></button>
			</div>
			<br>
			<div class="btn-group">
				<button id="push_out" class="btn btn-large sc-icon-only" rel="tooltip" data-original-title="Remove Selected Boat(s) from Class"><i class="icon-arrow-left"></i><span class="hidden-desktop"> Remove</span></button>
			</div>
		</div>
		<div class="span5">
			<label for="boats_in[]" class="control-label"><strong>Boats in Class</strong></label>
			<select name="boats_in[]" id="boats_in" multiple="multiple" class="input-xlarge" size="10">
				<?	if(sizeof($field['boats_in']) > 0): foreach($field['boats_in'] as $boat_in): ?>
					<option value="<?=$boat_in->id;?>" selected="selected"><?=$boat_in->name;?></option>
				<? endforeach; endif;?>
			</select>
		</div>
</div>


<script type="text/javascript">
	$(function() {  
		$('#push_in').click(function() {  
			return !$('#boats_out option:selected').remove().appendTo('#boats_in');  
		});  
		$('#push_out').click(function() {  
			return !$('#boats_in option:selected').remove().appendTo('#boats_out');  
		});  

		$('form').submit(function() {  
			$('#boats_in option').each(function(i) {  
				$(this).attr("selected", "selected");  
			});  
		});  
	});
</script>