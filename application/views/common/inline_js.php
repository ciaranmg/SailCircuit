<script>	
	$(function() {
		$('.editable').click(function(){
			singleFieldEditForm($(this));
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


