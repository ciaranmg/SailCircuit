<div class="container_12 clearfix leading">
	<div class="grid_12">
		<div id="boatForm" class="defaultForm">
			<?=validation_errors(); ?>
			<?=form_open('boat/create', array('class'=>'form has-validation')); ?>
				<input type="hidden" name="action" value="boat/create">
				<div class="clearfix">
					<label class="form-label" for="boat_name">Name <em>*</em> <?=form_error('boat_name'); ?></label>
					<div class="form-input">
						<input type="text" name="boat_name" id="boat_name" required="required" placeholder="BoatName" value="<?=set_value('boat_name'); ?>">
					</div>
				</div>
				<div class="clearfix">
					<label class="form-label" for="boat_sail_number">Sail Number <?=form_error('boat_sail_number'); ?></label>
					<div class="form-input">
						<input type="text" name="boat_sail_number" id="boat_sail_number" required="required" placeholder="Sail Number" value="<?=set_value('boat_sail_number'); ?>">
					</div>
				</div>
				<div class="clearfix">
					<label class="form-label" for="boat_make">Manufacturer <?=form_error('boat_make'); ?></label>
					<div class="form-input">
						<input type="text" name="boat_make" id="boat_make" placeholder="Manufactuer or Builder" value="<?=set_value('boat_make');?>">
					</div>
				</div>		
				<div class="clearfix">
					<label class="form-label" for="boat_model">Model <?=form_error('boat_model'); ?></label>
					<div class="form-input">
						<input type="text" name="boat_model" id="boat_model" placeholder="Model Name" value="<?=set_value('boat_model');?>">
					</div>
				</div>		
				<div class="clearfix">
				<? //Todo: enable imperial measurements ?>
				<label class="form-label" for="boat_length">Length (LOA) in Meters <?=form_error('boat_length'); ?></label>
					<div class="form-input">
						<input type="text" name="boat_length" id="boat_length" placeholder="Length in Meters" value="<?=set_value('boat_length');?>">
					</div>
				</div>		
				<? //Todo: enable class and subclass fields ?>
				<div class="form-action clearfix">
					<input type="submit" class="button" value="Submit" name="submit">
					
				</div>
			</form>
		</div>
	</div>
</div>