<? 
	/*----------------------------------------------------------------------------
	Template to display a single-field form for AJAX updates
	----------------------------------------------------------------------------*/
	$hidden = array(
					'field' 		=> $field, 
					'id' 			=> $id, 
					'controller'	=> $controller,
					'submit' 		=> 'submit',
					'type'			=> $type
					);
	$attributes = array(
						'class' 	=> 'ajaxForm form has-validation',
						'id' 		=> $field . '_form'
						);
	$button_options = array(
							'class'=> 'alignleft',
							
							);
	$buttons = array(
					array(
						'title' => '',
						'action' => $controller.'/edit',
						'tooltip' => 'Save',
						'classes' => 'btn-primary',
						'type' => 'submit',
						'parameters' => $id,
						'icon' => 'ok icon-white'),
					array(
						'title' => '',
						'action' => $controller.'/edit',
						'tooltip'=> 'Cancel Edit',
						'type' => 'event',
						'classes' => 'cancel',
						'parameters' => $id,
						'icon' => 'remove'
						)
					);
?>
<div class="ajaxFieldFormConatiner">
	<?=form_open($target, $attributes, $hidden);?>
		<? $this->load->view('ajax_form/'.$type);?>
		<? $this->load->view('common/toolbar', array('options' => $button_options, 'buttons'=> $buttons));?>
	<?=form_close();?>
	<div class="clear"></div>
	<? if(isset($ajax_error)): ?>
		<div class="alert alert-error">
			<button class="close" data-dismiss="alert">×</button>
			<?=$ajax_error;?>
		</div>
	<? endif; ?>
</div>
<script>
		$(function(){
			/*----------------------------------------------------------------------------
			Cancel AJAX Form
			----------------------------------------------------------------------------*/
			$('.cancel').click(function(event){
				var itemContainer = $(this).parents('.editMode').attr('id');
				$('#' + itemContainer).html(currentVals[itemContainer]).addClass('editable');
				event.stopPropagation();
				$('#' + itemContainer +'.editable').bind('click', function(){ singleFieldEditForm($(this)); });
			});
			
			/*----------------------------------------------------------------------------
			AJAX Saving
			----------------------------------------------------------------------------*/
			$('#<?=$field .'_form';?>').submit(function(){			
				$(this).hide();
				var target = $(this).attr('action');
				var formData = $(this).serialize();
				$(this).parent().append('<img src="/images/ajax-loader-trans.gif" align="center">');
				// console.log(target);
				// console.log(formData);
				$.ajax({
					url: target,
					data: formData,
					type: 'POST',
					context: $(this),
					success: function(data){
						$(this).parents('.editMode').html(data).removeClass('editMode').addClass('editable').bind('click', function(){singleFieldEditForm($(this));});
					},
					error: function(){
						$(this).parents('.editMode').html(currentVals[containerID]);
					}
				});
				return false;
			});	
		});
</script>
