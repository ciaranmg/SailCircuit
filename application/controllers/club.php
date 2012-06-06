<?
class Club extends CI_Controller {

	private $clubData = array(
						'club_name' => '',
						'description' => '',
						'location' => '',
						'valid' => false,
						'logo' => ''
						); 
						
	function index() {
		
		$this->load->model('club_model');
		$user_clubs = $this->userlib->user_clubs();
		// $this->firephp->log($user_clubs);
		$this->load->view('common/header');
		$this->load->view('clubs/home', array('user_clubs' => $user_clubs));
		$this->load->view('common/footer');
	}
	
	
	function dashboard(){
	// Function to load the users club(s) dashboard
	$this->userlib->force_login();
	$this->load->model('regatta_model');
	if(!$this->session->userdata('club_id')){
		$user_clubs = $this->user_model->get_user_clubs($this->userlib->activeuser());
		$this->userlib->set_club($user_clubs[0]['club_id']);
	}
	$regattas = $this->regatta_model->get_regatta_list();
	
	$this->firephp->log($regattas);
	$data = array('regattas' => $regattas);
	
	$this->load->view('clubs/dashboard', $data);
	}
	
	// Method to create a new club and by default add the creating user as an admin
	function create() {
		$this->firephp->log('create');
		$this->load->view('common/header');
		$this->load->library('Form_validation');
		$this->load->model('club_model');
		
		if($this->input->post('action') == 'club/create'){
			$this->firephp->log('action - create');
			if($this->form_validation->run('club')===false){
				$this->firephp->log('form invalid');
				$this->load->view('clubs/form');
			}else{
				$this->firephp->log('form valid');
				$this->clubData['valid']= true;
				$this->clubData['club_name']= $this->input->post('club_name');
				$this->clubData['description'] = $this->input->post('description');
				$result = $this->club_model->create($this->clubData);
				if($result != false){
					$this->session->set_flashdata('message', 'Club Created');
					$this->club_model->link_user_club($this->session->userdata('id'), $result, 'admin');
				}else{
					$this->session->set_flashdata('err_message', 'There was a problem saving the data');
				}
				$this->load->view('clubs/home');
			}
		}else{
			$this->load->view('clubs/club_form');
		}
		
		
		$this->load->view('common/footer');
	} 

	
}
?>