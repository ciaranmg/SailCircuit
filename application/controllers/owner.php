<?
class Owner extends CI_Controller{
	
	var $ownerData = array();
	
	function index(){
		$this->userlib->force_login();

		$this->load->view('owners/index');
	}

    function create($boat_id)
    {
        if (!is_ajax()) show_404("owner/create/$boat_id");


        if ($this->userlib->check_permission('boats_edit', array('boat_id' => $boat_id))) {

            $data['boat_id'] = $boat_id;

            if ($this->input->post('submit')) {
                // Form has been submitted, validate and save
                if ($this->form_validation->run('owner/create') === false) {
                    // form is not validated.
                    $this->firephp->log(validation_errors());

                    $this->form_validation->set_error_delimiters('<p>', '</p>');
                    $this->load->view('owners/owner_form', $data);
                } else {
                    // Save the form data
                    $form_data['name'] = $this->input->post('name');
                    $form_data['email'] = $this->input->post('email');
                    $form_data['phone'] = $this->input->post('phone');


                    if ($owner_id = $this->owner_model->insert($form_data))
                        $this->boats_model->set_boat_owner($boat_id, $owner_id);

                    $owners = $this->boats_model->get_owners($boat_id);

                    if ($owners !== false) {
                        $data['owners'] = $owners;
                        $this->load->view('owners/list_owners', $data);
                    }
                }
            } else {
                // Form has not been submitted
                $this->load->view('owners/owner_form', $data);
            }
        } else {
            echo '<div class="alert alert-error">You do not have permission to edit this resource</div>';
            error_log('User' . $this->session->userdata('user_id') . 'Tried to add owner to boat_id' . $id);
        }
    }
	
	function show($id, $ajax=null){
		
		$owner = $this->owner_model->get($id);
		
		if($ajax == 'ajax') $ajax = true;
		$data = array(
						'ajax' =>$ajax,
						'owner' => $owner
						);
		$this->load->view('owners/show', $data);
	}	
}