<?
class Home extends CI_Controller {

	public function index()
	{
		$this->userlib->force_login();
		
		$data['breadcrumb'] = $this->breadcrumb->get_path();
		$data['headline'] = $this->lang->line('dashboard_headline');
		$data['intro'] = $this->lang->line('dashboard_intro');
		$criteria = array('active' => true);
		$data['regattas'] = $this->regatta_model->get_regattas($this->userlib->active_club(), $criteria);
		$data['recent_races'] = $this->regatta_model->get_recent_races($this->session->userdata('club_id'));
		$this->load->view('home', $data);
	}
}
?>