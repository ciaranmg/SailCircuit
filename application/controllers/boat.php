<?
class Boat extends CI_Controller {

	private $boatData = array();
						
	function index(){
		
		$this->load->model('boat_model');
		$boats = $this->boat_model->get_boats(array('club_id' => 2));
		$data = array('ajax' => false, 'boats' => $boats);
		// $this->firephp->log($data);
		$this->load->view('boats/list_boats', $data);	
	}
	
	function create() {	
		if($this->input->post('submit') && $this->input->post('action') == 'boat/create'){
			$this->firephp->log($_POST);	
			if($this->form_validation->run('boat') === false ){
				$this->form_validation->set_error_delimiters('<div class="error"><span>&nbsp;</span>', '</div>');
				$this->load->view('common/header');
				$this->load->view('boats/boat_form');
			}else{
				$this->boatData['name'] = $this->input->post('boat_name');
				$this->boatData['sail_number'] = $this->input->post('boat_sail_number');
				$this->boatData['make'] = $this->input->post('boat_make');
				$this->boatData['model'] = $this->input->post('boat_model');
				$this->boatData['length'] = $this->input->post('boat_length');		
				$this->load->model('boat_model');
				$this->boatData['id'] = $this->boat_model->insert($this->boatData);
				$this->boat_model->set_club_boat($this->userlib->active_club(), $this->boatData['id']);
				redirect('#boat/list_boats/', 'location');
			}
			$this->load->view('common/footer');
		}else{
			$this->load->view('boats/boat_form');
		}
	}
	
	function list_boats($ajax=null){
		$this->load->model('boat_model');
		
		$boats = $this->boat_model->get_boats(array('club_id'=> $this->userlib->active_club()));
		
		if($boats===false){
			$this->load->view('common/message', array('title' => 'None found', 'message' => 'There were no boats found'));
		}else{
			$data['boats'] = $boats;
			
			$this->load->view('boats/list_boats', $data);
		}
	}
	
	function show($id, $ajax = null){
		if($ajax == 'ajax') $data = array('ajax' => true);
		$this->load->model('boat_model');
		$this->load->model('owner_model');
		
		$owner_ids = $this->boat_model->get_boat_owners($id);
		$this->firephp->log($owner_ids);
		if($owner_ids){
			$owners = $this->owner_model->get_owners($owner_ids);
			$data['owners'] = $owners;
		}
		$boat = $this->boat_model->get($id);
		
		
		// Todo: 	Get list of races
		// 			Get list of classes
		//			Get list of handicaps
		//			AJAX Form for adding owners
			
		$data['boat'] = $boat;
		$this->firephp->log($data);
		$this->load->view('boats/view_boat', $data);
	}
}			
?>