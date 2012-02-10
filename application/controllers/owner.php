<?
class Owner extends CI_Controller{
	
	var $ownerData = array();
	
	function index(){
		$this->userlib->force_login();

		$this->load->view('owners/index');
	}
	
	function create($boat_id = null, $ajax = false){
		$this->userlib->force_login();
		$this->userlib->force_permission('owner/create', $this->userlib->current_club_id());
		$this->load->library('Form_validation');
		$this->load->helper('form');

		if($ajax == 'ajax') $ajax = true;
		// Start the data array
		$data = array(
						'action' => 'owner/create',
						'ajax' => $ajax,
					
					);
		if($boat_id) $data['boat_id'] = $boat_id;
		
		if($this->input->post('action') == 'owner/create'){
			if($this->form_validation->run('owner') === false ){
				$this->form_validation->set_error_delimiters('<div class="error"><span>&nbsp;</span>', '</div>');
				$this->load->view('owners/owner_form');
			}else{
				$this->ownerData['name'] = $this->input->post('name');
				$this->ownerData['email'] = $this->input->post('email');
				$this->ownerData['phone'] = $this->input->post('phone');
					
				$this->load->model('owner_model');
				$x = $this->owner_model->insert($this->ownerData);
				
				if($this->input->post('boat_id')){
					$this->load->model('boat_model');
					$this->boat_model->set_boat_owner($this->input->post('boat_id'), $x);
				}
				
				$this->session->set_flashdata('message', 'Owner Successfully Created');
								
				$destination = ($ajax==true) ? "owner/show/$x/ajax" : "owner/show/$x";
				redirect($destination);
			}
		}else{
			$this->load->view('owners/owner_form', $data);
		}
	}
	
	function show($id, $ajax=null){
		$this->load->model('owner_model');
		$owner = $this->owner_model->get($id);
		
		if($ajax == 'ajax') $ajax = true;
		$data = array(
						'ajax' =>$ajax,
						'owner' => $owner
						);
		$this->load->view('owners/show', $data);
	}	
}