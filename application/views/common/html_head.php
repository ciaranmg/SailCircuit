<!DOCTYPE html>
<!--[if IE 7 ]>   <html lang="en" class="ie7 lte8"> <![endif]--> 
<!--[if IE 8 ]>   <html lang="en" class="ie8 lte8"> <![endif]--> 
<!--[if IE 9 ]>   <html lang="en" class="ie9"> <![endif]--> 
<!--[if gt IE 9]> <html lang="en"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<head><!--[if lte IE 9 ]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->

<!-- iPad Settings -->
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" /> 
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<!-- Adding "maximum-scale=1" fixes the Mobile Safari auto-zoom bug: http://filamentgroup.com/examples/iosScaleBug/ -->
<!-- iPad Settings End -->

<title>SailCircut - Racing results program</title>

<link rel="shortcut icon" href="favicon.ico">

<!-- iOS ICONS -->
<link rel="apple-touch-icon" href="touch-icon-iphone.png" />
<link rel="apple-touch-icon" sizes="72x72" href="touch-icon-ipad.png" />
<link rel="apple-touch-icon" sizes="114x114" href="touch-icon-iphone4.png" />
<link rel="apple-touch-startup-image" href="touch-startup-image.png">
<!-- iOS ICONS END -->

<!-- STYLESHEETS -->

<link rel="stylesheet" href="<?=base_url()?>css/reset.css" media="screen" />
<link rel="stylesheet" href="<?=base_url()?>css/grids.css" media="screen" />
<link rel="stylesheet" href="<?=base_url()?>css/ui.css" media="screen" />
<link rel="stylesheet" href="<?=base_url()?>css/forms.css" media="screen" />
<link rel="stylesheet" href="<?=base_url()?>css/device/general.css" media="screen" />
<!--[if !IE]><!-->
<link rel="stylesheet" href="<?=base_url()?>css/device/tablet.css" media="only screen and (min-width: 768px) and (max-width: 991px)" />
<link rel="stylesheet" href="<?=base_url()?>css/device/mobile.css" media="only screen and (max-width: 767px)" />
<link rel="stylesheet" href="<?=base_url()?>css/device/wide-mobile.css" media="only screen and (min-width: 480px) and (max-width: 767px)" />
<!--<![endif]-->
<link rel="stylesheet" href="<?=base_url()?>css/jquery.uniform.css" media="screen" />
<link rel="stylesheet" href="<?=base_url()?>css/jquery.popover.css" media="screen">
<link rel="stylesheet" href="<?=base_url()?>css/jquery.itextsuggest.css" media="screen">
<link rel="stylesheet" href="<?=base_url()?>css/themes/lightblue/style.css" media="screen" />
<link rel="stylesheet" href="<?=base_url()?>lib/datatables/css/vpad.css" media="screen" />


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
<script type="text/javascript" src="<?=base_url()?>js/selectivizr.js"></script>
<![endif]-->

</head>