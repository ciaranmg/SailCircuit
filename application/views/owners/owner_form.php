<? if($ajax !== true) $this->load->view('common/header'); ?>
<div id="ownerForm" class="defaultForm">
	<?=validation_errors(); ?>
	<?=form_open($action); ?>

		<? if(isset($id)): ?> 
			<input type="hidden" name="id" id="id" value="<?=$id?>">
		<? endif;
			if(isset($boat_id)):?>
			<input type="hidden" name="boat_id" id="boat_id" value="<?=$boat_id?>">
		<? endif; ?>
		
		<input type="hidden" name="action" id="action" value="<?=$action?>">
		<label for="name">Name <?=form_error('name'); ?></label>
		<input type="text" name="name" id="name" value="<?=set_value('name'); ?>">
		
		<label for="name">Email <?=form_error('email'); ?></label>
		<input type="text" name="email" id="email" value="<?=set_value('email'); ?>">
		
		<label for="name">Phone <?=form_error('phone'); ?></label>
		<input type="text" name="phone" id="phone" value="<?=set_value('phone'); ?>">
		
		<?=form_submit('submit', 'Save');?>
	</form>
</div>
<? if($ajax !== true) $this->load->view('common/footer'); ?>