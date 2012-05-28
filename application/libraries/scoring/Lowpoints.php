<?
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class lowpoints {

	var $entries;
	function __construct(){
		$this->ci =& get_instance();
	}
	function process_race($race_data, $scoring){
		$this->ci->load->helper('sc_scoring_helper');

		$this->entries = count($race_data);
		$i = 1;

		$scoring = $this->scoring_model->get($scoring);

		foreach($race_data as &$entry){
			if($entry->status =='completed' OR $entry->status == 'RDG'){
				$entry->position = $i;
				$entry->points = $i;
				$i++;
			}else{
				$status = strtolower($entry->status);
				$fn = $scoring->rules->$status->function;
				$entry->position = $fn($race_data, $scoring->rules->$status->parameter);
			}
		}
		return $race_data;
	}

	
}
?>