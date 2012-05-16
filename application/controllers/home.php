<?
class Home extends CI_Controller {

	public function index()
	{
		$this->userlib->force_login();
		$this->load->model('regatta_model');
		$data['breadcrumb'] = $this->breadcrumb->get_path();
		$data['headline'] = $this->lang->line('dashboard_headline');
		$data['intro'] = $this->lang->line('dashboard_intro');
		$criteria = array('active' => true);
		$data['regattas'] = $this->regatta_model->get_regattas($this->userlib->active_club(), $criteria);
		$this->load->view('home', $data);
	}
}
?>