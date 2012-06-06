<?
class Ajax extends CI_Controller {


	function index(){

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
					// Todo: Apply proper validation rules

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