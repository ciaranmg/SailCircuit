<script>	
	$(function() {
		$('.editable').click(function(){
			singleFieldEditForm($(this));
		});
		$('.btn-ajax-activate').click(function(){
			ajaxEditForm($(this));
		});
		$('.scrollable').tinyscrollbar();  
		$( ".datepicker" ).datepicker();
		$('.btn-mini, .sc-icon-only').tooltip();
		$('.sc-delete').click(function(){
			var button = $(this);
			$(button.attr('href') + ' input[name=object_id]').val(button.attr('data-subject-id'));
			$(button.attr('href') + ' .modal-body').html('<p>' + button.attr('data-subject-title') + '</p>');
			$(button.attr("href")).modal();
		})
	});


	var currentVals = new Array();

	function ajaxSaveForm(frmSave){
		// Hide the form, gather it's data and show with the ajax spinner
		
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
		var itemContainer = btnCancel.parents('.editMode').attr('id');
		$('#' + itemContainer).html(currentVals[itemContainer]).removeClass('editMode');
		var btnAjax = $('[data-target-id="' + itemContainer +'"]');
		btnAjax.removeClass('disabled').bind('click', function(){ ajaxEditForm($(this)); });
	}

	function ajaxEditForm(btnAjax){
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


