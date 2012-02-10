<? $this->load->view('common/header'); ?>

<h1>Dashboard</h1>
<div class="grid_4 alpha">
	<!-- Buttons Here -->
	<?=sc_button('results/input', 'Input Results', 'primary center');?>
</div>
<div class="grid_8 omega">
	<? $this->load->view('races/recent'); ?>
</div>
<div class="grid_12 alpha omega">
	<!-- Regatta List Here -->
	<? $this->load->view('regattas/list'); ?>
</div>

<? $this->load->view('common/footer'); ?>