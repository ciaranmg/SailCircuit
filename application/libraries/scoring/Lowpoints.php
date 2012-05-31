<?
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class lowpoints {
	
	function __construct(){
		$this->ci =& get_instance();
	}

	function order_by(){
		return array('field' => 'points', 'order' => 'asc');
	}

	/**
	 * Function to process race data
	 */
	function process_race($race_data, $scoring){
		$this->ci->load->helper('sc_scoring_helper');

		$num_entries = count($race_data);
		$race_pos = 1;
		$race_points = 1;
		// Sort the data by corrected time.
		usort($race_data, 'cmp_corrected_time');
		
		$i=0;
		while($i < $num_entries){
			if($race_data[$i]->status =='completed'){
				// This boat has completed the race.
				if($i+1 != $num_entries && $race_data[$i]->corrected_time == $race_data[$i+1]->corrected_time){
					// There's a tie in place. Skip ahead to find out how many.
					$tie_count = 0;
					for($j = $i; $j < $num_entries; $j++){
						if($race_data[$i]->corrected_time == $race_data[$j]->corrected_time){
							$tie_count++;
						}
					}
					$tp = $this->tie_points($tie_count, $race_pos);
					for($y=0; $y < $tie_count; $y++){
						$race_data[$i + $y]->points = $tp;
						$race_data[$i + $y]->position = $race_pos;
					}
					$i++;
					$race_pos+=$tie_count;
				}else{
					$race_data[$i]->position = $race_pos;
					$race_data[$i]->points = $race_pos;
					$race_pos++;
				}

			}elseif(strtolower($race_data[$i]->status) == 'rdg'){
				// This boat has been given a redress by the race committee. 
				// As such, they should have been assigned position and points 
				$race_data[$i]->position = $race_data[$i]->position;
				$race_data[$i]->points = $race_data[$i]->position;
				$race_pos++;
			}else{
				$status = strtolower($race_data[$i]->status);
				$fn = $scoring->rules->$status->function;
				$race_data[$i]->position = '';
				$race_data[$i]->points = $fn($race_data, $scoring->rules->$status->parameter);
				$race_data[$i]->corrected_time = '';
			}
			$i++;
		}
		return $race_data;
	}

	function tie_points($tie_count, $race_pos){
		$total = 0;
		for($i=0; $i < $tie_count; $i++){
			$total += $race_pos;
			$race_pos++;
		}
		$x =  $total / $tie_count;
		return $x;
	}
}
?>