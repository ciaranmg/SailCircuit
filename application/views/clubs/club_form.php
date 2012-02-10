<div id="clubForm" class="defaultForm">
	<?=validation_errors(); ?>
	<?=form_open('club/create'); ?>
	<input type="hidden" name="action" value="club/create">
	<label for="club_name">Club Name</label>
	<input type="text" name="club_name" id="club_name" value="<?=set_value('club_name')?>">
	<label for="description">Club Description</label>
	<textarea name="description" id="description"><?=set_value('description')?></textarea>
	<label for="club_name">Location</label>
	<input type="text" name="location" id="location" value="<?=set_value('location')?>">
	<?=form_submit('submit', 'Save');?>
</div>