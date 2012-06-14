<script>	
	var datelocale = '<?=($this->session->userdata('locale') =='uk') ? 'dd/mm/yy' : 'mm/dd/yy'; ?>';
	var currentVals = new Array();
	var modalTrigger;

	$(function() {

		$('.profile-photo').hover(function(){$('.edit-button').show();}, function(){$('.edit-button').hide();});
		
		$(document).on('click', '#btn-edit-profile-photo', function(){
			profilePhotoForm($(this));
		});

		$('.show-hide').click(function(event){
			var show_hide = $(this).attr('data-target-id');
			$('#'+ show_hide).slideToggle();
			event.stopPropagation();
		});
		$('.editable').tooltip({
			title: '<i class="icon-pencil icon-white"></i> Click to Edit',
			trigger: 'hover',
			placement: 'top',
		});
		
		$(document).on('click', '.editable', function(){
			$(this).tooltip('hide');
			singleFieldEditForm($(this));
		});

		$(document).on('click', '.btn-ajax-activate', function(){
			$(this).removeClass('btn-ajax-activate');
			ajaxEditForm($(this));
		});
		/* $('.btn-ajax-activate').click(function(){
			ajaxEditForm($(this));
		}); */

		/*			Set up date pickers		*/
		$( ".datepicker" ).datepicker({dateFormat: datelocale});

		/*			Tooltips on mini buttons		*/
		$('.btn-mini, .sc-icon-only, .tool-tip').tooltip();
		

		/* 			Set up ajax delete buttons		*/
		$(document).on('click', '.sc-delete', function(){
			modalTrigger = $(this);
			
			var modal = $(modalTrigger.attr('href'));

			$('input[name=object_id]', modal).val(modalTrigger.attr('data-subject-id'));
			$(modalTrigger.attr('href') + ' .modal-body').html('<p>' + modalTrigger.attr('data-subject-title') + '</p>');
			$(modalTrigger.attr("href")).modal();
			
			if(modalTrigger.attr('data-ajax') == 'true'){
				$('form', modal).attr('action', modalTrigger.attr('data-action'));
				$('form', modal).bind('submit', function(){ ajaxDeleteForm($(this)); return false;});
			}
		});

		$('.show-help').click(function(event){
			if($('div.help').is(":visible")){
				$('div.help').slideUp();
				$(this).html('Show Help <i class="icon-chevron-down"></i>');
			}else{
				$('div.help').slideDown().removeClass('hidden');
				$(this).html('Hide Help <i class="icon-chevron-up"></i>');
			}
			event.stopPropagation();
		});
	});

	function profilePhotoForm(button){
			var target = button.attr('target');			
			var containerID = 'profile-photo';
			var container = $('#' + containerID);
			currentVals[containerID] = container.html().trim();
			container.html('<img src="/images/ajax-loader-trans.gif" align="center">');

			$.ajax({
					url: target,
					context: container,
					success: function(data){
						container.html(data);
					},
					error: function(){
						container.html(currentVals[containerID]);
					}
			});
	}

	function ajaxDeleteForm(frmDelete){
		// Close the Modal, Find the container and put the ajax spinner up.
		// Gather the form data and submit it to the controller
		// Then fill the container with the response

		frmDelete.parents('.modal').modal('hide');
		var formData = frmDelete.serialize();
		var container = modalTrigger.parents('.ajax-container');
		currentVals[container.attr('id')] = container.html();
		container.html('<div class="ajax-spinner"></div>');

		$.ajax({
			url: frmDelete.attr('action'),
			data: formData,
			type: 'POST',
			context: frmDelete,
			success: function(data){
				container.html(data);
			},
			error: function(){
				container.html(currentVals[container.attr('id')]);
			}
		});
	}

	function ajaxSaveForm(frmSave){
		// Validate the form, then if it's ok...
		// Hide the form, gather it's data and show the ajax spinner until a response comes back.
		// Then fill the container with the response.
		
		var formTest = $(frmSave).validate({
			highlight: function(element, errClass) {
				$(element).tooltip('show');
			},
			unhighlight: function(element, errClass) {
				$(element).tooltip('hide');
			},
			errorPlacement: function(err, element) {
				err.hide();
			}
		}).form();

		if (formTest == true) {
			$(':input').tooltip('hide');
			frmSave.hide();
			var target = frmSave.attr('action');
			var formData = frmSave.serialize();
			frmSave.parent().append('<img src="/images/ajax-loader-trans.gif" align="center">');
			var itemContainer = frmSave.parents('.editMode').attr('id');
			
			$.ajax({
				url: target,
				data: formData,
				type: 'POST',
				context: frmSave,
				success: function(data){
					frmSave.parents('.editMode').html(data).removeClass('editMode');
					var btnAjax = $('[data-target-id="' + itemContainer +'"]');
					btnAjax.removeClass('disabled').bind('click', function(){ ajaxEditForm($(this)); });
				},
				error: function(){
					frmSave.parents('.editMode').html(currentVals[itemContainer]).removeClass('editMode');
				}
			});
		}

		return false;
	} 

	function ajaxEditFormCancel(btnCancel){
		// Hide the form and replace the container content as it was before from the currentVals array
		var itemContainer = btnCancel.parents('.editMode').attr('id');
		$('#' + itemContainer).html(currentVals[itemContainer]).removeClass('editMode');
		$(':input').tooltip('hide');
		var btnAjax = $('[data-target-id="' + itemContainer +'"]');
		btnAjax.removeClass('disabled').bind('click', function(){ ajaxEditForm($(this)); });
	}

	function ajaxEditForm(btnAjax){
		// Click event handler for the add 'x' buttons.
		// Store the content in currentvals, then use ajax to get the form and put it in the container.
		// If ajax fails, just replace the content in the container.

		var target = btnAjax.attr('data-target');
		var containerID = btnAjax.attr('data-target-id');

		// Store the contents of the content container first in case we need to revert back to it.
		var container = $('#' + containerID);
		currentVals[containerID] = container.html().trim();
		container.html('<img src="/images/ajax-loader-trans.gif" align="center">');
		btnAjax.addClass('disabled').unbind('click');

		$.ajax({
			url: target,
			context: container,
			success: function(data){
				container.html(data).addClass('editMode');
				$('.btn-ajax-cancel').bind('click', function(){ ajaxEditFormCancel($(this)); });
				$('.frm-ajax-save').bind('submit' , function(){ return ajaxSaveForm($(this)); });
			},
			error: function(){
				container.html(currentVals[containerID]);
			}
		});

	}

	function singleFieldEditForm(container){
			var target = container.attr('target');			
			var containerID = container.attr('id');
			currentVals[containerID] = container.html().trim();
			container.removeClass('editable').unbind('click').html('<img src="/images/ajax-loader-trans.gif" align="center">');

			$.ajax({
					url: target,
					context: container,
					success: function(data){
						$(this).html(data).addClass('editMode');
						$('input', this).focus().select();
					},
					error: function(){
						$(this).html(currentVals[containerID]);
					}
			});
	}
</script>


