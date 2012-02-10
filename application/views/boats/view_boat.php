<div class="container_12 clearfix leading">
	<? if(isset($boat)): ?>
		<div class="grid_12">
			<div class="ac">
				<ul class="toolbar clearfix" style="display: inline-block;">
					<? if($this->userlib->check_permission('boat/edit')): ?>
						<li>
							<a href="boat/edit/<?=$boat->id?>" class="button" title="Edit <?=$boat->name?>">Edit</a>
						</li>
					<? endif;?>
				</ul>
			</div>
		</div>
		<div class="grid_7 alpha">
				<section class="portlet" id="boatDisplay">
					<header>
						<h2><?=$boat->name?></h2>
					</header>
					<section>
						<table class="full">
							<tbody>
								<tr>	
									<td class="label">Sail Number</td>
									<td><?=$boat->sail_number?></td>
								</tr>
								<tr>	
									<td class="label">Name</td>
									<td><?=$boat->name?></td>
								</tr>
								<tr>	
									<td class="label">LOA</td>
									<td><?=$boat->length?></td>
								</tr>
								<tr>	
									<td class="label">Make</td>
									<td><?=$boat->make?></td>
								</tr>
								<tr>	
									<td class="label">Model</td>
									<td><?=$boat->model?></td>
								</tr>
							</tbody>
						</table>
					</section>
				</section>
				<? $this->load->view('boats/handicaps');?>
				<? $this->load->view('boats/recent_races');?>
		</div>
		<div class="grid_5 omega">
			<? $this->load->view('boats/profile_photo'); ?>
			<? if(isset($owners)) $this->load->view('owners/list_owners'); ?>
		</div>
	<? else: ?>
		<div class="grid_12">
			<h1>No Data loaded</h1>
		</div>
	<? endif; ?>
</div>