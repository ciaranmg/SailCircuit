<?=form_dropdown('meta_name', $meta_options, '0', 'id="meta_picker"');?>
<?=form_hidden('controller', $controller);?>
<?=form_hidden('object_id', $object_id);?>
<?=form_input(array('name' => 'text_meta', 'id' => 'text_meta_' .$object_id, 'class' => 'input-medium text-field hidden'));?>
<script type="text/javascript">
	$('#meta_picker').on('change', function(){
		var metaInfo = $(this).val().split('|');
		if(metaInfo[1] == 'text'){
			$('.text-field').removeClass('hidden').focus().attr('placeholder', 'Enter ' + metaInfo[0].replace('_', ' '));
		}
	});
</script>