    <? if($this->session->flashdata('message') OR $this->session->flashdata('err_message')): ?>
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
    <? endif;?>