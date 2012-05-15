<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>SailCircut - Racing results program</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="SailCircuit">

    <!-- Le styles -->
    <link href="<?=base_url()?>css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>
    <link href="<?=base_url()?>css/bootstrap-responsive.css" rel="stylesheet">
    <link href="<?=base_url()?>css/sailcircuit.css" rel="stylesheet">
    <link href="<?=base_url()?>css/jqueryui/jquery-ui-1.8.16.custom.css" rel="stylesheet">
    <link href="<?=base_url()?>css/jqueryui/jquery.ui.1.8.16.ie.css" rel="stylesheet">
    
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?=base_url()?>ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?=base_url()?>ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?=base_url()?>ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="<?=base_url()?>ico/apple-touch-icon-57-precomposed.png">
  </head>
<body class="login" style="overflow: hidden;">
	<div class="container">
		<div class="row login-box">
			<section class="login-box-top">
				<header>
					<h2 class="logo">SailCircuit Login</h2>
					<div class="row">
						<div class="span12">
							<?
								if($this->session->flashdata('message')){
									print '<div class="alert fade in">
									<button class="close" data-dismiss="alert">×</button>';
									print $this->session->flashdata('message');
									print '</div>';
								}
								if($this->session->flashdata('err_message')){
									print '<div class="alert alert-error fade in">
									<button class="close" data-dismiss="alert">×</button>';
									print $this->session->flashdata('err_message');
									print '</div>';
								}
							?>
						</div>
					</div>
				</header>
				<section>
					<?php echo form_open('user/login'); ?>
						<div class="fieldContainer">
							<input type="hidden" name="action" value="<?=$action?>">
							<input type="hidden" name="redirect" value="<?=$redirect?>">
							<div class="user-pass">
								<input type="text" id="username" class="full" value="" name="username" required="required" placeholder="Email Address" />
								<input type="password" id="password" class="full" value="" name="password" required="required" placeholder="Password" />
							</div>
							<p class="clearfix">
								<span class="fl" style="line-height: 23px;">
									<label class="choice" for="remember">
										<input type="checkbox" id="remember" class="" value="1" name="remember"/>
										Keep me logged in
									</label>
								</span>		
								<button class="btn btn-large btn-primary" type="submit">Login</button>
							</p>
						</div>
					<?=form_close();?>
				</section>
			</section>  
		</div>
		<!-- footer -->
		<footer>
			<p>&copy; SailCircuit <?=date('Y');?></p>
		</footer>
	</div>  

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script src="<?=base_url()?>js/jqueryui/jquery-ui-1.8.16.custom.min.js"></script>
    <script src="<?=base_url()?>js/bootstrap-transition.js"></script>
    <script src="<?=base_url()?>js/bootstrap-alert.js"></script>
    <script src="<?=base_url()?>js/bootstrap-modal.js"></script>
    <script src="<?=base_url()?>js/bootstrap-dropdown.js"></script>
    <script src="<?=base_url()?>js/bootstrap-scrollspy.js"></script>
    <script src="<?=base_url()?>js/bootstrap-tab.js"></script>
    <script src="<?=base_url()?>js/bootstrap-tooltip.js"></script>
    <script src="<?=base_url()?>js/bootstrap-popover.js"></script>
    <script src="<?=base_url()?>js/bootstrap-button.js"></script>
    <script src="<?=base_url()?>js/bootstrap-collapse.js"></script>
    <script src="<?=base_url()?>js/bootstrap-carousel.js"></script>
    <script src="<?=base_url()?>js/bootstrap-typeahead.js"></script>
    <script type="text/javascript" src="<?=base_url()?>js/bootstrap-tooltip.js"></script>
    <script src="<?=base_url()?>js/tinyscrollbar.js"></script>
    <? $this->load->view('common/inline_js');?>
  </body>
</html>