<div class="container_12 clearfix leading">
	<div class="grid_12">
		<div id="demo" class="clearfix">
			<? 
				$main_toolbar = array(
							array(
								'title' => 'Add New Boat',
								'action' => 'boat/create',
								'classes' => 'icon-with-text',
								'parameters' => '',
								'icon' => '10'
							)
				);
				$this->load->view('common/toolbar', array('buttons'=>$main_toolbar));
				$this->load->view('boats/tbl_list_boats');
			?>
			<div class="leading">
				<? $this->load->view('common/toolbar', array('buttons'=>$main_toolbar)); ?>
			</div>
		</div>
	</div>
</div>