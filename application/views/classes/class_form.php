
<div class="container_12 clearfix leading">
	<? $this->load->view('common/breadcrumb');?>
	<div class="grid_12">
		<? 
			$hidden = array(
							'parent' => $classParent,
							'action' => 'classes/create',
							'submit' => 'submit'	
						);
		?>
		<div id="classForm" class="defaultForm leading">
			<?=validation_errors(); ?>
			<?=form_open($hidden['action'], array('class'=>'form has-validation'), $hidden); ?>
				<div class="clearfix">
					<label for="class_name" class="form-label">Name <em>*</em><?=form_error('class_name'); ?></label>
					<div class="form-input">
						<input type="text" placeholder="Class Name" required="required" name="class_name" id="class_name" value="<?=set_value('class_name'); ?>">
					</div>
				</div>
				<div class="clearfix">
					<label for="class_description" class="form-label">Description <?=form_error('class_description'); ?></label>
					<div class="form-input">
						<input type="text" name="class_description" id="class_description" value="<?=set_value('class_description');?>">
					</div>
				</div>
				<div class="clearfix">
					<label for="class_races" class="form-label">Number of Races <em>*</em> <?=form_error('class_races'); ?></label>
					<div class="form-input">
						<input type="text" name="class_races" placeholder="e.g. 5" required="required" id="class_races" value="<?=set_value('class_races'); ?>">
					</div>
				</div>
				<div class="clearfix">
					<label for="class_discards" class="form-label">Number of Discards <em>*</em><?=form_error('class_discards'); ?></label>
					<div class="form-input">
						<input type="text" name="class_discards" id="class_discards" value="<?=set_value('class_discards'); ?>">
					</div>
				</div>	
				<div class="clearfix">
					<label for="class_rating_system" class="form-label">Handicap Rating <em>*</em> <?=form_error('class_handicap'); ?></label>
					<div class="form-input">
						<?=form_dropdown('class_rating_system', $classRatingSystems, $defaultRatingSystem);?>
					</div>
				</div>
				<div class="clearfix">
					<label for="class_tiebreak_system" class="form-label">Tie Breaking <em>*</em> <?=form_error('class_tiebreaker'); ?></label>
					<div class="form-input">
						<?=form_dropdown('class_tiebreak_system', $classTiebreakers, $classTiebreaker);?>
					</div>
				</div>
				<div class="clearfix">
					<label for="class_scoring_system" class="form-label">Scoring System <em>*</em> <?=form_error('class_scoring_system'); ?></label>
					<div class="form-input">
						<?=form_dropdown('class_scoring_system', $classScoringSystems, $classScoringSystem);?>
					</div>
				</div>
			
				<div class="fieldGroup clearfix">
					<h2>Boats in Class</h2>
					<? /* 
					
						foreach($classBoats as $boat){
							?> 
							<label for="class_boat">
								<?
									echo form_checkbox('class_boat[]', $boat['id'], $boat['selected']);
									echo $boat['sail_number'] ." ". $boat['name'];
								?>
							</label>
							<?
						} */
					?>
				</div>
				<div class="form-action">
					<?=form_submit('submit', 'Create Class');?>
				</div>
			<?=form_close()?>
		</div>
	</div>
</div>