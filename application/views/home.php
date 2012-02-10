<div class="container_12 clearfix leading">
	<div class="grid_12">
		<div class="ac">
			<ul class="toolbar clearfix" style="display: inline-block;">
				<? if($this->userlib->check_permission('race/input')): ?>
					<li>
						<a href="#race/input" class="button" title="Input Race Results">Input Race Results</a>
					</li>
				<? endif;?>
				<? if($this->userlib->check_permission('regatta/create')): ?>
					<li>
						<a href="#regatta/create" class="button" title="Create Regatta">New Regatta</a>
					</li>
				<? endif;?>
				<? if($this->userlib->check_permission('boat/create')): ?>
					<li>
						<a href="#boat/create" class="button" title="Add New Boat">New Boat</a>
					</li>
				<? endif;?>
			</ul>
		</div>
	</div>
	<div class="grid_12">
		<section class="portlet leading">
			<header>
				<h2>Current Regattas</h2>
			</header>
			<section>
				<? $this->load->view('regattas/list_regattas');?>
			</section>
		</section>
	</div>
	<div class="grid_6">
		<section class="portlet leading">
			<header>
				<h2>Recent Races</h2>
			</header>
			<section>
			
			</section>
		</section>
	</div>
	<div class="grid_6">
		<section class="portlet leading">
			<header>
				<h2>Boats</h2>
			</header>
			<section>
			
			</section>
		</section>
	</div>
</div>