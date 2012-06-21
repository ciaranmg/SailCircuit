<?
class Ajax extends CI_Controller {


	function index(){

	}

	function profile_photo($controller, $object_id){
		$data = array(
				'form_action' => base_url('/'. $controller .'/profile_photo/' .$object_id),
				'redirect' => base_url('/'.$controller .'/view/' . $object_id)
				);

		$this->load->view('ajax_form/profile_photo_form', $data);
	}

	
	function meta($controller, $object_id){
		$fields = $this->config->item($controller . '_meta');
		$model_name = $controller . '_model';

		if($this->userlib->check_permission($controller . '_edit')){
			if($this->input->post('submit')){
				// Form has been submitted, handle the data.
				$meta_name = explode('|', $this->input->post('meta_name'));
				$field_name = $meta_name[0];
				$field_type = $meta_name[1];
				
				$field_label = $fields[$field_name]['label'];
				if($field_type == 'text'){
					$this->$model_name->save_meta($object_id, $field_name, $this->input->post('text_meta'));
					echo '<tr><th>' . $field_label .'</th><td id="tb-meta-' .$field_name .'" class="editable" target="'.base_url('ajax/edit/'. $controller .'/' . $field_name . '/' . $field_type . '/' . $object_id).'">' . $this->input->post('text_meta'). '</td></tr>';
				}

			}else{
				// Form hasn't been submitted. Show the form.
				$meta_options = $this->$model_name->get_meta_options($object_id);
				$data = array(
							'controller' => $controller, 
							'object_id' => $object_id, 
							'meta_options' => $meta_options,
							'target' => base_url('/ajax/meta/' . $controller .'/'. $object_id),
							'type' => 'meta',
							'field' => 'meta',
							'id' => '');
				$this->load->view('ajax_form/field_form', $data);
			}
		}else{
			echo "Insufficient Permission";
		}
	}

	function edit($controller, $field, $type, $id){
		$model_name = $controller . '_model';
		$this->load->model($model_name);
		if($this->userlib->check_permission($controller . '_edit')){

			// If this is a dropdown, then load the options up here. We'll need them more than once below.
			if($type == 'dropdown'){
				$lib = $controller.'lib';
				$this->load->library($lib);
				$options = $this->$lib->get_dropdown_options($field);
			}

			if($this->input->post('submit')){

				//form has been submitted
				// Check that the fields line up with the controller and method
				if($this->input->post('controller') == $controller && $this->input->post('id') == $id){
					
					$field = $this->input->post('field');
					$data = $this->input->post($field);
					$type = $this->input->post('type');

					// Make sure something has been submitted
					if($this->input->post($field) !== ''){
						// Update the existing value, then fetch the value from the database taking care of the non-standard field types
						
						if($type == 'datetime') $data = sc_strtotime($data[0] .' '. $data[1]);
						if($type == 'date') $data = sc_strtotime($data);
						$this->$model_name->update_field($field, $data, $id, $type);
						$result = $this->$model_name->get_field($field, $id);
						if($type == 'dropdown'){
							$data = array('content' => $options[$result->$field]);
						}else{
							$data = array('content' => $result->$field);
						}
						$this->load->view('data/'.$type, $data);
					}else{
						$result = $this->$model_name->get_field($field, $id);

						if($type == 'datetime'){
							$value = array(sc_date_format($result->$field), sc_time_format($result->$field));
						}elseif($type== 'date'){
							$value = sc_date_format($result->field);
						}else{
							$value = $result->$field;
						}
						$data = array(
								'target' => 'ajax/edit/' . $controller . '/' . $field . '/' . $type . '/' . $id,
								'field' =>	$field,
								'controller' => $controller,
								'id' => $id,
								'type' => $type,
								'value' => $value,
								'ajax_error' => $this->lang->line('error_invalid_ajax_data')
							);
						if(isset($options)) $data['options'] = $options;
						$this->load->view('ajax_form/field_form', $data);
					}	
				}else{
					return $this->lang->line('error_mismatch_fields');
				}
			}else{
				//form has not ben submitted		
				$result = $this->$model_name->get_field($field, $id);
				if($type == 'datetime'){
					$value = array(sc_date_format($result->$field), sc_time_format($result->$field));
				}else{
					$value = $result->$field;
				}
				$data = array(
							'target'=> 'ajax/edit/'. $controller .'/' .$field.'/'.$type.'/'.$id,
							'field' => $field,
							'controller' => $controller,
							'id' => $id,
							'type' => $type,
							'value' => $value
							);
				if(isset($options)) $data['options'] = $options;
				$this->load->view('ajax_form/field_form', $data);
			}	
		}else{
			echo "Insufficient Permission";
		}
	}
}
?>