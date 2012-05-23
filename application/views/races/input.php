<? $this->load->view('common/header');?>
<?
	$textarea = array(
				'name' => 'race_data',
				'id' => 'race_data',
				'value' => '',
				'placeholder' => 'Input, or paste your recorded race data here'
            );
	$hidden = array(
				'race_id' => '',
				'action' => base_url('race/input_results'),
				'submit' => 'submit'
		);
?>

<div class="page-header">
	<h1>Input Race Data <small>Insert race data, choose the race and view the results</small></h1>
</div>
<div class="row">
	<div class="span12">
		<div class="tabbable tabs-below">
			<div class="tab-content help hidden">
				<hr>
				<h2>Help</h2>
				<ul>
					<li>Put each entry on a separate line, in the format <strong>sail-number,time</strong>.</li>
					<li>Time takes the format hours:minutes:seconds, or days:hours:minutes:seconds. For example: 1:30:45</li>
					<li>You can also put abbreviations for non-finish results: <strong>DNC, DNS, OCS, BFD, DNF, RAF, OOT, DSQ, DNE, DGM</strong> </li>
					<li>If a boat is assigned to a race but you don't have a result it will be treated as <strong>DNC</strong></li>
					<li>You don't need to pick a race straight away, the system will suggest races based on your data.</li>
					<li>If a sail number is not found, the system will search other information such as bow number, alternative sail numbers etc.</li>
				</ul>
				<div class="row">
					<div class="span6">
						<h3>Elapsed Times</h3>
<pre>
1234,1:30:20
5679,1:32:10
3453,1:29:50
2424,DNC</pre>
						<p>This example has sail numbers, with hours, minutes, and seconds for the race time. You can also record days in your elapsed time</p>
					</div>
					<div class="span6">
						<h3>Finish Time</h3>
							
<pre>
1234,15:30:20
5679,15:32:10
3453,15:29:50
2424,DNC</pre>
						<p>You can record the time a boat crosses the finish line. Remember to set the start time for the race</p>
					</div>
				</div>
			</div>
			<ul class="nav nav-tabs">
				<li class="pull-right"><a class="show-help">Show Help <i class="icon-chevron-down"></i></a></li>
			</ul>
		</div>
	</div>
</div>
<div class="row">
	<?=form_open($hidden['action'], '', $hidden);?>
		<div class="span8">
			<div id="ctr-race-data" class="well">
				<label for="race_data">Race Data</label>
				<?=form_textarea($textarea);?>
			</div>
		</div>
		<div class="span4">
			<div id="ctr-race-info" class="well">
				<? $this->load->view('races/race_input_picker');?>
			</div>
		</div>
	<?=form_close();?>
</div>


<script type="text/javascript">
	$(function() {
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
		$('#timer-elapsed').click(function(){
			$('#datetimepicker').slideUp();
		});
		$('#timer-time').click(function(){
			$('#datetimepicker').slideDown().removeClass('hidden');
		});
	});
</script>
<? $this->load->view('common/footer');?>