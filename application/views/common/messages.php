    <? if($this->session->flashdata('message') OR $this->session->flashdata('err_message') OR isset($message) OR isset($err_message)): ?>
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
                    if(isset($message)){
                        print '<div class="alert fade in">
                                    <button class="close" data-dismiss="alert">×</button>';
                        print $message;
                        print '</div>';
                    }
                    if(isset($err_message)){
                        print '<div class="alert alert-error fade in">
                                    <button class="close" data-dismiss="alert">×</button>';
                        print $err_message;
                        print '</div>';
                    }
                ?>
            </div>
        </div>
    <? endif;?>