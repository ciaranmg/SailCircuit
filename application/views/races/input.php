<? $this->load->view('common/header');?>
<?
	$textarea = array(
				'name' => 'race_data',
				'id' => 'race_data',
				'value' => '',
				'placeholder' => 'Input, or paste your recorded race data here',
				'class'=> 'required',
				'data-original-title'=>'You must enter some data'
            );
	$hidden = array(
				'race_id' => '',
				'action' => base_url('race/ajax_handle_data'),
				'submit' => 'submit'
		);
?>

<div class="page-header">
	<h1>Input Race Data <small>Insert race data, choose the race and view the results</small></h1>
</div>
<? if(isset($help)) $this->load->view('help/'.$help);?>
<div class="row">
	<?=form_open($hidden['action'], array('id'=>'frm-race-data-input'), $hidden);?>
		<div class="span8">
			<div id="ctr-race-data" class="well">
				<div class="step1">
					<label for="race_data">Race Data</label>
					<?=form_textarea($textarea);?>
				</div>
			</div>
		</div>
		<div class="span4">
			<div id="ctr-race-info" class="well">
				<? $this->load->view('races/race_input_picker');?>
				<div class="btn-group leading pull-right">
					<a class="btn disabled" id="button-back"><i class="icon-chevron-left"></i> Back</a>
					<button type="submit" class="btn btn-primary btn-ajax-save" id="button-submit">Next <i class="icon-chevron-right icon-white"></i></button>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	<?=form_close();?>
</div>

<div id="debug"></div>

<script type="text/javascript">

	var formState = new Array();

	$(function(){
		$('#frm-race-data-input').submit(function(){
			validateForm($(this));
			return false;
		});
		initHandlers();
	});

	function initHandlers(){

		$('#timer-elapsed').on('change', function(){
			$('#datetimepicker').slideUp();
		});
		
		$('#timer-time').on('change', function(){
			$('#datetimepicker').slideDown().removeClass('hidden');
		});
		
		$("#regatta_picker").on('change', function(){
		    $.getJSON("<?=base_url('race/ajax_classes_list');?>/" + $(this).val(),{ajax: 'true'}, function(j){
				var options = '';
				for (var i = 0; i < j.length; i++) {
					options += '<option value="' + j[i].value + '">' + j[i].display + '</option>';
				}
				$("#class_picker").html(options);
				});
			});

		$('#class_picker').on('change', function(){
			$.getJSON('<?=base_url('race/ajax_races_list');?>/' + $(this).val(), {ajax: 'true'}, function(j){
				var options ='';
				for(var i = 0; i<j.length; i++){
					options += '<option value="' + j[i].value + '">' + j[i].display + '</option>';
				}
				$('#race_picker').html(options);
			});
		});

		$('#race_picker').on('change', function(){
			$.getJSON('<?=base_url('race/get_race_datetime');?>/' + $(this).val(), {ajax: 'true'}, function(race_start){
				$('#race_datetime-1').val(race_start['date']);
				$('#race_datetime-2').val(race_start['time']);
			});
		});
	} // end function initHandlers

	function changeButtonState(button, label, state){
		if(state == 'enabled'){
			button.addClass('btn-primary').html(label + ' <i class="icon-chevron-right icon-white"></i>').removeAttr('disabled').removeClass('disabled');
		}else{
			button.removeClass('btn-primary').html(label + ' <i class="icon-ajax-spinner "></i>');
		}
	}

	function restoreForm(){
		$('#ctr-race-data .step2').fadeOut().remove();
		$('#ctr-race-data .step1').slideDown();
		changeButtonState($('#button-submit'), 'Next', 'enabled');
		$('#ctr-race-info :input').removeClass('disabled').removeAttr('disabled');
		$('#button-back').addClass('disabled');
		// initHandlers();
	}

	function validateForm(){
		if($('#frm-race-data-input').validate({
			highlight: function(element, errClass) {
				$(element).tooltip('show');
			},
			unhighlight: function(element, errClass) {
				$(element).tooltip('hide');
			},
			errorPlacement: function(err, element) {
				err.hide();
			}
		}).form()){
			if($('#confirm').val() == 'confirm'){
				ajaxRaceDataStep2($('#frm-race-data-input'));
			}else{
				ajaxRaceDataStep1($('#frm-race-data-input'));
			}
		}
		return false;
	}

	function ajaxRaceDataStep2(formInput){
		var target = formInput.attr('action');
		var formData = formInput.serialize();

		var savedState = $('#ctr-race-data .step2').html();
		$('#ctr-race-data .step2').html('<div class="large-ajax-spinner">&nbsp;</div>');
		$('#ctr-race-info').parent('.span4').fadeOut();
		$('#ctr-race-data').parent('.span8').animate({width: '100%'}).addClass('span12');
		$.ajax({
			url: target,
			data: formData,
			type: 'POST',
			context: formInput,
			success: function(data){

			},
			error: function(){
				$('#ctr-race-data .step2').html(savedState);
				alert('Sorry, there was an error');
			}
		});
	}

	function ajaxRaceDataStep1(formInput){
		// The form will have been validated already 
		// Capture the contents of the two containers in case we need to revert
		// Serialize the form and send via ajax.	
		
		var target = formInput.attr('action');
		var formData = formInput.serialize();
		
		$('#ctr-race-info :input').addClass('disabled').attr('disabled', 'disabled');
		changeButtonState($('#button-submit'), 'Wait...', 'disabled');
		
		$('#button-back').removeClass('disabled').on('click', function(){ restoreForm(); });

			$.ajax({
				url: target,
				data: formData,
				type: 'POST',
				context: formInput,
				success: function(data){
					$('#ctr-race-data').append(data);
					$('#ctr-race-data .step1').slideUp();
					changeButtonState($('#button-submit'), 'Confirm', 'enabled');
				},
				error: function(){
					restoreForm();
					alert('Sorry, There was an error');
				} 
			});
		return false;
	}
</script>
<? $this->load->view('common/footer');?>