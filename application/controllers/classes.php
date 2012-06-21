<?
	class Classes extends CI_Controller{
		private $class = array(
			'name' =>'',
			'regatta_id' => 0, 
			'race_count' => 0,
			'rating_system_id'=>0,
			'description'=>'',
			'discards'=>0,
			'status' => 'active',
			'scoring_system' => 0,
			'tiebreak_system' => 0
		);

		private $class_boats = array();

		function index(){
			redirect(base_url('/'));
		}


		function profile_photo($class_id){
			if($this->userlib->check_permission('classes_edit', array('class_id' => $class_id))) {
				if($this->input->post('submit')){
					$club_dir = './uploads/'.$this->session->userdata('club_id') .'/';
					$upload_path =  $club_dir . 'classes/';
					$config['upload_path'] = $upload_path;
					$config['allowed_types'] = 'gif|jpg|png|jpeg';
					$config['max_size']	= '2048';
					$config['max_width']  = '2048';
					$config['max_height']  = '1536';
					$config['remove_spaces'] = TRUE;
					$this->load->library('upload', $config);

					if(!file_exists($club_dir))
						mkdir($club_dir);
					
					if(!file_exists($upload_path))
						mkdir($upload_path);
					
					if (!$this->upload->do_upload('profile-photo')){
						$this->session->set_flashdata('err_message', $this->upload->display_errors());
					}else{
						$data = $this->upload->data();
						
						$config['source_image']	= $data['full_path'];
						$config['maintain_ratio'] = TRUE;

						$img_config = $this->config->item('sc_image_options');
						$config['width'] = $img_config['banner']['width'];
						$config['height'] = $img_config['banner']['height'];
						$new_filename = $data['raw_name'] . '_banner' . $data['file_ext'];
						$new_filepath = $data['file_path'];
						$config['new_image'] = $new_filepath . $new_filename;
						$this->image_lib->initialize($config);
						$this->image_lib->resize();
						$meta_data['banner'] = array(
											'file_name' => $new_filename, 
											'file_type' => $data['file_type'], 
											'file_path' => str_replace('./', '/', $upload_path),
											'full_path' => str_replace('./', '/', $upload_path) . $new_filename,
											'raw_name' => $data['raw_name'] . '_banner',
											'file_ext' => $data['file_ext'],
											'image_width' => $config['width'],
											'image_height' => $config['height'],
											'image_size_str' => 'width="'. $config['width'] .'" height="'.$config['height'].'"');
					
						$this->classes_model->delete_meta(array('class_id' => $class_id, 'field'=>'_image'));
						$this->classes_model->save_meta($class_id, '_image', json_encode($meta_data), 'file');
						$this->session->set_flashdata('message', 'File Uploaded Successfully');
					}
				}
				redirect($this->input->post('redirect'));
			}
		}


		/**
		 * Method to save settings for display of results
		 *
		 */
		function save_display_settings($class_id){
			if($this->userlib->check_permission('classes_edit', array('class_id' => $class_id)) AND is_ajax()){
				$class_columns = array();
				foreach(array_keys($this->config->item('class_columns')) as $col){
					$class_columns[$col] = $this->input->post('class_col_'.$col);
				}
				// Clear old values
				$this->classes_model->delete_meta(array('class_id' => $class_id, 'field'=> '_class_columns'));
				// Save new
				$this->classes_model->save_meta($class_id, '_class_columns', $class_columns, 'array');

				$race_columns = array();
				foreach(array_keys($this->config->item('race_columns')) as $col){
					$race_columns[$col] = $this->input->post('race_col_'.$col);
				}
				// Clear old values
				$this->classes_model->delete_meta(array('class_id' => $class_id, 'field' => '_race_columns'));
				// Save New
				$this->classes_model->save_meta($class_id, '_race_columns', $race_columns, 'array');

				$race_settings = array();
				foreach(array_keys($this->config->item('race_settings')) as $setting){
					$race_settings[$setting] = $this->input->post($setting);
				}
				// Clear old values
				$this->classes_model->delete_meta(array('class_id' => $class_id, 'field' => '_race_settings'));
				// Save New
				$this->classes_model->save_meta($class_id, '_race_settings', $race_settings, 'array');

				$class_settings = array();
				foreach(array_keys($this->config->item('class_settings')) as $setting){
					$class_settings[$setting] = $this->input->post($setting);
				}
				$this->classes_model->delete_meta(array('class_id'=> $class_id, 'field' => '_class_settings'));
				$this->classes_model->save_meta($class_id, '_class_settings', $class_settings, 'array');
			}
		}

		function view($id=null){
			$this->userlib->force_login();
			$class = $this->classes_model->get($id);
			$points_table = false;
			$this->userlib->force_permission('classes_view', array('class_id' => $id));	
			if($class){

				$races = $this->race_model->get_races($id);
				$points_table = $this->race_model->get_points_table($id);
				$race_columns = $this->config->item('race_columns');
				$class_columns = $this->config->item('class_columns');
				$race_settings = $this->config->item('race_settings');
				$class_settings = $this->config->item('class_settings');
				$boats = $this->boats_model->get_class_boats($id);
				$data = array(
								'class_settings' => $class_settings,
								'race_settings' => $race_settings, 
								'race_columns' => $race_columns,
								'class_columns' => $class_columns, 
								'points_table' => $points_table, 
								'class'=> $class, 
								'races' => $races, 
								'show_handicap' => true, 
								'boats' => $boats, 
								'breadcrumb' => $this->breadcrumb->get_path());
				
				if($class->status == 'modified'){
					$data['err_message'] = "Settings for this class have been changed. Click the refresh button to calculate race results based on these new settings";
				}
				$this->load->view('classes/view_class', $data);
			}else{
				show_404('classes/view/'. $id);
			}
		}
		
		function create($regatta_id){
			$this->userlib->force_login();
			$this->userlib->force_permission('classes_create', array('regatta_id'=> $regatta_id));
			// Todo: make use of the classlib function that returns options for the dropdowns
			
				// Build the form options
				$handicaps = $this->handicap_model->get_handicaps();

				$classRatingSystems = array('0' => 'Choose One');
				foreach($handicaps as $h){
					$classRatingSystems[$h->id] = $h->description;
				}
				$classTiebreakers = array('0' => 'Choose One');
		
				foreach($this->classes_model->get_tiebreakers() as $tb){
					$classTiebreakers[$tb->id] = $tb->name;
				}

				$classScoringSystems = array('0' => 'Choose One');
				foreach($this->scoring_model->get_scoring_systems() as $ss){
					$classScoringSystems[$ss->id] = $ss->name;
					// $this->firephp->log($ss);
				}

			// Get boats to populate the boat selectors
			$boats = $this->boats_model->get_boats(array('club_id' => $this->session->userdata('club_id')), 'sail_number' );
			$i = 0;

			foreach($boats as $b){
				$boats_out[$i] = new stdClass;
				$boats_out[$i]->id = $b->id;
				$boats_out[$i]->name = $b->sail_number . ' ' . $b->name;
				$i++;
			}
			unset($i);

			$form = array(
				'action' => 'classes/create/' . $regatta_id,
				'parent' => $regatta_id,
				'submit' => 'submit',
				'button_label' => 'Create Class',
				'fields' => array(
					array('name' => 'name', 'type' => 'text', 'label' => 'Name', 'value' => '', 'required' => true),
					array('name' => 'description','type' => 'textarea','label' => 'Description', 'value' => ''),
					array('name'=> 'race_count', 'type' => 'text', 'label' => 'Number of Races', 'value' => ''),
					array('name' => 'rating_system_id','type' => 'dropdown','label' => 'Rating System','value' => '','selected' => '0', 'options' => $classRatingSystems,'required' => true),
					array('name' => 'discards','type' => 'text', 'label' => 'Number of Discards','value'=> '0'),
					array('name' => 'min_races_discard', 'type' => 'text', 'label' => 'Min number of races before discard', 'value' => '0'),
					array('name' => 'tiebreak_system','type' => 'dropdown','label' => 'Tiebreak System','selected' => '0','options' => $classTiebreakers,'required' => true),
					array('name' => 'scoring_system','type' => 'dropdown','label'=> 'Scoring System','selected' => '0','options' => $classScoringSystems,'required' => true),
					array('name' => 'boat_selector','type' => 'custom','custom_field' => 'class_boat_selector','label' => 'Select Boats for this Class','boats_out' => $boats_out,'boats_in' => array())
				)
			);

			$data['form'] = $form;
			$data['breadcrumb'] = $this->breadcrumb->get_path();
			$data['title'] = 'Create New Class';
			$data['intro'] = "A class is a group of boats that follow a set of rules within a regatta. Boats can be in any number of classes even within the same regatta";

			// Check if Form Has been submitted
			if($this->input->post('submit') && $this->input->post('action') == 'classes/create/' . $regatta_id){
				$missing_handicap_flag = false;
				//Check to see if the submitted form passes validation
				if($this->form_validation->run('classes_create') === false){
					$form_validation->set_error_delimiters('<p>', '</p>');
					for($i = 0; $i < sizeof($form['fields']); $i++){
						if($form['fields'][$i]['type'] == 'dropdown'){
							$form['fields'][$i]['selected'] = set_value($form['fields'][$i]['name']);
						}else{
							$form['fields'][$i]['value'] = set_value($form['fields'][$i]['name']); 	
						}
					}
					$data['form'] = $form;
					$this->load->view('classes/class_form', $data);
				
				}else{
					//Double Check security first
					$this->userlib->force_permission('classes_create', array('regatta_id' => $this->input->post('parent')));
					
					$handicap_system = $this->handicap_model->get($this->input->post('rating_system_id'));

					foreach($form['fields'] as $field){
						if($field['name'] == 'boat_selector'){
							// Custom fields need a bit more love.
							if(is_array($this->input->post('boats_in'))){
								$x = 0;
								$boats = $this->input->post('boats_in');
								
								foreach($boats as $boat_id){
									// An array that contains the boat_id and handicap values for the classes selected handicap.
									$this->class_boats[] = array(
													'boat_id' => intval($boat_id),
													'handicap' => $this->handicap_model->get_boat_handicap($boat_id, $handicap_system->name)
													);
									if($this->class_boats[$x]['handicap'] == 0 OR $this->class_boats[$x] == 0.00) $missing_handicap_flag = true;
									$x++;
								}
								unset($x);
							}
						}elseif($field['name'] == 'race_count'){
							// Race count isn't a field in the classes database. We'll initialise the races below
							$race_count = $this->input->post($field['name']);
						}else{
							$this->class[$field['name']] = $this->input->post($field['name']);
						}
					}

					$this->class['regatta_id'] = $this->input->post('parent');
					
					$class_id = $this->classes_model->insert($this->class);
					
					// Initialise the Column Settings meta data
					$this->classes_model->save_meta($class_id, '_class_columns', $this->config->item('class_columns'), 'array');
					$this->classes_model->save_meta($class_id, '_race_columns', $this->config->item('race_columns'), 'array');
					
					$this->race_model->initialise_races('Race ', $class_id, $race_count);

					if(sizeof($this->class_boats) > 0) $this->classes_model->set_class_boats($this->class_boats, $class_id);			
					
					$this->session->set_flashdata('message', 'Class Successfully Created. <a href="'. base_url('classes/create') . '/' . $this->class['regatta_id'] . '">Create another</a>');
					if($missing_handicap_flag === true) $this->session->set_flashdata('err_message', "Some of the selected boats do not have ". $handicap_system->name ." handicap ratings. You'll need to add them in.");
					redirect('classes/view/'.$class_id);
				}
			//Else just display the blank form
			}else{
				$this->load->view('classes/class_form', $data);
			}
		}
		/**
		 * 		Loads a form in AJAX to allow the user to select boats for the current class
		 *		
		 */
		function ajax_boat_selector($class_id){
			if(!is_ajax()) show_404('classes/ajax_boat/selector/'.$class_id);

			$data['class_id'] = $class_id;
			$data['show_handicap'] = true;
			// Check Permissions
			if($this->userlib->check_permission('classes_edit', array('class_id' => $class_id))){
				if($this->input->post('submit')){
					// Form has been submitted.
					$changes = $this->classes_model->update_class_boats($class_id, $this->input->post('boats_in'));
					$class = $this->classes_model->get($class_id);
					// Update the class status because it's been modified.
					$this->classes_model->update_status(array('class_id' => $class_id), 'modified');
					$this->race_model->new_boats_to_races($changes['new_class_boats'], $class);
					$this->race_model->remove_boats_races($changes['remove_class_boats'], $class);
					$data['boats'] = $this->boats_model->get_class_boats($class_id);
					$this->load->view('boats/tbl_list_boats', $data);
				}else{
					// Get class boats
					$class_boats = $this->boats_model->get_class_boats($class_id);
					if($class_boats){
						$i = 0;
						foreach($class_boats as $cb){
							$boats_in[$i] = new stdClass;
							$boats_in[$i]->id = $cb->id;
							$boats_in[$i]->name = $cb->name;
							$boats_in[$i]->sail_number = $cb->sail_number;
							$i++;
						}
					}else{
						$boats_in = array();
					}
					// Get all boats
					$boats = $this->boats_model->get_boats(array('club_id' => $this->session->userdata('club_id')), 'sail_number');
					$i = 0;
					$boats_out = array();
					foreach($boats as $b){
						$found = false;
						foreach($boats_in as $bi){
							if($b->id == $bi->id) {
								$found = true;
								break;
							}
						}
						if($found === false){
							$boats_out[$i] = new stdClass;
							$boats_out[$i]->id = $b->id;
							$boats_out[$i]->name = $b->sail_number . ' ' . $b->name;
							$i++;
						}
					}
					unset($i);
					// Build the form field data.
					$data['custom_field'] = array( 'name' => 'boat_selector', 'type' => 'custom', 'custom_field' => 'class_boat_selector', 'label' => 'Select Boats for this Class', 'boats_out' => $boats_out, 'boats_in' => $boats_in);
					$this->load->view('classes/ajax_boat_selector', $data);
				}
			}else{
				echo '<div class="alert alert-error">You do not have permission to edit this resource</div>';
				error_log('User' . $this->session->userdata('user_id') .'Tried to edit Class' . $class_id);
			}

		}
		/**
		 * Function to delete a class
		 *		Also removes:
		 *						Races
		 *						Class Boats
		 *						Class Meta
		 *						Race Result Data
		 */
		function delete(){
			$this->userlib->force_login();
			if($this->input->post('submit') == 'submit' AND $this->input->post('confirm_delete') == 'form_submit') {
				$this->userlib->force_permission('classes_delete', array('class_id' => $this->input->post('object_id')));
				
				$x = $this->classes_model->delete(intval($this->input->post('object_id')));
				
				if($races = $this->race_model->get_races($this->input->post('object_id'))){
					foreach($races as $race){
						$this->race_model->clear_race_data($race->id);
						$this->race_model->delete_races($race->id);
					}
				}
				if($x===true){
					$this->session->set_flashdata('message', 'Class Deleted Successfully');
				}else{
					$this->session->set_flashdata('err_message', 'There was a problem deleting the Class from the database');
				}
			}else{
				$this->session->set_flashdata('err_message', 'There was a problem deleting the Class');
			}
			if($this->input->post('referrer')){
				redirect(base_url($this->input->post('referrer')));
			}else{
				redirect(base_url(''));
			}
		}
}
?>