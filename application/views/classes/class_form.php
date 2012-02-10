<? 
	$hidden = array(
					'parent' => $classParent,
					'action' => 'classes/create',
					'submit' => 'submit'	
				);
?>
<div id="classForm" class="defaultForm">
	<?=validation_errors(); ?>
	<?=form_open('class/create', '', $hidden); ?>
		<div class="clearfix">
			<label for="class_name">Name <?=form_error('class_name'); ?></label>
			<div class="form-input">
				<input type="text" placeholder="Class Name" required="required" name="class_name" id="class_name" value="<?=set_value('class_name'); ?>">
			</div>
		</div>
		<div class="clearfix">
			<label for="class_description">Description <?=form_error('class_description'); ?></label>
			<div class="form-input">
				<input type="text" name="class_description" id="class_description" value="<?=set_value('class_description');?>">
			</div>
		</div>
		<div class="clearfix">
			<label for="class_races">Number of Races <?=form_error('class_races'); ?></label>
			<div class="form-input">
				<input type="text" name="class_races" placeholder="e.g. 5" required="required" id="class_races" value="<?=set_value('class_races'); ?>">
			</div>
		</div>
		<div class="clearfix">
			<label for="class_discards">Number of Discards <?=form_error('class_discards'); ?></label>
			<div class="form-input">
				<input type="text" name="class_discards" id="class_discards" value="<?=set_value('class_discards'); ?>">
			</div>
		</div>	
		<div class="clearfix">
			<label for="class_team">Team &amp; Round Robin <?=form_error('class_team'); ?></label>
			<div class="form-input">
				<?=form_dropdown('class_team', $classTeamSystems, $classTeamSystem);?>
			</div>
		</div>
		<div class="clearfix">
			<label for="class_rating_system">Rating</label>
			<div class="form-input">
				<?=form_dropdown('class_rating_system', $classRatingSystems, $classRatingSystem);?>
			</div>
		</div>
		<div class="clearfix">
			<label for="class_tiebreak_system">Tie Breaking</label>
			<div class="form-input">
				<?=form_dropdown('class_tiebreak_system', $classTiebreakers, $classTiebreaker);?>
			</div>
		</div>
		<div class="clearfix">
			<label for="class_scoring_system">Scoring System</label>
			<div class="form-input">
				<?=form_dropdown('class_scoring_system', $classScoringSystems, $classScoringSystem);?>
			</div>
		</div>
	
		<div class="fieldGroup clearfix">
			<h2>Boats in Class</h2>
			<? 
			
				foreach($classBoats as $boat){
					?> 
					<label for="class_boat">
						<?
							echo form_checkbox('class_boat[]', $boat['id'], $boat['selected']);
							echo $boat['sail_number'] ." ". $boat['name'];
						?>
					</label>
					<?
				}
			?>
		</div>
		<?=form_submit('submit', 'Create Class');?>
	<?=form_close()?>
</div>