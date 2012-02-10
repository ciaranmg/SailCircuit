<? if($ajax !== true) $this->load->view('common/header'); ?>
	
<div id="owner" class="recordDisplay">
	<table>
		<tr>
			<td>Name</td>
			<td><?=$owner->name?></td>
		</tr>
		<tr>
			<td>Email</td>
			<td><?=$owner->email?></td>
		</tr>
		<tr>
			<td>Phone</td>
			<td><?=$owner->phone?></td>
		</tr>
	</table>
</div>	
	
<? if($ajax !== true) $this->load->view('common/footer'); ?>
