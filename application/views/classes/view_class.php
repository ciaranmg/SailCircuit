<? $this->load->view('common/header');?>
<div class="row">
	<header class="span6">
		<h1 class="editable" id="hc_name" target="<?=base_url('ajax/edit/classes/name/text') . '/' . $class->id;?>"><?=$class->name;?></h1>
		<p id="hc_description" class="lead editable" target="<?=base_url("ajax/edit/classes/description/text/" .$class->id);?>"><?if($class->description != ''): echo $class->description; else: echo '<span class="light">Click to Edit Description</span>'; endif;?></p>
	</header>
	<div class="span6 leading">
		<?
			$buttons = array(
						
						array(
								'title'=>'Refresh',
								'action'=>'race/edit',
								'parameters' => $class->id, //Todo: Insert class ID
								'classes' => ($class->status == 'modified') ? 'btn-danger' : ' hidden',
								'icon' => 'refresh icon-white',
							),
						array(
							'title' => 'Display Settings',
							'type' => 'button',
							'action' => '#classes/edit',
							'parameters' => $class->id,
							'classes' => 'show-hide',
							'icon' => 'list-alt',
							'attributes' => 'data-target-id="ctr-column-chooser"'
							),
						array(
								'title' => 'Public Page',
								'action' => 'classes/view',
								'url' => base_url('clubs/view_class/' . $this->session->userdata('club_name') . '/'. $this->session->userdata('club_id') .'/' . $class->id),
								'parameters' => '',
								'classes' => '',
								'icon' => 'share',
								'type' => 'link',
								'attributes' => 'target="_blank"'

							),
						array(
								'title'=> 'Delete Class',
								'action' => '#classes/delete',
								'classes' => '',
								'parameters' => $class->id,
								'icon' => 'trash',
								'attributes' => 'data-toggle="modal" data-target="#delete_class_modal"'
					)
			);
			
			$boat_buttons = array(
								array(
									'title' => 'Edit Class Boats',
									'type' => 'button',
									'action'=> '#class/boats',
									'parameters' => $class->id,
									'classes'=>'btn-ajax-activate',
									'icon' => 'pencil',
									'attributes' => 'data-target-id="ctr-class-boats" data-target="'. base_url('classes/ajax_boat_selector/' . $class->id) .'"'
								)
				);
			$race_buttons = array(
								array(
									'title' => 'Add Races',
									'type'=> 'button',
									'action' => '#classes/edit',
									'parameters' => $class->id,
									'classes' => 'btn-ajax-activate',
									'icon' => 'plus',
									'attributes' => 'data-target-id="ctr-ajax-races" data-target="'. base_url('race/ajax_add_races/' . $class->id). '"'
								)
					);
			
			$this->load->view('common/toolbar', array('buttons'=> $buttons));
		?>
	</div>
</div>
<div class="row">
	<section id="ctr-column-chooser" class="span12">
		<? $this->load->view('classes/display_settings');?>
	</section>
</div>
<div class="row">
	<div class="span5 leading">
		<section class="portlet">
			<header>
				<h2 class="editable" id="h2_name" target="<?=base_url('ajax/edit/classes/name/text') . '/' . $class->id;?>"><?=$class->name;?></h2>
				<div class="clearfix"></div>
			</header>
			<section>
				<table class="table table-bordered">
					<tr>
						<th>Discards</th>
						<td class="editable" id="hc_edit_class_discard_<?=$class->id;?>" target="<?=base_url('ajax/edit/classes/discards/text/'.$class->id);?>"><?=$class->discards;?></td>
					</tr>
					<tr>
						<th>Minimum number of races Before Discard</th>
						<td class="editable" id="hc_edit_class_min_races_discard_<?=$class->id;?>" target="<?=base_url('ajax/edit/classes/min_races_discard/text/'.$class->id);?>"><?=$class->min_races_discard;?></td>
					</tr>
					<tr>
						<th>Rating System</th>
						<td class="editable" id="hc_edit_class_rating_<?=$class->id;?>" target="<?=base_url('ajax/edit/classes/rating_system_id/dropdown/'.$class->id);?>"><?=$class->handicap_name;?></td>
					</tr>
					<tr>
						<th>Tiebreak System</th>
						<td class="editable" id="hc_edit_class_tiebreak_<?=$class->id;?>" target="<?=base_url('ajax/edit/classes/tiebreak_system/dropdown/'.$class->id);?>"><?=$class->ties_name;?></td>
					</tr>
					<tr>
						<th>Scoring System</th>
						<td class="editable" id="hc_edit_class_scoring_<?=$class->id;?>" target="<?=base_url('ajax/edit/classes/scoring_system/dropdown/'.$class->id);?>"><?=$class->scoring_name;?></td>
					</tr>
				</table>
			</section>
		</section>
	</div>
	<div class="span7 leading">
		<section class="portlet">
			<header>
				<h2>Races</h2>
				<? $this->load->view('common/toolbar', array('buttons' => $race_buttons)); ?>
				<div class="clearfix"></div>
			</header>
			<section id="ctr-ajax-races" class="ajax-container">
				<? $this->load->view('races/tbl_list_races');?>
			</section>
		</section>
	</div>
</div>
<? if($points_table):?>
	<div class="row">
		<div class="span12 leading">
			<section class="portlet">
				<header>
					<h2>Standings</h2>
					<div class="clearfix"></div>
				</header>
				<section>
					<? $this->load->view('classes/tbl_standings');?>
				</section>
			</section>
		</div>
	</div>
<? endif;?>
<div class="row">
	<div class="span12">
		<section class="portlet leading">
			<header>
				<h2><?=($boats) ? sizeof($boats) .' Boats' : 'There are no Boats in this class';?></h2>
				<? $this->load->view('common/toolbar', array('buttons' => $boat_buttons));?>
				<div class="clearfix"></div>
			</header>
			<section id="ctr-class-boats" class="ajax-container">
				<? 
					$this->load->view('boats/tbl_list_boats'); 
				?>
				<div class="clear"></div>
			</section>
		</section>
	</div>
</div>
<?
	$confirm_delete = array(
					'object_id' => $class->id,
					'action' => 'classes/delete',
					'modal_id' =>'delete_class_modal',
					'modal_header' => 'Confirm Delete',
					'modal_content' => 'Are you sure you want to delete the class ' . $class->name ."?<br> All it's races will be deleted too? <br><br> This cannot be undone!",
					'referrer' => $breadcrumb[1]['url']
				);
	$this->load->view('dialogs/confirm_delete', $confirm_delete); 
	$this->load->view('common/footer');
?>