<? $this->load->view('common/header'); ?>
	<div class="row">
		<header class="span8">
			<h1><?=$headline;?></h1>
			<? if(isset($intro)):?>
			<p class="lead"><?=$intro;?></p>
			<? endif;?>
		</header>
		<div class="span4">
			<? $buttons = array(
								array(
									'title' => 'Public Page',
									'action' => 'regatta/view',
									'parameters' => '',
									'type' => 'link',
									'url' => base_url('clubs/view/' . $this->session->userdata('club_name') . '/' . $this->session->userdata('club_id')),
									'icon' => 'share',
									'attributes' => 'target="_blank"',
									'classes' => ''
									)
				);
				$this->load->view('common/toolbar', array('buttons' => $buttons));
			?>
		</div>
	</div>
	<div class="row">
		<div class="span12">
			<section class="portlet leading">
				<header>
					<h2>Current Active Regattas</h2>
					<div class="btn-group pull-right">
						<a class="btn" href="regatta/create"><i class="icon-plus"></i> New Regatta</a>
						<a class="btn" href="<?=base_url('regatta/list_all');?>"><i class="icon-list"></i> Show All</a>
					</div>
					<div class="clearfix"></div>
				</header>
				<section>
					<? $this->load->view('regattas/tbl_list_regattas');?>
				</section>
			</section>
		</div>
	</div>
	<div class="row">
		<div class="span6">
			<section class="portlet leading">
				<header>
					<h2>Recent Races</h2>
					<div class="btn-group pull-right">
						<a class="btn" href="<?=base_url('/race/input');?>"><i class="icon-plus"></i> Input Race Results</a>
					</div>
					<div class="clearfix"></div>
				</header>
				<section>
					<? if($recent_races) $this->load->view('regattas/tbl_recent_races');?>
				</section>
			</section>
		</div>
		<div class="span6">
			<section class="portlet leading">
				<header>
					<h2>Calendar</h2>
					<div class="clearfix"></div>
				</header>
				<section>
				
				</section>
			</section>
		</div>
	</div>
<? $this->load->view('common/footer'); ?>