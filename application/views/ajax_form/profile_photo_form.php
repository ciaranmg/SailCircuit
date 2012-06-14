<? $hidden = array('field' => '_image', 'submit'=> 'submit', 'redirect' => $redirect);?>
<?=form_open_multipart($form_action, array('class'=>'form-vertical well', 'id'=>'frm-profile-photo'), $hidden);?>
<button class="close btn-ajax-cancel">×</button>
<?=form_label('Upload File', 'profile-photo');?>
<div class="controls">
	<?=form_upload(array('name'=> 'profile-photo', 'id' => 'profile-photo', 'class'=> 'input-file'));?>
</div>	
<span class="help-block">Files must be less than 1MB. JPG, GIF, or PNG only.</span>
<button class="btn btn-primary">
	<i class="icon-camera icon-white"></i> Upload
</button>
<?=form_close();?>

<script type="text/javascript">
	$('.close').click(function(event){
		var itemContainer = 'profile-photo';
		$('#' + itemContainer).html(currentVals[itemContainer]);
		event.stopPropagation();
	});
	$('#frm-profile-photo .btn-primary').click(function(){
		$(this).addClass('disabled');
	});
</script>