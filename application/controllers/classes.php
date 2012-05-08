<?

	class Classes extends CI_Controller{
		private $class = array(
									'name' =>'',
									'regatta_id' => 0, 
									'race_count' => 0,
									'rating_system_id'=>0,
									'description'=>'',
									'logo'=>'',
									'discards'=>0,
									'status' => '',
									'parent_id' => 0,
									'system_id' => 0,
									'tiebreak_system' => 0
									);
		function index(){
			
		}
		
		function view($id=null){
			$this->userlib->force_permission('class/view', array('class_id' => $id));
			
			$this->load->model('class_model');
			$this->load->model('race_model');
			$this->load->model('boat_model');
			
			$class = $this->class_model->get($id);
			if($class){
				$races = $this->race_model->get_races($id);
				if($races){ 
					$race_count = sizeof($races);
				}else{ 
					$race_count = 0;
				}
				$this->firephp->log($class);
				 if($race_count < $class->race_count){
					$races_to_create = $class->race_count - $race_count;
					$names = array_fill(0, $races_to_create, 'Race');
					$this->race_model->create_race_framework($names, $id);
				}
				$races = $this->race_model->get_races($id);
				$boats = $this->boat_model->get_boats(array('class_id'=>$id));
				$breadcrumb = $this->breadcrumb->get_path();
				$this->load->view('classes/view_class', array('class'=> $class, 'races' => $races, 'boats' => $boats, 'breadcrumb' => $breadcrumb));
			}else{
				$message = array('title' => 'Not Found', 'text' => 'There was no regatta class found with that ID');
				$this->load->view('common/notification', array('message'=>$message));
			}
		}
		
		function create($regatta_id){
			$this->userlib->force_login();
			$this->userlib->force_permission('classes_create');

			$this->load->model('handicap_model');
			$this->load->model('class_model');

// Build the form options
			$handicaps = $this->handicap_model->get_handicaps();

			$classRatingSystems = array('0' => 'Choose One');
			foreach($handicaps as $h){
				$classRatingSystems[$h->id] = $h->name;
			}

			$classTiebreakers = array('0' => 'Choose One');
			foreach($this->class_model->get_class_tiebreakers() as $tb){
				$classTiebreakers[$tb->id] = $tb->name;
			}

			$classScoringSystems = array('0' => 'Choose One');
			foreach($this->class_model->get_scoring_systems() as $ss){
				$classScoringSystems[$ss->id] = $ss->name;
				$this->firephp->log($ss);
			}

			//Todo: Get rating system, Tie breakers, scoring system etc.
			$data['classParent'] = $regatta_id;
			$data['classRatingSystems']= $classRatingSystems;
			$data['classTiebreakers'] = $classTiebreakers;
			$data['classTiebreaker'] = 0;
			$data['classScoringSystems'] = $classScoringSystems;
			$data['classScoringSystem'] = 0;
			$data['defaultRatingSystem'] = 0;
			$data['breadcrumb'] = $this->breadcrumb->get_path();

			// Check if Form Has been submitted
			if($this->input->post('submit') && $this->input->post('action') == 'classes/create'){
				//Check to see if the submitted form passes validation
				if($this->form_validation->run('class') === false){
					$this->form_validation->set_error_delimiters('<div class="error"><span>&nbsp;</span>', '</div>');
					$data['classTiebreaker'] = $this->input->post('class_tiebreak_system');
					$data['classScoringSystem'] = $this->input->post('class_scoring_system');
					$dta['defaultRatingSystem'] = $this->input->post('class_rating_system');
					$this->load->view('class/class_form', $data);
				//Else display the form again with error messages
				}else{
					//Double Check security first
					$this->userlib->force_permission('classes_create', array('club_id' => $this->input->post('parent')));
					$this->class['name'] = $this->input-post('class_name');
					$this->class['regatta_id'] = $this->input-post('parent');
					$this->class['race_count'] = $this->input-post('class_races');
					$this->class['rating_system_id'] = $this->input-post('class_rating_system');
					$this->class['description'] = $this->input-post('class_description');
					$this->class['discards'] = $this->input-post('class_discards');
					$this->class['status'] = ''; // Status is not used yet.
					$this->class['system_id'] = $this->input-post('class_scoring_system');
					$this->class['tiebreak_system'] = $this->input->post('class_tiebreak_system');

					$class_id = $this->class_model->insert($this->class);
					$this->session->set_flashdata('message', 'Class Successfully Created');
					redirect('classes/show/'.$class_id);

				}
			//Else just display the blank form
			}else{
				$this->load->view('classes/class_form', $data);
			}
		}
		
		function edit(){
		
		}
		
		function delete(){
		
		}
	}
?>