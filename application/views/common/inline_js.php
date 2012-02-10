<script>
	var currentVals = new Array();
	$(function() {
		$('.editable').click(function(){
										singleFieldEditForm($(this));
										});
	});
	
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



/* function(){
			var target = $(this).attr('target');
			
			var containerID = $(this).attr('id');
			
			currentVals[containerID] = $(this).html().trim();
			
			console.log(currentVals);

			$(this).removeClass('editable').unbind('click').html('<img src="/images/ajax-loader-trans.gif" align="center">');

			$.ajax({
					url: target,
					context: $(this),
					success: function(data){
						$(this).html(data).addClass('editMode');
						$('input', this).val(currentVals[containerID]).focus().select();
					},
					error: function(){
						$(this).html(currentVals[containerID]);
					}
			});
		} */
</script>


