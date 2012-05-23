<? $this->load->view('common/header');?>
<div id="userForm" class="defaultForm">
	<?=validation_errors(); ?>
	<?=form_open('user/create'); ?>
		<input type="hidden" name="action" value="user/create">
		
		<label for="name">Name <?=form_error('name'); ?></label>
		<input type="text" name="name" id="name" value="<?=set_value('name'); ?>">
		
		<label for="name">Email <?=form_error('email'); ?></label>
		<input type="text" name="email" id="email" value="<?=set_value('email'); ?>">
		
		<label for="name">Password <?=form_error('password1'); ?></label>
		<input type="password" name="password1" id="password1" value="">
		
		<label for="name">Confirm Password <?=form_error('password2'); ?></label>
		<input type="password" name="password2" id="password2" value="">
		
		<?=form_submit('submit', 'Sign Up');?>
	<?=form_close();?>
</div>
<? $this->load->view('common/footer');?>