<?
class Boats extends CI_Controller {

	private $boatData = array(
			'name' => '',
			'make' => '',
			'model' => '',
			'length' => 0.0,
			'main_class' => ''
		);
			
	function index(){
		$this->userlib->force_login();
		$this->load->model('boats_model');

		$boats = $this->boats_model->get_boats(array('club_id' => $this->session->userdata('club_id')));
		$data = array(
						'boats' => $boats,
						'breadcrumb' => $this->breadcrumb->get_path(),
						'title' => 'List Boats',
						'intro' => 'All Boats in ' . $this->session->userdata('club_name')
						);
		// $this->firephp->log($data);
		$this->load->view('boats/list_boats', $data);	
	}
	
	function create() {	
		$this->userlib->force_login();
		$this->userlib->force_permission('boats_create', array('club_id' => $this->session->userdata('club_id')));

		$form = array(
				'action' => 'boats/create/' . $this->session->userdata('club_id'),
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
						'label' => 'Length (LOA)',
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
						)
				)
			);
		$data['form'] = $form;
		$data['breadcrumb'] = $this->breadcrumb->get_path();
		$data['title'] = 'Create Boat';

		if($this->input->post('submit') && $this->input->post('action') == 'boats/create'){
				
			if($this->form_validation->run() === false ){
				$this->form_validation->set_error_delimiters('<p>', '</p>');
				for($i = 0; $i < sizeof($form['fields']); $i++){
					if($form['fields'][$i]['type'] == 'dropdown'){
						$form['fields'][$i]['selected'] = set_value($form['fields'][$i]['name']);
					}else{
						$form['fields'][$i]['value'] = set_value($form['fields'][$i]['name']);
					}
				}
				$data['form'] = $form;
				$this->load->view('boats/create', $data);

			}else{
				// Double check security
				$this->userlib->force_permission('boats_create', array('club_id' => $this->input->post('parent')));
				
				foreach($form['fields'] as $field){
					$this->boatData[$field['name']] = $this->input->post($field['name']);
				}
				$boat_id = $this->boats_model->insert($boatData, $this->input->post('parent'));
				$this->session->set_flashdata('message', 'Boat Successfully Created. <a href="'. base_url('boats/create') . '">Create another</a>');
				redirect(base_url('boats/view') . '/' . $boat_id);
			}
		}else{
			$this->load->view('boats/boat_form', $data);
		}
	}
	
	
	function view($id=null){
		$this->load->model('boats_model');
		$this->load->model('owner_model');
		$this->load->model('handicap_model');

		// First up force a login
		$this->userlib->force_login();
		
		// Then check if the boat actually exists
		$boat = $this->boats_model->get($id);
		if($boat) {
			// Then make sure the user can view the boat in question
			$this->userlib->force_permission('boats_view', array('boat_id' => $id));

			$owner_ids = $this->boats_model->get_boat_owners($id);
			// $this->firephp->log($owner_ids);
			
			if($owner_ids){
				$owners = $this->owner_model->get_owners($owner_ids);
				$data['owners'] = $owners;
			}
					
			// Todo: 	Get list of races
			// 			Get list of classes
			
			//			AJAX Form for adding owners


			$all_handicaps = $this->handicap_model->get_handicaps();
			$i = 0;
			foreach ($all_handicaps as $h) {
				if($value = $this->boats_model->get_boat_meta($id, $h->name)){
					$handicaps[$i] = new stdClass;
					$handicaps[$i]->name = $h->name;
					$handicaps[$i]->value = $value;
					$i++;
				}
			}
			if(isset($handicaps)) $data['handicaps'] = $handicaps;
			$data['breadcrumb'] = $this->breadcrumb->get_path();	
			$data['title'] = $boat->name;
			$data['boat'] = $boat;
			// $this->firephp->log($data);
			$this->load->view('boats/view_boat', $data);
		}else{
			show_404('boats/view/$id');
		}	
		
		
	}

	function add_handicaps($id){
		if(!is_ajax()) show_404('boats/add_handicap/$id');
		$this->load->model('handicap_model');
		
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
					$this->firephp->log('true');
					// Save the form data
					$this->boats_model->save_boat_meta($id, $this->input->post('system_name'), $this->input->post('handicap_value'));
					// Get handicap data to populate the table
					$i = 0;
					foreach ($hcaps as $h) {
						if($value = $this->boats_model->get_boat_meta($id, $h->name)){
							$handicaps[$i] = new stdClass;
							$handicaps[$i]->name = $h->name;
							$handicaps[$i]->value = $value;
							$i++;
						}
					}
					$data['handicaps'] = $handicaps;
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