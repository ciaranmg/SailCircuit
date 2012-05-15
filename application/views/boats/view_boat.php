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
								'title' => 'Add Handicap',
								'action' => 'boats/add_handicap',
								'classes' => '',
								'parameters' => $boat->id,
								'icon' => 'time'
								)
							);
							$this->load->view('common/toolbar', array('buttons' => $add_handicap));
						?>
						<div class="clearfix"></div>
					</header>
					<section>
						<? if(isset($handicaps)) $this->load->view('boats/handicaps');?>
					</section>
				</section>
				<section class="portlet leading">
					<header>
						<h2>Recent Races</h2>
						<div class="clearfix"></div>
					</header>
					<section>
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
						$add_boat = array(
							array(
							'title' => 'Add Owner',
							'action' => 'owner/create',
							'classes' => '',
							'parameters' => $boat->id,
							'icon' => 'user'
							)
						);
						$this->load->view('common/toolbar', array('buttons' => $add_boat));
					?>
					<div class="clearfix"></div>
				</header>
				<section>
					<? if(isset($owners)) $this->load->view('owners/list_owners'); ?>
				</section>
			</section>
		</div>
</div>
<? 
	$this->load->view('common/footer');
?>