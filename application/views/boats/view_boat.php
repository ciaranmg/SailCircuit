<? $this->load->view('common/header');?>
<div class="row">
	<header class="span6">
		<h1 id="hc_name" class="editable" target="<?=base_url('ajax/edit/boats/name/text') .'/' . $boat->id;?>"><?=$boat->name;?></h1>
	</header>
	<div class="span6"></div>
</div>
<div class="row leading">
		<div class="span7">
				<section class="portlet" id="boatDisplay">
					<header>
						<h2 class="editable" target="<?=base_url('ajax/edit/boat/name/text') .'/' . $boat->id;?>"><?=$boat->name?></h2>
						<div class="clearfix"></div>
					</header>
					<section>
						<table class="table table-bordered">
							<tbody>
								<tr>	
									<th class="" width="30%">Sail Number</th>
									<td id="tb_sail" class="editable" target="<?=base_url('ajax/edit/boats/sail_number/text') .'/' . $boat->id;?>"><?=$boat->sail_number?></td>
								</tr>
								<tr>	
									<th class="">Name</th>
									<td id="tb_name" class="editable" target="<?=base_url('ajax/edit/boats/name/text') .'/' . $boat->id;?>"><?=$boat->name?></td>
								</tr>
								<tr>	
									<th class="">LOA</th>
									<td id="tb_length" class="editable" target="<?=base_url('ajax/edit/boats/length/text') .'/' . $boat->id;?>"><?=number_format(floatval($boat->length), 2, '.', ',');?></td>
								</tr>
								<tr>	
									<th class="">Make/Builder</th>
									<td id="tb_make" class="editable" target="<?=base_url('ajax/edit/boats/make/text') .'/' . $boat->id;?>"><?=$boat->make?></td>
								</tr>
								<tr>	
									<th class="">Model</th>
									<td id="tb_model" class="editable" target="<?=base_url('ajax/edit/boats/model/text') .'/' . $boat->id;?>"><?=$boat->model?></td>
								</tr>
								<tr>
									<th>Type</th>
									<td id="tb_type" class="editable" target="<?=base_url('ajax/edit/boats/main_class/dropdown/' . $boat->id);?>"><?=$boat->main_class;?></td>
								</tr>
								<tr>
									<th>Class</th>
									<td id="tb_sub_class" class="editable" target="<?=base_url('ajax/edit/boats/sub_class/text/' .$boat->id);?>"><?=$boat->sub_class;?></td>
								</tr>
							</tbody>
						</table>
					</section>
				</section>
				<section class="portlet leading">
					<header>
						<h2>Handicaps</h2>
						<?
							$add_handicap = array(
								array(
								'type' => 'button',
								'title' => 'Add Handicap',
								'action' => 'boats/add_handicap',
								'classes' => 'btn-ajax-activate',
								'parameters' => $boat->id,
								'icon' => 'time',
								'attributes' => 'data-target-id="ctr-ajax-handicaps" data-target="'. base_url('boats/add_handicaps') . '/' .$boat->id . '"'
								)
							);
							$this->load->view('common/toolbar', array('buttons' => $add_handicap));
						?>
						<div class="clearfix"></div>
					</header>
					<section id="ctr-ajax-handicaps" class="ajax-container">
						<? if(isset($handicaps)) $this->load->view('boats/tbl_handicaps');?>
					</section>
				</section>

				<section class="portlet leading">
					<header>
						<h2>Recent Races</h2>
						<div class="clearfix"></div>
					</header>
					<section class="ajax-container">
						<? $this->load->view('boats/recent_races');?>
					</section>
				</section>
		</div>
		<div class="span5">
			<section class="portlet headerless">
				<section>
					<? $this->load->view('boats/profile_photo'); ?>
				</section>
			</section>
			<section class="portlet leading" id="boatOwners">
				<header>
					<h2>Owners</h2>
					<?
						$add_owner = array(
							array(
								'type' => 'button',
								'title' => 'Add Owner',
								'action' => 'owner/create',
								'classes' => 'btn-ajax-activate',
								'parameters' => $boat->id,
								'icon' => 'user',
								'attributes' => 'data-target-id="ctr-ajax-owners" data-target="'. base_url("owner/create/" .$boat->id) . '"'
							)
						);
						$this->load->view('common/toolbar', array('buttons' => $add_owner));
					?>
					<div class="clearfix"></div>
				</header>
				<section class="ajax-container" id="ctr-ajax-owners">
					<? if(isset($owners)) $this->load->view('owners/list_owners'); ?>
				</section>
			</section>
		</div>
</div>
<? 
	$this->load->view('common/footer');
?>