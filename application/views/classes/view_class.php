<? $this->load->view('common/header');?>
<div class="row">
	<header class="span6">
		<h1 class="editable" id="hc_name" target="<?=base_url('ajax/edit/classes/name/text') . '/' . $class->id;?>"><?=$class->name;?></h1>
		<? if(isset($class->description)):?>
			<p id="hc_description" class="lead editable" target="<?=base_url('ajax/edit/classes/description/text') . '/' . $class->id;?>"><?=$class->description;?></p>
		<? endif;?>
	</header>
	<div class="span6 leading">
		<?
			$buttons = array(
						/* Making the classes a one-way street for now 
						Todo: Make classes editable
						array(
								'title'=>'Edit Class',
								'action'=>'classes/edit',
								'parameters' => $class->id, //Todo: Insert class ID
								'classes' => '',
								'icon' => 'edit'
						), */
						array(
								'title'=> 'Delete Class',
								'action' => '#classes/delete',
								'classes' => '',
								'parameters' => $class->id, //Todo: Insert class ID
								'icon' => 'trash',
								'attributes' => 'data-toggle="modal" data-target="#delete_class_modal"'
					)
			);
			
			$boat_buttons = array(
								array(
									'title' => 'Add Boats to Class',
									'action'=> 'class/boats',
									'parameters' => $class->id,
									'classes'=>'',
									'icon' => 'plus'
								)
				);
			$race_buttons = array(
								array(
									'title' => 'Add Races',
									'action' => 'classes/add-races',
									'parameters' => $class->id,
									'classes' => '',
									'icon' => 'plus'
								)
					);
			
			$this->load->view('common/toolbar', array('buttons'=> $buttons));
		?>
	</div>
</div>
<div class="row leading">
	<div class="span5">
		<section class="portlet">
			<header>
				<h2 class="editable" id="h2_name" target="<?=base_url('ajax/edit/classes/name/text') . '/' . $class->id;?>"><?=$class->name;?></h2>
				<div class="clearfix"></div>
			</header>
			<section>
				<table class="table table-bordered">
					<tr>
						<th>Discards</th>
						<td><?=$class->discards;?></td>
					</tr>
					<tr>
						<th>Rating System</th>
						<td><?=$class->handicap_name;?></td>
					</tr>
					<tr>
						<th>Tiebreak System</th>
						<td><?=$class->ties_name;?></td>
					</tr>
					<tr>
						<th>Scoring System</th>
						<td><?=$class->scoring_name;?></td>
					</tr>
				</table>
			</section>
		</section>
	</div>
	<div class="span7">
		<section class="portlet">
			<header>
				<h2>Races</h2>
				<? $this->load->view('common/toolbar', array('buttons' => $race_buttons)); ?>
				<div class="clearfix"></div>
			</header>
			<section>
				<? $this->load->view('races/tbl_list_races');?>
			</section>
		</section>
	</div>
</div>
<div class="row">
	<div class="span12">
		<section class="portlet leading">
			<header>
				<h2>Boats</h2>
				<? $this->load->view('common/toolbar', array('buttons' => $boat_buttons));?>
				<div class="clearfix"></div>
			</header>
			<section>
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