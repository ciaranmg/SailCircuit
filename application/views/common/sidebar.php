        <section>
            <!-- Sidebar -->

            <aside>
                <nav class="drilldownMenu">
                    <h1>
                        <span class="title">Main Menu</span>
                        <button title="Go Back" class="back">Back</button>
                    </h1>
                    <div class="clearfix" id="searchform">
                        <div class="searchcontainer">
                            <div class="searchbox" onclick="$(this).find('input').focus();">
                                <input type="text" name="q" id="q" autocomplete="off" placeholder="Search...">
                            </div>
                            <input type="button" value="Cancel" />
                        </div>
                        <div class="search_results"></div>
                    </div>                        
                    <ul class="tlm">
                    	<li class="current">
                        	<a href="#home/dashboard" title="Dashboard">
                        		<img src="<?=base_url()?>images/navicons/81.png" alt=""/>
                        		<span>Dashboard</span>
                        	</a>
                        </li>
                        <li class="hasul">
                        	<a href="#regatta/index" title="Regattas">
                        		<img src="<?=base_url()?>images/navicons/85.png" alt="Show Regattas"/>
                        		<span>Regattas</span>
                        	</a>
                        	<ul>
                        		<li>
                        			<a href="#regatta/create" title="Create New Regatta">
                        				<span>Create Regatta</span>
                        			</a>
                        		</li>
                        	</ul>
                        </li>
                        <li class="hasul">
                        	<a href="#" title="Boats">
                        		<img src="<?=base_url()?>images/navicons/58.png" alt=""/>
                        		<span>Boats</span>
                        	</a>
                        	<ul>
                        		<li>
                        			<a href="#boat/list_boats" title="List Boats">
                        				<span>List Boats</span>
                        			</a>
                        		</li>
                        		<li>
                        			<a href="#boat/create" title="Add New Boat">
                        				<span>Add New</span>
                        			</a>
                        		</li>
                        	</ul>
                        </li>
						<li>
                        	<a href="#user/list" title="People">
		                        <img src="<?=base_url()?>images/navicons/112.png" alt="People"/>
		                        <span>People</span>
		                    </a>
		                </li>
                        <li>
                        	<a href="#user/profile" title="Profile">
		                        <img src="<?=base_url()?>images/navicons/111.png" alt=""/>
		                        <span>Profile</span>
		                    </a>
		                </li>
                    </ul>
                </nav>
            </aside>

            <!-- Sidebar End -->