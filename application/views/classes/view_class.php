<div class="container_12">
	<? $this->load->view('common/breadcrumb');?>
	<div class="grid_12 leading">
		<?
			$buttons = array(
						array(
								'title'=>'Edit Class',
								'action'=>'class/edit',
								'parameters' => $class->id, //Todo: Insert class ID
								'classes' => 'icon-with-text',
								'icon' => '165'
						),
						array(
								'title'=> 'Delete Class',
								'action' => 'class/delete',
								'classes' => 'icon-with-text',
								'parameters' => $class->id, //Todo: Insert class ID
								'icon' => '73'
					)
			);
			
			$boat_buttons = array(
								array(
									'title' => 'Add Boats to Class',
									'action'=> 'class/boats',
									'parameters' => $class->id,
									'classes'=>'icon-with-text',
									'icon' => '10'
								)
			);
			
			$this->load->view('common/toolbar', array('buttons'=> $buttons));
		?>
	</div>
	<div class="grid_12 leading">
		<section class="portlet">
			<header>
				<h2>Races</h2>
			</header>
			<section>
				<? $this->load->view('races/tbl_list_races');?>
			</section>
		</section>
	</div>	
	<div class="grid_6">
		<section class="portlet leading">
			<header>
				<h2>Boats</h2>
			</header>
			<section>
				<? 
					$this->load->view('common/toolbar', array('buttons' => $boat_buttons));
					$this->load->view('boats/tbl_list_boats'); 
				?>
				<div class="clear"></div>
			</section>
		</section>
	</div>
	<div class="grid_6 leading">
		<section class="portlet">
			<header>
				<h2>Settings</h2>
			</header>
			<section>
			
			</section>
		</section>
	</div>
</div>