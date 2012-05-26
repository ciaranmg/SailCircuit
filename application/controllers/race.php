<?
	class Race extends CI_Controller {
		
		public function index(){
			redirect(base_url('races/input'));
		}

		/**
		 * Method to display the race data input form
		 * Does not handle the data. That's taken care of by AJAX mehod: ajax_handle_data
		 */
		public function input($race_id = null){			
			$this->userlib->force_login();
			$this->load->model('regatta_model');
			$this->load->model('classes_model');
			$this->load->model('race_model');

			$data['breadcrumb'] = $this->breadcrumb->get_path();
			$data['help'] = 'race_input';

			$data['regattas'] = $this->regatta_model->get_regattas_dropdown($this->session->userdata('club_id'));
			$this->load->view('races/input', $data);
		}

		/**
		 * Method to handle the form data submitted by the race data input form.
		 * 			1. Stores the data in a raceData object
		 * 			2. Returns that data in json encoded form to be handled by the page 
		 *			3. The page takes the data and presents it for the user to confirm
		 *			4. The method then handles the confirmed data and calls the model to commit to the database
		 */
		public function ajax_handle_data(){
			if(!is_ajax()) show_404('ajax_handle_data');
			$this->load->model('race_model');

			if($this->input->post('submit') && $this->input->post('confirm')){
				// Check if the form has been submitted and confirmed
				
				$this->race_model->process_data();

			}elseif($this->input->post('submit')){
				// Just the first round has been submitted. Parse the data and return for the user to confirm.
				$data['race'] = $this->race_model->get($this->input->post('race_picker'));
				$data['timer'] = $this->input->post('timer');
				
				$t = $this->input->post('race_datetime');
				$data['race_date'] = $t[0];
				$data['race_time'] = $t[1];

				$p = $this->race_model->process_raw_data($this->input->post('race_data'), array('club_id' => $this->session->userdata('club_id')));
				$data['entries'] = $p['entries'];
				$data['count'] = $p['count'];
				$this->load->view('form/tbl_race_input', $data);
			}else{
				// If none of the conditions are met, do nothing.
				$this->firephp->log('ajax_handle_data: Criteria not met');
			}
		}

		public function view($race_id){

		}


		/**
		 * Method to get the start date and time of a race
		 */
		function get_race_datetime($race_id, $json=true){
			$this->load->model('race_model');

			$result = $this->race_model->get_field('start_date', $race_id);

			$start_time = array('date' => sc_date_format($result->start_date), 'time' => sc_time_format($result->start_date));
			if($json===true){
				echo json_encode($start_time);
			}else{
				return $start_time;
			}
		}

		/**
		 * Method to return a json encoded array of class names and ids for in a dropdown menu
		 */
		public function ajax_classes_list($regatta_id){

			if(!is_ajax()) show_404('ajax_classes_list');
			$this->load->model('classes_model');

			if($regatta_id == 0 OR $regatta_id =='') echo json_encode(array('value'=> '0', 'display' => ''));

			if($this->userlib->check_permission('race_edit', array('regatta_id'=> $regatta_id))){
				echo json_encode($this->classes_model->get_classes_dropdown($regatta_id));
			}else{
				$this->firephp->log('Permissions failed');
			}
		}



		/**
		 * Method to return a json encoded array of race names and ids for use in a dropdown menu.
		 */
		public function ajax_races_list($class_id){
			if(!is_ajax()) show_404('ajax_races_list');
			$this->load->model('race_model');

			if($class_id == 0 OR $class_id == '') echo json_encode(array('value'=> '0', 'display' => ''));

			if($this->userlib->check_permission('race_edit', array('class_id' => $class_id))){
				echo json_encode($this->race_model->get_races_dropdown($class_id, 'open'));
			}else{
				$this->firephp->log('Permissions denied');
			}
		}
		/**
		 * Method to add races to a class
		 * Displays an ajax form with a dropdown menu allowing the user to add races up to a maximum set by config variables
		 * Handles the submitted data from the form and calls the relevant models to commit the changes to the database.
		 */
		public function ajax_add_races($class_id){
			if(!is_ajax()) show_404('ajax_add_races');
			$this->load->model('race_model');
			$this->load->model('classes_model');

			// Check if the user has permission to do this
			if($this->userlib->check_permission('classes_edit', array('class_id'=>$class_id))){
				if($this->input->post('submit')){
					// Form has been submitted
					$this->race_model->initialise_races('Race ', $class_id, $this->input->post('race_count'));
					$data['races'] = $this->race_model->get_races($class_id);
					// Flag the class as being modified so that the results will be recalculated.
					$this->classes_model->update_field('status', 'modified', $class_id);
					$this->load->view('races/tbl_list_races', $data);
				}else{
					// Form has not been submitted. Find out how many races there are and start the options from n+1
					$class = $this->classes_model->get($class_id);

					// The config settings define how many races you can have. The class->race_count value shows how many there are already.
					$race_count_options = array();
					for($i = 1; $i <= $this->config->item('sc_class_max_races') - $class->race_count; $i++){
						$race_count_options[$i] = $i;
					}
					$this->firephp->log($race_count_options);
					$data['class'] = $class;
					$data['class_id'] = $class->id;
					$data['race_count_options'] = $race_count_options;
					$data['races'] = $this->race_model->get_races($class_id);
					$this->load->view('races/tbl_list_races', $data);
					$this->load->view('races/add_races_form', $data);
				}
			}else{
				$this->firephp->log('permission denied');
			}
		}

	}
	
	/* End of file races.php */
?>