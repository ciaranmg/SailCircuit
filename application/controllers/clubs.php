<?
class Clubs extends CI_Controller{
	var $cache = false;
	function index(){
		redirect(base_url('/'));
	}

	/*
$this->path[] = array(
									'title' => 'List Regattas',
									'ci_url' => 'regatta/list',
									'url' => 'regatta/list',
									'current' => true
								);
	*/

	// View Club and all its regattas
	function view($club_name, $club_id, $offset = null){
		if($this->cache) $this->output->cache(60);
		$club_name = 'whsc';
		
		$this->load->model('club_model');
		if(!$club_id) show_404('Club Not Found');
		$club = $this->club_model->get($club_id);
		$breadcrumb = array(array('title' => $club->name, 'url' => 'clubs/view/' . $club_name .'/' .$club_id, 'current' => true));
		$this->load->library('pagination');
		$config['base_url'] = base_url('clubs/view/'.$club_name .'/' . $club_id);
		$config['total_rows'] = $this->regatta_model->num_rows($club_id);
		$config['per_page'] = 20; 
		$config['uri_segment'] = 5;

		$this->pagination->initialize($config);
		
		$regattas = $this->regatta_model->get_regattas($club_id, null, $config['per_page'], $offset);

		$data = array('breadcrumb' => $breadcrumb, 'club'=> $club, 'title' => $club->name, 'intro'=> $club->description, 'regattas' => $regattas);

		$this->load->view('public/view_club', $data);

	}

	// View a regatta and all its classes
	function view_series($club_name, $club_id, $regatta_id){
		if($this->cache) $this->output->cache(60);
		
		
		$this->load->model('club_model');


		$club = $this->club_model->get($club_id);
		$regatta = $this->regatta_model->get($regatta_id);
		$classes = $this->classes_model->get_classes($regatta_id);
		$breadcrumb = array(array('title' => $club->name, 'url' => 'clubs/view/' . $club_name .'/' .$club_id, 'current' => false),
							array('title' => $regatta->name, 'url' =>'clubs/view_series/'. $club_name . '/' . $club_id .'/'.$regatta->id, 'current' => true));

		$data = array('breadcrumb' => $breadcrumb, 'club' => $club, 'title' => $regatta->name, 'intro' => $regatta->description, 'regatta' => $regatta, 'classes' => $classes);
		$this->load->view('public/view_regatta', $data);
	}

	// View a class and all its races
	function view_class($club_name, $club_id, $class_id){
		if($this->cache) $this->output->cache(60);
		
		
		$this->load->model('club_model');
		

		$races = $this->race_model->get_races($class_id);
		$club = $this->club_model->get($club_id);
		$class = $this->classes_model->get($class_id);
		$regatta = $this->regatta_model->get($class->regatta_id);
		
		$points_table = $this->race_model->get_points_table($class_id);
		$breadcrumb = array(array('title' => $club->name, 'url' => 'clubs/view/' . $club_name .'/' .$club_id, 'current' => false),
							array('title' => $regatta->name, 'url' =>'clubs/view_series/'. $club_name . '/' . $club_id .'/'.$regatta->id, 'current' => false),
							array('title' => $class->name, 'url'=> 'clubs/view_class/'. $club_name . '/' .$club_id .'/'.$class->id, 'current' => true));

		$data = array('breadcrumb'=> $breadcrumb, 'title' => $class->name, 'intro' => $class->description, 'class'=> $class, 'regatta' => $regatta, 'club'=> $club, 'points_table' => $points_table, 'races' => $races);
		$this->load->view('public/view_class', $data);
	}

	// View a race and it's results
	function view_race($club_name, $club_id, $race_id){
		if($this->cache) $this->output->cache(60);
		$this->load->model('club_model');
		$race_results = $this->race_model->get_readable_results($race_id);
		$race = $this->race_model->get($race_id);
		$class = $this->classes_model->get($race->class_id);
		$regatta = $this->regatta_model->get($class->regatta_id);
		$club = $this->club_model->get($club_id);
$this->firephp->log($race_results);		
		$breadcrumb = array(array('title' => $club->name, 'url' => 'clubs/view/' . $club_name .'/' .$club_id, 'current' => false),
							array('title' => $regatta->name, 'url' =>'clubs/view_series/'. $club_name . '/' . $club_id .'/'.$regatta->id, 'current' => false),
							array('title' => $class->name, 'url'=> 'clubs/view_class/'. $club_name . '/' .$club_id .'/'.$class->id, 'current' => false),
							array('title' => $race->name, 'url' => 'clubs/view_race/'.$club_name .'/'.$club_id . '/' .$race->id, 'current'=> true));

		$data = array('title' => $race->name, 
						'breadcrumb' => $breadcrumb,
						'intro' => sc_date_format($race->start_date) . ' ' . sc_time_format($race->start_date), 
						'regatta' => $regatta, 
						'class' => $class, 
						'results' => $race_results, 
						'race' => $race);
		$this->load->view('public/view_race', $data);
	}

}
?>