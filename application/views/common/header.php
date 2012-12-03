<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><? if(isset($headline)) echo $headline; ?> SailCircut</title>
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
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
  </head>

  <body class="<?=$this->uri->segment(1);?>">
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="<?=base_url()?>">SailCircuit</a>
          <div class="nav-collapse">
            <ul class="nav">
                <li <? if($this->uri->segment(1) =='') echo 'class="active"';?>><a href="<?=base_url()?>">Home</a></li>
                <li class="dropdown <? if($this->uri->segment(1) =='regatta') echo 'active';?>">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Regattas <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="<?=base_url('regatta/list_all');?>">View Regattas</a></a>
                        </li>
                        <li>
                            <a href="<?=base_url('regatta/create');?>">Create Regatta</a></a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown <? if($this->uri->segment(1) =='boats') echo 'active';?>">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Boats <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="<?=base_url('boats');?>">List Boats</a>
                        </li>
                        <li>
                            <a href="<?=base_url('boats/create');?>">Add Boat</a>
                        </li>
                    </ul>
                </li>
               <? /* <li <? if($this->uri->segment(1) =='rules') echo 'class="active"';?>><a href="<?=base_url('rules');?>">Rules</a></li>  */ ?>
            </ul>
            <ul class="nav pull-right">
                <li>
                    <div class="btn-group">
                        <a class="btn btn-primary" href="<?=base_url('/race/input');?>"><i class="icon-plus icon-white"></i> Input Race Results</a>
                    </div>
                </li>
                <li>
                    <div class="btn-group">
                        <a href="<?=base_url('user/profile')?>" class="btn btn-inverse" title="<?=$this->session->userdata('name');?>"><i class="icon-user icon-white"></i> Welcome <?=$this->session->userdata('name');?></a>
                        <a href="#" data-toggle="dropdown" class="btn btn-inverse dropdown-toggle"><span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="<?=base_url()?>user/profile"><i class="icon-pencil"></i> Edit User Profile</a>
                            </li>
                            <li>
                                <a href="<?=base_url()?>club/view"><i class="icon-star"></i> <?=$this->session->userdata('club_name')?></a>
                            <!-- <li>
                                <a href="<?=base_url()?>customer/support"><i class="icon-info-sign"></i> Customer Support</a>
                            </li> -->
                            <li class="divider"></li>
                            <li>
                                <a href="<?=base_url()?>user/logout"><i class="icon-off"></i> Log Out</a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
    <div class="container wrapper">
        <div class="ribbon-wrapper-green hidden-phone hidden-tablet"><div class="ribbon-green">Beta</div></div>
        <div class="row">
            <div class="span12">
                <? $this->load->view('common/breadcrumb');?>
            </div>
        </div>
        <? $this->load->view('common/messages'); ?> 
