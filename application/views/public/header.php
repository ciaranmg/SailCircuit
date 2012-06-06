<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><? if(isset($title)) echo $title; ?> Results Powered By SailCircut</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?=$intro;?>">
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
    <link href="<?=base_url()?>css/public.css" rel="stylesheet">
    
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
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
  </head>
    <body>
        <section class="container-fluid">
                <div class="row-fluid">
                    <div class="span12">
                        <? $this->load->view('common/breadcrumb');?>
                    </div>
                </div>
                <div class="row-fluid">
                    <header class="span12">
                        <div class="page-header">
                            <h1><?=$title;?> <small><?=$intro;?></small></h1>
                        </div>
                    </header>
                </div>
            <div class="row-fluid">