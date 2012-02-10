<? $this->load->view('common/inline_js');?>
<div class="container_12">
	<? $this->load->view('common/breadcrumb');?>
	<div class="grid_12 leading">
		<? $buttons = array(
					array(
						'title' => 'Add new Class',
						'action' => 'classes/create',
						'classes' => 'icon-with-text',
						'parameters' => $regatta->id,
						'icon' => '10'
					),
					array(
						'title'=> 'Delete Regatta',
						'action' => 'regatta/delete',
						'classes' => 'icon-with-text',
						'parameters' => $regatta->id,
						'icon' => '73'
					)
				
			);
			$this->load->view('common/toolbar', array('buttons' => $buttons));
		?>
	</div>
	<div class="grid_6">
	<section class="portlet">
		<header>
			<h2 class="editable" id="fc_name" target="/regatta/edit/name/text/<?=$regatta->id;?>">
				<?=$regatta->name?>
			</h2>
		</header>
		<section>
			<table class="full">
			<tr>
				<td class="label">Start Date</td>
				<td class="editable" id="fc_start_date" target="/regatta/edit/start_date/date/<?=$regatta->id;?>">
					<?=sc_date_format($regatta->start_date);?>
				</td>
			</tr>
			<tr>
				<td class="label">End Date</td>
				<td class="editable" id="fc_end_date" target="/regatta/edit/end_date/date/<?=$regatta->id;?>"><?=sc_date_format($regatta->end_date);?></td>
			</tr>
			<tr>
				<td class="label">Description</td>
				<td class="editable" id="fc_description" target="/regatta/edit/description/textarea/<?=$regatta->id;?>"><?=$regatta->description;?></td>
			</tr>
		</table>
		</section>
	</section>
		
	</div>
	<div class="grid_6">
		<section class="portlet">
			<header>
				<h2>Classes</h2>
			</header>
			<section>
				<? $this->load->view('classes/tbl_list_classes');?>
			</section>
		</section>
		
		
	</div>
</div>