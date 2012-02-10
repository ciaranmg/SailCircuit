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
		$this->userlib->force_login();
		$this->load->model('regatta_model');
		
		$regattas = $this->regatta_model->get_regattas($this->userlib->active_club());
		$data = array('ajax' => false, 'regattas' => $regattas);
		$this->load->view('regattas/index', $data);
	}
	
	function create(){
		$this->userlib->force_login();
		$this->userlib->force_permission('regatta_create');
		$this->load->model('regatta_model');
		$breadcrumb = $this->breadcrumb->get_path();
		$data = array(
						'regatta_parent' => $this->userlib->active_club(), 
						'title' => "Create Regatta", 
						'action' => 'regatta/create', 
						'ajax' => false,
						'breadcrumb'=> $breadcrumb);
		
		if($this->input->post('submit') && $this->input->post('action') == 'regatta/create'){
			if($this->form_validation->run('regatta') === false){
				$this->form_validation->set_error_delimiters('<div class="error"><span>&nbsp;</span>', '</div>');
				$this->load->view('regattas/regatta_form', $data);
			}else{
				// Save the regatta data
				
				//Double Check security first
				$this->userlib->force_permission('regatta_create', array('club_id' => $this->input->post('regatta_parent')));
				$this->regattaData['name'] = $this->input->post('regatta_name');
				$this->regattaData['start_date'] = strtotime($this->input->post('regatta_start_date'));
				$this->regattaData['end_date'] = strtotime($this->input->post('regatta_end_date'));
				$this->regattaData['description'] = $this->input->post('regatta_description');
				$this->regattaData['club_id'] = $this->input->post('regatta_parent');
				$this->regattaData['status'] = "active";
				$regatta_id = $this->regatta_model->insert($this->regattaData);
			
				$this->session->set_flashdata('message', 'Owner Successfully Created');
			
				redirect('regatta/show/'.$regatta_id);
			}
		}else{
			$this->load->view('regattas/regatta_form', $data);
		}
	}
	
	function view($id=null){
		$this->userlib->force_login();
		if(!$id) show_404('regatta/view/noid');
		
		$this->userlib->force_permission('regatta_view');
		
		$this->load->model('regatta_model');		
		$this->load->model('class_model');
		
		$regatta = $this->regatta_model->get($id);
		if(!$regatta) show_404('regatta/view/invalidid');
		
		$classes = $this->class_model->get_classes($id);
		$breadcrumb = $this->breadcrumb->get_path();
	
		$data = array('regatta' => $regatta, 'classes' => $classes, 'regatta_id' => $id, 'breadcrumb' => $breadcrumb);
		if(!is_ajax()) $this->load->view('common/header');
		$this->load->view('regattas/view_regatta', $data);
		if(!is_ajax()) $this->load->view('common/footer');

	}
	
	function edit($field, $type, $id){
		$this->load->model('regatta_model');
		if($this->userlib->check_permission('regatta_edit')){
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
					return "Error: Fields do not match";
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
}

?>