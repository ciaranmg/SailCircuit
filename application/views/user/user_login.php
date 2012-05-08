<!doctype html>
<!--[if IE 7 ]>   <html lang="en" class="ie7 lte8"> <![endif]--> 
<!--[if IE 8 ]>   <html lang="en" class="ie8 lte8"> <![endif]--> 
<!--[if IE 9 ]>   <html lang="en" class="ie9"> <![endif]--> 
<!--[if gt IE 9]> <html lang="en"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<head>
<meta charset="utf-8">
<!--[if lte IE 9 ]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->

<!-- iPad Settings -->
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" /> 
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<!-- Adding "maximum-scale=1" fixes the Mobile Safari auto-zoom bug: http://filamentgroup.com/examples/iosScaleBug/ -->
<!-- iPad End -->

<title>vPad</title>

<!-- iOS ICONS -->
<link rel="apple-touch-icon" href="touch-icon-iphone.png" />
<link rel="apple-touch-icon" sizes="72x72" href="touch-icon-ipad.png" />
<link rel="apple-touch-icon" sizes="114x114" href="touch-icon-iphone4.png" />
<link rel="apple-touch-startup-image" href="touch-startup-image.png">
<!-- iOS ICONS END -->

<!-- STYLESHEETS -->

<link rel="stylesheet" media="screen" href="<?=base_url()?>css/reset.css" />
<link rel="stylesheet" media="screen" href="<?=base_url()?>css/grids.css" />
<link rel="stylesheet" media="screen" href="<?=base_url()?>css/style.css" />
<link rel="stylesheet" media="screen" href="<?=base_url()?>css/ui.css" />
<link rel="stylesheet" media="screen" href="<?=base_url()?>css/jquery.uniform.css" />
<link rel="stylesheet" media="screen" href="<?=base_url()?>css/forms.css" />
<link rel="stylesheet" media="screen" href="<?=base_url()?>css/themes/dark/style.css" />

<style type = "text/css">
    #loading-container {position: absolute; top:50%; left:50%;}
    #loading-content {width:800px; text-align:center; margin-left: -400px; height:50px; margin-top:-25px; line-height: 50px;}
    #loading-content {font-family: "Helvetica", "Arial", sans-serif; font-size: 18px; color: black; text-shadow: 0px 1px 0px white; }
    #loading-graphic {margin-right: 0.2em; margin-bottom:-2px;}
    #loading {background-color:#abc4ff; background-image: -moz-radial-gradient(50% 50%, ellipse closest-side, #abc4ff, #87a7ff 100%); background-image: -webkit-radial-gradient(50% 50%, ellipse closest-side, #abc4ff, #87a7ff 100%); background-image: -o-radial-gradient(50% 50%, ellipse closest-side, #abc4ff, #87a7ff 100%); background-image: -ms-radial-gradient(50% 50%, ellipse closest-side, #abc4ff, #87a7ff 100%); background-image: radial-gradient(50% 50%, ellipse closest-side, #abc4ff, #87a7ff 100%); height:100%; width:100%; overflow:hidden; position: absolute; left: 0; top: 0; z-index: 99999;}
</style>

<!-- STYLESHEETS END -->

<!--[if lt IE 9]>
<script src="js/html5.js"></script>
<script type="text/javascript" src="js/selectivizr.js"></script>
<script type="text/javascript" src="js/respond.min.js"></script>
<![endif]-->

</head>
<body class="login" style="overflow: hidden;">
    <div class="login-box">
		<section class="login-box-top">
			<header>
				<h2 class="logo ac">vPad Login</h2>
		
				<? if($this->session->flashdata('err_message')){ ?>
					<div class="leading message error">
						<?=$this->session->flashdata('err_message');?>
					</div>
				<? } ?>
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
							<button class="fr" type="submit">Login</button>
						</p>
					</div>
				</form>
			</section>
		</section>
	</div>        

    
    <!-- MAIN JAVASCRIPTS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.js"></script>
    <script>
    	window.jQuery || document.write("<script src='js/jquery.min.js'>\x3C/script>");
    </script>
    <script type="text/javascript" src="<?=base_url()?>js/jquery.tools.min.js"></script>
    <script type="text/javascript" src="<?=base_url()?>js/jquery.uniform.min.js"></script>
    <script type="text/javascript" src="<?=base_url()?>js/jquery.easing.js"></script>
    <script type="text/javascript" src="<?=base_url()?>js/jquery.ui.totop.js"></script>
    <!--[if lt IE 9]>
    <script type="text/javascript" src="js/PIE.js"></script>
    <script type="text/javascript" src="js/ie.js"></script>
    <![endif]-->

    <script type="text/javascript" src="<?=base_url()?>js/global.js"></script>
    <!-- MAIN JAVASCRIPTS END -->
</body>
</html>