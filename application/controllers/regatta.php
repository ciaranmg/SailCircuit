<?
class Regatta extends CI_Controller {

	private $regattaData = array(
								'name' => '',
								'start_date' => '',
								'end_date' => '',
								'description' => '',
								'club_id' => ''
							);
	function index(){
		redirect('/regatta/list_all', 'location', 301);
	}

	function list_all($page = null){
		$this->userlib->force_login();
		
		
		$this->load->library('pagination');
		
		$config['base_url'] = base_url('regatta/list_all');
		$config['total_rows'] = $this->regatta_model->num_rows($this->session->userdata('club_id'));
		$config['per_page'] = 50; 


		$this->pagination->initialize($config);
		
		$regattas = $this->regatta_model->get_regattas($this->userlib->active_club(), null, $config['per_page'], $page);
		$data = array('title' => 'All Regattas', 'intro'=> 'List of all regattas, both active and inactive', 'regattas' => $regattas, 'breadcrumb' => $this->breadcrumb->get_path());
		$this->load->view('regattas/index', $data);
	}
	


	function create(){
		$this->userlib->force_login();
		$this->userlib->force_permission('regatta_create');
		 
		$data = array(
						'regatta_parent' => $this->userlib->active_club(), 
						'title' => "Create Regatta",
						'breadcrumb'=> $this->breadcrumb->get_path());
		$form = array(
				'action' => 'regatta/create',
				'parent' => $this->session->userdata('club_id'),
				'submit' => 'submit',
				'button_label' => 'Create Regatta',
				'fields' => array(
					array(
						'name' => 'regatta_name',
						'type' => 'text',
						'label' => 'Name',
						'required' => true,
						'value' => ''),
					array(
						'name' => 'regatta_description',
						'type' => 'textarea',
						'label' => 'Description',
						'value' => ''),
					array(
						'name' => 'regatta_start_date',
						'type' => 'date',
						'label' => 'Start Date',
						'value' => ''),
					array(
						'name' => 'regatta_end_date',
						'type' => 'date',
						'label' => 'End Date',
						'value' => ''),
					)
			);
		if($this->input->post('submit') && $this->input->post('action') == 'regatta/create'){
			if($this->form_validation->run() === false){
				
				$this->form_validation->set_error_delimiters('<div class="alert alert-error"><button class="close" data-dismiss="alert">×</button>', '</div>');
				
				for($i = 0; $i < sizeof($form['fields']); $i++){
					$form['fields'][$i]['value'] = set_value($form['fields'][$i]['name']); 
				}
				$data['form'] = $form;
				$this->load->view('regattas/regatta_form', $data);
			}else{
				// Save the regatta data
				//Double Check security first
				$this->userlib->force_permission('regatta_create', array('club_id' => $this->input->post('parent')));
				$this->regattaData['name'] = $this->input->post('regatta_name');
				$this->regattaData['start_date'] = sc_strtotime($this->input->post('regatta_start_date'));
				$this->regattaData['end_date'] = sc_strtotime($this->input->post('regatta_end_date'));
				$this->regattaData['description'] = $this->input->post('regatta_description');
				$this->regattaData['club_id'] = $this->input->post('parent');
				$this->regattaData['status'] = "active";
				$regatta_id = $this->regatta_model->insert($this->regattaData);
			
				$this->session->set_flashdata('message', 'Regatta Successfully Created');
			
				redirect('regatta/view/'.$regatta_id);
			}
		}else{
			$data['form'] = $form;
			$this->load->view('regattas/regatta_form', $data);
		}
	}
 	
 	/**
 	 * Method to delete a regatta, all it's classes, and all their races.
 	 */
	function delete(){
		$this->userlib->force_login();
		if($this->input->post('submit') == 'submit' AND $this->input->post('confirm_delete') == 'form_submit') {
			$this->userlib->force_permission('regatta_delete', array('regatta_id' => $this->input->post('object_id')));
			
			$x = $this->regatta_model->delete(intval($this->input->post('object_id')));
			
			
			if($classes = $this->classes_model->get_classes($this->input->post('object_id'))){
				foreach($classes as $class){
					$this->classes_model->delete($class->id);

					if($races = $this->race_model->get_races($class->id)){
						foreach($races as $race){
							$this->race_model->delete($race->id);
						}
					}
				}
			}

			if($x===true){
				$this->session->set_flashdata('message', 'Regatta Deleted Successfully');
			}else{
				$this->session->set_flashdata('err_message', 'There was a problem deleting the regatta from the database');
			}
		}else{
			$this->session->set_flashdata('err_message', 'There was a problem deleting the regatta');
		}
			if($this->input->post('referrer')){
				redirect(base_url($this->input->post('referrer')));
			}else{
				redirect(base_url(''));
			}
	}
	
	function view($id=null){
		$this->userlib->force_login();
		
				
		
		
		$regatta = $this->regatta_model->get($id);
		if(!$regatta) show_404('regatta/view/invalidid');
		if(!$id) show_404('regatta/view/noid');
		
		// $this->firephp->log($this->session->userdata('club_id'));
		
		$this->userlib->force_permission('regatta_view', array('regatta_id' => $id));
		
		
		$regatta = $this->regatta_model->get($id);
		if(!$regatta) show_404('regatta/view/invalidid');
		
		$classes = $this->classes_model->get_classes($id);
		// $this->firephp->log($classes);
		$breadcrumb = $this->breadcrumb->get_path();
	
		$data = array('regatta' => $regatta, 'classes' => $classes, 'regatta_id' => $id, 'breadcrumb' => $breadcrumb);
		
		$this->load->view('regattas/view_regatta', $data);
	}
	
	function edit($field, $type, $id){
		$this->userlib->force_login();
		
		if($this->userlib->check_permission('regatta_edit', array('regatta_id' => $id))){
			if($this->input->post('submit')){
				//form has been submitted
				// Check that the fields line up with the controller and method
				if($this->input->post('controller') == 'regatta' && $this->input->post('id') == $id){
					$field = $this->input->post('field');
					$data = $this->input->post($field);
					$type = $this->input->post('type');
					$this->regatta_model->update_field($field, $data, $id, $type);
					$result = $this->regatta_model->get_field($field, $id);
					$this->load->view('data/'.$type, array('content' => $result->$field));
				}else{
					return $this->lang->line('error_mismatch_fields');
				}
			}else{
				//form has not ben submitted		
				$result = $this->regatta_model->get_field($field, $id);
				
				$data = array(
							'target'=> 'regatta/edit/'.$field.'/'.$type.'/'.$id,
							'field' => $field,
							'controller' => 'regatta',
							'id' => $id,
							'type' => $type,
							// Todo: Get value for this variable.
							'value' => $result->$field
							);
				$this->load->view('ajax_form/field_form', $data);
			}	
		}
	}


	public function date_compare($fromDate){
		if($fromDate <= $this->input->post('regatta_end_date')) {	
			return true;
		}else{
			$this->form_validation->set_message('date_compare', 'Start Date must be before End Date');
			return false;
		}
	}

	public function check_end_date($endDate){
		if(sc_strtotime($endDate) <= time()){
			$this->form_validation->set_message('check_end_date', "End Date can't be in the past");
			return false;
		}else{
			return true;
		}
	}
}

?>