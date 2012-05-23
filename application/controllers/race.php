<?
	class Race extends CI_Controller {
		public function index(){
			redirect(base_url('races/input'));
		}

		public function input($race_id = null){
			$this->load->model('race_model');
			$data['breadcrumb'] = $this->breadcrumb->get_path();

			$this->load->view('races/input', $data);
		}

		public function view($race_id){

		}

	}
	
	/* End of file races.php */
?>