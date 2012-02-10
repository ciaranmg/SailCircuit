<? $this->load->view('common/html_head');?>
<body style="overflow: hidden;">
    <div id="loading"> 

        <script type = "text/javascript"> 
            document.write("<div id='loading-container'><p id='loading-content'>" +
                           "<img id='loading-graphic' width='16' height='16' src='<?=base_url()?>images/ajax-loader-abc4ff.gif' /> " +
                           "Loading...</p></div>");
        </script> 

    </div> 

    <div id="wrapper">
        <header>
            <h1><a href="<?=base_url()?>">SailCircuit</a></h1>
            <nav>
                <div class="container_12">
                    <div class="grid_12">
                        <ul class="toolbar clearfix fl">
                            <li>
                                <a href="<?=base_url()?>" title="Notifications" class="icon-only" id="notifications-button">
                                    <img src="<?=base_url()?>images/navicons-small/08.png" alt=""/>
                                    <span class="message-count">3</span>
                                </a>
                            </li>
                            <li>
                                <a href="#user/profile" title="<?=$this->session->userdata('name')?>" class="icon-only" id="settings-button">
                                    <img src="<?=base_url()?>images/navicons-small/19.png" alt="Settings"/>
                                </a>
                            </li>
                            <li>
                            	<div class="selector" id="uniform-undefined">
        	                    		<span><?=$this->session->userdata('club_name')?></span>
    	                        	<select style="opacity: 0; ">
	                            		<? // Todo: Make the session variable change when this menu is used.
	                            		$clubs = $this->userlib->get_clubs();
	                            		 foreach($clubs as $club): ?>
	                            			<option value="<?=$club->club_id?>"><?=$club->club_name?></option>
	                            		<? endforeach; ?>
                            		</select>
                            	</div>
                            </li>
                        </ul>
                        <a href="<?=base_url('user/logout')?>" title="Logout" class="button icon-with-text fr">
                        	<img src="<?=base_url()?>images/navicons-small/129.png" alt=""/>Logout
                        </a>
						<? if($this->userlib->activeuser()): ?>
							<div class="user-info fr">
								Logged in as  <?=anchor('#user/profile', $this->session->userdata('name'), array('title'=> $this->session->userdata('name')));?>
							</div>
						<? endif;?>
                    </div>
                </div>
            </nav>
        </header>
			<? $this->load->view('common/sidebar'); ?>
			
		
		<section>
			<header>
				<div class="container_12 clearfix">
					<a href="#menu" class="showmenu button">Menu</a>
					<h1 class="grid_12">Dashboard</h1>
				</div>
			</header>
			<section id="main-content" class="clearfix">
			<div class="container_12 clearfix leading">
         <?
			if($this->session->flashdata('message')){
				print '<section class="grid_12">
							<div class="message success closeable"><span class="message-close"></span><h3>';
				print $this->session->flashdata('message');
				print '</h3>
						</div>
						</section>';
			}
			if($this->session->flashdata('err_message')){
				print '<section class="grid_12"><div class="message error"><h3>';
				print $this->session->flashdata('err_message');
				print '</h3></div></section>';
			}
		?>
		