                	</div>
                </section>
                <footer class="clearfix">
                    <div class="container_12">
                        <div class="grid_12">
                            Copyright <?=date('Y');?> SailCircuit
                        </div>
                    </div>
                </footer>
            </section>

            <!-- Main Section End -->
        </section>
    </div>
    
    <!-- MAIN JAVASCRIPTS -->
    <script src="//code.jquery.com/jquery-1.7.min.js"></script>
    <script>window.jQuery || document.write("<script src='<?=base_url()?>js/jquery.min.js'>\x3C/script>")</script>
    <script type="text/javascript" src="<?=base_url()?>js/jquery.tools.min.js"></script>
    <script type="text/javascript" src="<?=base_url()?>js/jquery.uniform.min.js"></script>
    <script type="text/javascript" src="<?=base_url()?>js/jquery.easing.js"></script>
    <script type="text/javascript" src="<?=base_url()?>js/jquery.ui.totop.js"></script>
    <script type="text/javascript" src="<?=base_url()?>js/jquery.itextsuggest.js"></script>
    <script type="text/javascript" src="<?=base_url()?>js/jquery.itextclear.js"></script>
    <script type="text/javascript" src="<?=base_url()?>js/jquery.hashchange.min.js"></script>
    <script type="text/javascript" src="<?=base_url()?>js/jquery.drilldownmenu.js"></script>
    <script type="text/javascript" src="<?=base_url()?>js/jquery.popover.js"></script>
    <script type="text/javascript" src="<?=base_url()?>lib/datatables/js/jquery.dataTables.min.js"></script>
    <!--[if lt IE 9]>
    <script type="text/javascript" src="js/PIE.js"></script>
    <script type="text/javascript" src="js/ie.js"></script>
    <![endif]-->

    <script type="text/javascript" src="<?=base_url()?>js/global.js"></script>
    <script type="text/javascript" src="<?=base_url()?>js/main.js"></script>
    <!-- MAIN JAVASCRIPTS END -->

    <!-- LOADING SCRIPT -->
    <script>
    $(window).load(function(){
        $("#loading").fadeOut(function(){
            $(this).remove();
            $('body').removeAttr('style');
        });
    });
    </script>
    <!-- LOADING SCRIPT -->
    
    <!-- POPOVERS SETUP-->
    <div id="notifications-popover" class="popover">
        <header>
            Notifications
        </header>
        <section>
            <div class="content">
                <nav>
                    <ul>
                        <li class="new"><a><span class="avatar"></span>John Doe created a new project</a></li>
                        <li class="new"><a><span class="avatar"></span>John Doe created a new project</a></li>
                        <li class="new"><a><span class="avatar"></span>Jane Doe updated a project</a></li>
                        <li class="read"><a><span class="avatar"></span>John Doe uploaded a document</a></li>
                        <li class="read"><a><span class="avatar"></span>John Doe deleted a project</a></li>
                        <li class="read"><a><span class="avatar"></span>John Doe marked a project as done</a></li>
                        <li><a href="#notifications.html" title="Notifications">See notification styles and growl like messages...</a></li>
                    </ul>
                </nav>
            </div>
        </section>
    </div>
        <script>
        $(document).ready(function() {
            $('#activity-button').popover('#activity-popover', {preventRight: true});
            $('#notifications-button').popover('#notifications-popover', {preventRight: true});
            $('#settings-button').popover('#settings-popover', {preventRight: true});

            /**
             * setup search
             */
            function googleSearch(q){
                $('#searchform .searchbox a').fadeOut()
                $.ajax({
                    url: 'php/google_search_results.php',
                    data: 'q='+encodeURIComponent(q),
                    cache: false,
                    success: function(response){
                        $('.search_results').html(response);
                    }
                });
            }

            // Set iTextSuggest
            $('#searchform .searchbox').length && $('#searchform .searchbox').find('input[type=text]').iTextClear().iTextSuggest({
                url: 'php/google_suggestions_results.php',
                onKeydown: function(query){
                    googleSearch(query);
                },
                onChange: function(query){
                    googleSearch(query);
                },
                onSelect: function(query){
                    googleSearch(query);
                },
                onSubmit: function(query){
                    googleSearch(query);
                },
                onEmpty: function(){
                    $('.search_results').html('');
                }
            }).focus(function(){
                $('#wrapper > section > aside > nav > ul').fadeOut(function(){
                    $('#searchform .search_results').show();
                });
                $(this).parents('#searchform .searchbox').animate({marginRight: 70}).next().fadeIn();
            });
            
            $('#searchform .searchcontainer').find('input[type=button]').click(function(){
                $('#searchform .search_results').hide();
                $('#searchform .searchbox').find('input[type=text]').val('');
                $('#searchform .search_results').html('');
                $('#wrapper > section > aside > nav > ul').fadeIn();
                $('.searchbox', $(this).parent()).animate({marginRight: 0}).next().fadeOut();
            });
        });
    </script>
    <!-- POPOVERS SETUP END-->

</body>
</html>