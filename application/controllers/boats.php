<?
class Boats extends CI_Controller {

	private $boatData = array(
			'name' => '',
			'sail_number' => '',
			'make' => '',
			'model' => '',
			'length' => 0.0,
			'main_class' => '',
			'sub_class' => ''
		);
			
	function index(){
		redirect(base_url('/boats/list_all/'));
	}

	function set_filter($filter = null){
		if ($filter == null OR $filter == 'all') {
			$this->session->set_userdata('main_class', null);
		}else{
			$this->session->set_userdata('main_class', $filter);
		}
			redirect(base_url('/boats/list_all'));
	}

	function list_all($page = null){
		$this->userlib->force_login();
		
		$this->load->library('pagination');


		if($this->session->userdata('main_class')) $boat_args['main_class'] = $this->session->userdata('main_class');

		$config['base_url'] = base_url('boats/list_all/');
		$config['total_rows'] = $this->boats_model->num_rows($this->session->userdata('club_id'), (isset($boat_args['main_class']))? $boat_args['main_class'] : null);
		$config['per_page'] = $this->config->item('per_page');
		$this->pagination->initialize($config);

		$boat_args['club_id'] = $this->session->userdata('club_id');
		
		

		$boats = $this->boats_model->get_boats($boat_args, null, $config['per_page'], $page);
		$data = array(
						'boats' => $boats,
						'breadcrumb' => $this->breadcrumb->get_path(),
						'title' => 'List Boats',
						'intro' => 'All Boats in ' . $this->session->userdata('club_name'),
						'filter' => $this->session->userdata('main_class')
						);
		
		$this->load->view('boats/list_boats', $data);	
	}
	
	function create() {	
		$this->userlib->force_login();
		$this->userlib->force_permission('boats_create', array('club_id' => $this->session->userdata('club_id')));
		

		$form = array(
				'action' => 'boats/create',
				'parent' => $this->session->userdata('club_id'),
				'submit' => 'submit',
				'button_label' => 'Create Boat',
				'fields' => array(
					array(
						'name' => 'name',
						'type' => 'text',
						'label' => 'Name',
						'value' => '',
						'required' => true
						),
					array(
						'name' => 'sail_number',
						'type' => 'text',
						'label' => 'Sail Number',
						'value' => '',
						'required' => true
						),
					array(
						'name' => 'make',
						'type' => 'text',
						'label' => 'Builder',
						'value' => ''
						),
					array(
						'name'=> 'model',
						'type' => 'text',
						'label' => 'Model/Type',
						'value' => ''
						),
					array(
						'name' => 'length',
						'type' => 'text',
						'label' => 'Length in Meters (LOA)',
						'value' => '',
						'required' => true
						),
					array(
						'name' => 'main_class',
						'type' => 'dropdown',
						'label' => 'Type',
						'selected' => '0',
						'options' => array(
										'0' => 'Select One',
										'Keelboat' => 'Keelboat',
										'Dinghy' => 'Dinghy'
									)
						),
					array(
						'name' => 'sub_class',
						'type' => 'text',
						'label' => 'Class (e.g. Laser, J24 etc.)',
						'value' => ''
						)
				)
			);
		$data['form'] = $form;
		$data['breadcrumb'] = $this->breadcrumb->get_path();
		$data['title'] = 'Create Boat';

		if($this->input->post('submit') AND $this->input->post('action') == 'boats/create'){
			$this->firephp->log('Form Submitted');	
			if($this->form_validation->run() === false ){
				$this->firephp->log('Validation Failed');
				$this->form_validation->set_error_delimiters('<p>', '</p>');
				for($i = 0; $i < sizeof($form['fields']); $i++){
					if($form['fields'][$i]['type'] == 'dropdown'){
						$form['fields'][$i]['selected'] = set_value($form['fields'][$i]['name']);
					}else{
						$form['fields'][$i]['value'] = set_value($form['fields'][$i]['name']);
					}
				}
				$data['form'] = $form;
				$this->load->view('boats/boat_form', $data);

			}else{
				$this->firephp->log('Validation Passed');
				// Double check security
				$this->userlib->force_permission('boats_create', array('club_id' => $this->input->post('parent')));
				
				foreach($form['fields'] as $field){
					$this->boatData[$field['name']] = $this->input->post($field['name']);
				}
				$boat_id = $this->boats_model->insert($this->boatData, $this->input->post('parent'));
				$this->session->set_flashdata('message', 'Boat Successfully Created. <a href="'. base_url('boats/create') . '">Create another</a>');
				$this->firephp->log('Boat Inserted, Redirecting');
				redirect(base_url('boats/view') . '/' . $boat_id);
			}
		}else{
			$this->firephp->log('Form Not Submitted');	
			$this->load->view('boats/boat_form', $data);
		}
	}
	
	
	function view($id=null){
		
		
		

		// First up force a login
		$this->userlib->force_login();
		
		// Then check if the boat actually exists
		$boat = $this->boats_model->get($id);
		if($boat) {
			// Then make sure the user can view the boat in question
			$this->userlib->force_permission('boats_view', array('boat_id' => $id));

			$owner_ids = $this->boats_model->get_owners($id);

			
			if($owners = $this->boats_model->get_owners($id)){
				$data['owners'] = $owners;
			}
			$data['recent_races'] = $this->boats_model->get_boat_races($id);
			// 	Todo:		Get list of classes

			$handicaps = $this->handicap_model->get_boat_handicaps($id);

			if($handicaps) $data['handicaps'] = $handicaps;
			$data['breadcrumb'] = $this->breadcrumb->get_path();	
			$data['title'] = $boat->name;
			$data['boat'] = $boat;
			// $this->firephp->log($data);
			$this->load->view('boats/view_boat', $data);
		}else{
			show_404('boats/view/$id');
		}	
		
		
	}

	function ajax_list_boats($type = null){
		if(!is_ajax()) show_404('boats/ajax_list_boats');
		

		if($type == 'Dinghy' OR $type == 'Keelboat'){
			$boats = $this->boats_model->get_boats(array('club_id' => $this->session->userdata('club_id'), 'main_class' => $type), 'sail_number');
			
		}else{
			$boats = $this->boats_model->get_boats(array('club_id' => $this->session->userdata('club_id')), 'sail_number');
		}
		echo json_encode($boats);
	}

	function ajax_delete_handicap($id){
		
		

		if(!is_ajax()) show_404("boats/ajax_delete_handicap/$id");

		if($this->userlib->check_permission('boats_edit', array('boat_id'=>$id)) AND $this->input->post('submit')) {
			$this->boats_model->delete_boat_meta(array('id' => $this->input->post('object_id')));
			$data['handicaps'] = $this->handicap_model->get_boat_handicaps($id);
			$this->load->view('boats/tbl_handicaps', $data);
		}else{
			echo '<div class="alert alert-error">You do not have permission to edit this resource</div>';
			error_log('User' . $this->session->userdata('user_id') .'Tried to delete handicap from boat_id' .$id);
		}
	}

	function ajax_delete_owner($id){
		
		
		
		if(!is_ajax()) show_404("boats/ajax_delete_owner/$id");

		if($this->userlib->check_permission('boats_edit', array('boat_id'=> $id)) && $this->input->post('submit')){
			$this->owner_model->delete_owner($this->input->post('object_id'));
			$data['owners'] = $this->boats_model->get_owners($id);
			$data['boat_id'] = $id;
			$this->load->view('owners/list_owners', $data);
		}else{
			echo '<div class="alert alert-error">You do not have permission to edit this resource</div>';
			error_log('User' . $this->session->userdata('user_id') .'Tried to delete owner from boat_id' .$id);
		}
	}

	function add_handicaps($id){
		if(!is_ajax()) show_404("boats/add_handicap/$id");
		
		
		if($this->userlib->check_permission('boats_edit', array('boat_id' => $id))){

			$hcaps = $this->handicap_model->get_handicaps();

			$options[''] = 'Choose One';
			foreach($hcaps as $h){
				// Find out if the boat already has a handicap for this system. If it does it will return 0.00
				// Elements that are left will be available to select.
				if($this->handicap_model->get_boat_handicap($id, $h->name) == 0.00){
					$options[$h->name] = $h->name;
				}
			}
			$data['options'] = $options;
			$data['boat_id'] = $id;

			if($this->input->post('submit')){
				// Form has been submitted. Validate, and save.
				if($this->form_validation->run('handicap') === false ){
					$this->firephp->log(validation_errors());

					$this->form_validation->set_error_delimiters('<p>', '</p>');
					$this->load->view('boats/handicap_form', $data);
				}else{
					// Save the form data
					$this->boats_model->save_boat_meta($id, $this->input->post('system_name'), $this->input->post('handicap_value'));
					// Get handicap data to populate the table
					
					$data['handicaps'] = $this->handicap_model->get_boat_handicaps($id);
					$this->load->view('boats/tbl_handicaps', $data);
				}
			}else{
				// Form has not been submitted. Initialise and Display the form
				$this->load->view('boats/handicap_form', $data);
			}
		}else{
			// user does not have permission to perform this action. Return the content with an error message.

		}
	}
}			
?>