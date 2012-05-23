<? if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	/**
	* Library class to help setting up classes.
	*/
	class Classeslib {
		
		function __construct(){
			$this->CI =& get_instance();
		}

		function get_dropdown_options($field){
			$this->CI->load->model('classes_model');
			if($field == 'rating_system_id'){
				$this->CI->load->model('handicap_model');
				$result = $this->CI->handicap_model->get_handicaps();
			}elseif($field == 'tiebreak_system'){
				$result = $this->CI->classes_model->get_tiebreakers();
			}elseif($field == 'scoring_system'){
				$result = $this->CI->classes_model->get_scoring_systems();
			}

			foreach($result as $obj){
				$options[$obj->id] = $obj->name;
			}
			return $options;
		}
	}
?>