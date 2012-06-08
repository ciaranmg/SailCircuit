<? $this->load->view('common/header');?>
	<div class="row">
		<header class="span6">
			<h1 class="editable" id="hc_name" target="<?=base_url('ajax/edit/regatta/name/text') . '/' . $regatta->id;?>"><?=$regatta->name;?></h1>
			<? if(isset($regatta->description)):?>
			<p class="lead"><?=$regatta->description;?></p>
			<? endif;?>
		</header>
		<div class="span6">
			<? $buttons = array(
						array(
							'title' => 'Add new Class',
							'action' => 'classes/create',
							'classes' => '',
							'parameters' => $regatta->id,
							'icon' => 'plus'
						),
						array(
							'title'=> 'Delete Regatta',
							'action' => '#regatta/delete',
							'classes' => '',
							'parameters' => $regatta->id,
							'icon' => 'trash',
							'attributes' => 'data-toggle="modal" data-target="#delete_regatta_modal"'
						),
						array(
							'title' => 'Public Page',
							'action' => 'regatta/view',
							'classes' => '',
							'parameters' => $regatta->id,
							'type' => 'link',
							'icon' => 'share',
							'attributes' => 'target="_blank"',
							'url' => base_url('clubs/view_series/' . $this->session->userdata('club_name') . '/' . $this->session->userdata('club_id') . '/' . $regatta->id)
							)
					);
				$this->load->view('common/toolbar', array('buttons' => $buttons));
			?>
		</div>
	</div>
	<div class="row">
		<div class="span6 leading">
			<section class="portlet">
				<header>
					<h2 class="editable" id="fc_name" target="<?=base_url('ajax/edit/regatta/name/text') . '/' . $regatta->id;?>">
						<?=$regatta->name;?>
					</h2>
					<div class="clearfix"></div>
				</header>
				<section>
					<table class="table table-bordered">
					<tr>
						<th class="">Start Date</th>
						<td class="editable" id="fc_start_date" target="<?=base_url('ajax/edit/regatta/start_date/date') . '/' . $regatta->id;?>">
							<?=sc_date_format($regatta->start_date);?>
						</td>
					</tr>
					<tr>
						<th class="">End Date</th>
						<td class="editable" id="fc_end_date" target="<?=base_url('ajax/edit/regatta/end_date/date') . '/' . $regatta->id;?>"><?=sc_date_format($regatta->end_date);?></td>
					</tr>
					<tr>
						<th class="">Description</th>
						<td class="editable" id="fc_description" target="<?=base_url('ajax/edit/regatta/description/textarea') . '/' . $regatta->id;?>"><?=$regatta->description;?></td>
					</tr>
				</table>
				</section>
			</section>
		</div>
		<div class="span6 leading">
			<section class="portlet">
				<header>
					<h2>Classes</h2>
					<div class="btn-group pull-right">
						<?
							$buttons = array(array('title' => 'Add new Class', 'action' => 'classes/create', 'classes' => '', 'parameters' => $regatta->id, 'icon' => 'plus'));
							$this->load->view('common/toolbar', array('buttons' => $buttons));
						?>
					</div>
					<div class="clearfix"></div>
				</header>
				<section>
					<? $this->load->view('classes/tbl_list_classes');?>
				</section>
			</section>
		</div>
	</div>
<?
	$confirm_delete = array(
					'object_id' => $regatta->id,
					'action' => 'regatta/delete',
					'modal_id' =>'delete_regatta_modal',
					'modal_header' => 'Confirm Delete',
					'modal_content' => 'Are you sure you want to delete the regatta ' . $regatta->name ."?<br> All it's <strong>classes</strong>, and <strong>races</strong> will be deleted too? <br><br> This cannot be undone!",
				);
	$this->load->view('dialogs/confirm_delete', $confirm_delete);
	$this->load->view('common/footer');
?>