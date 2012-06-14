<div class="profile-photo">
	<? if(isset($boat->meta['_image'])):?>
		<img src="<?=base_url($boat->meta['_image']->value->small->full_path);?>" alt="<?=$boat->name;?>">
	<? else: ?>
		<img src="<?=base_url('images');?>/image-placeholder-320x200.gif" width="320" height="200">
	<? endif; ?>
	<div id="btn-edit-profile-photo" class="edit-button" target="<?=base_url('/ajax/profile_photo/boats/' .$boat->id);?>">
		<i class="icon-pencil icon-white"></i> Click to Change Photo
	</div>
</div>