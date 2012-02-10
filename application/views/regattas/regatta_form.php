
<div class="container_12 clearfix">
	<div class="grid_12">
		<? $this->load->view('common/breadcrumb');?>
	</div>
	<div class="grid_12 leading">
		<div id="regattaForm" class="defaultForm">
			<?=validation_errors(); ?>
			<?=form_open($action, array('class'=>'form has-validation')); ?>
				<input type="hidden" name="action" value="<?=$action?>">
				<input type="hidden" name="regatta_parent" value="<?=$regatta_parent;?>">
				<input type="hidden" name="submit" value="submit">
				<div class="clearfix">
					<label for="regatta_name" class="form-label">Regatta Name <em>*</em> <?=form_error('regatta_name'); ?></label>
					<div class="form-input">
						<input type="text" name="regatta_name" required="required" placeholder="Regatta Name" id="regatta_name" value="<?=set_value('regatta_name'); ?>">
					</div>
				</div>
				<div class="clearfix">
					<label for="regatta_start_date" class="form-label">Start Date <?=form_error('regatta_start_date'); ?></label>
					<div class="form-input">
						<input type="date" name="regatta_start_date" id="regatta_start_date" class="dateinput" value="<?=set_value('regatta_start_date'); ?>">
					</div>
				</div>
				<div class="clearfix">
					<label for="regatta_end_date" class="form-label">End Date <?=form_error('regatta_end_date'); ?></label>
					<div class="form-input">
						<input type="date" name="regatta_end_date" id="regatta_end_date" class="dateinput" value="<?=set_value('regatta_end_date'); ?>">
					</div>
				</div>
				<div class="clearfix">
					<label for="regatta_description" class="form-label">Description <?=form_error('regatta_description'); ?></label>
					<div class="form-input">
						<input type="text" name="regatta_description" id="regatta_description" value="<?=set_value('regatta_description');?>">
					</div>
				</div>
				
					<div class="form-action clearfix">
						<input type="submit" class="button" value="Create Regatta" name="submit">
					</div>
			</form>
		</div>
	</div>
</div>