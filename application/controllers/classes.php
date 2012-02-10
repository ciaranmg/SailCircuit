<?

	class Classes extends CI_Controller{
		
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
			//Todo: Get rating system, team system, scoring system etc.
			$this->load->view('classes/class_form');
		}
		
		function edit(){
		
		}
		
		function delete(){
		
		}
	}
?>