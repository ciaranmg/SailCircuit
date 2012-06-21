<div class="profile-photo">
	<? if(isset($class->meta['_image'])):?>
		<img src="<?=base_url($class->meta['_image']->value->banner->full_path);?>" alt="<?=$class->name;?>">
	<? else: ?>
		<img src="<?=base_url('images');?>/image-placeholder-320x150.gif" width="320" height="150">
	<? endif; ?>
	<div id="btn-edit-profile-photo" class="edit-button" target="<?=base_url('/ajax/profile_photo/classes/' .$class->id);?>">
		<i class="icon-pencil icon-white"></i> Click to Change Photo
	</div>
</div>