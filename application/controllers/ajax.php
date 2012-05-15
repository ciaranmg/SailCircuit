<?
class Ajax extends CI_Controller {


	function index(){

	}

	function edit($controller, $field, $type, $id){
		$model_name = $controller . '_model';
		$this->load->model($model_name);
		if($this->userlib->check_permission($controller . '_edit')){
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
						$this->$model_name->update_field($field, $data, $id, $type);
						$result = $this->$model_name->get_field($field, $id);
						$this->load->view('data/'.$type, array('content' => $result->$field));
					}else{
						$result = $this->$model_name->get_field($field, $id);
						$data = array(
								'target' => 'ajax/edit/' . $controller . '/' . $field . '/' . $type . '/' . $id,
								'field' =>	$field,
								'controller' => $controller,
								'id' => $id,
								'type' => $type,
								'value' => $result->$field,
								'ajax_error' => $this->lang->line('error_invalid_ajax_data')
							);
						$this->load->view('ajax_form/field_form', $data);
					}	
				}else{
					return $this->lang->line('error_mismatch_fields');
				}
			}else{
				//form has not ben submitted		
				$result = $this->$model_name->get_field($field, $id);
				
				$data = array(
							'target'=> 'ajax/edit/'. $controller .'/' .$field.'/'.$type.'/'.$id,
							'field' => $field,
							'controller' => $controller,
							'id' => $id,
							'type' => $type,
							'value' => $result->$field
							);
				$this->load->view('ajax_form/field_form', $data);
			}	
		}else{
			echo "Insufficient Permission";
		}
	}
}
?>