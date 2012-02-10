<?
class Home extends CI_Controller {

	public function index()
	{
		if(!is_ajax()) $this->load->view('common/header');
		
		
		
 		if(!is_ajax()) $this->load->view('common/footer');
	}
	
	public function dashboard(){
		$this->userlib->force_login();
		$this->load->model('regatta_model');
		$data['regattas'] = $this->regatta_model->get_regattas($this->userlib->active_club());
		if(!is_ajax()) $this->load->view('common/header');
		
		$this->load->view('home', $data);
		
 		if(!is_ajax()) $this->load->view('common/footer');		
	}
	
}
?>