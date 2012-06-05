<?
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class lowpoints {
	
	function __construct(){
		$this->ci =& get_instance();
	}

	function order_by(){
		return array('field' => 'points', 'order' => 'asc');
	}

	function process_class($class_data, $class){
		$this->ci->load->model('scoring_model');
		$num_entries = count($class_data);

		$tie_breakers = $this->ci->scoring_model->get_tiebreakers($class->ties_id);

		usort($class_data, 'cmp_lowpoints');
		$i = 1;
		foreach($class_data as &$entry){
			$entry->position = $i;
			$entry->tie_fixed = false;
			$i++;
		}

		$pass = 0;
		$all_ties = $this->detect_series_ties($class_data);
		
		while($all_ties AND $pass < 3){
			foreach($all_ties as $ties){
				$fn = $tie_breakers->rules[$pass]['function'];
				if(method_exists($this, $fn)){
					$class_data = $this->fn($class_data, $ties);
				}
			}
			$pass++;
		}
		
		return $class_data;
	}
	/**
	 * Function to detect ties in a class
	 * Parameters: 
	 *				array 		$class_data		An array of class data objects
	 * Returns:
	 *				array 						An associative array
	 */
	function detect_series_ties($class_data){
		$num_entries = count($class_data);
		$i = 0;
		while($i < $num_entries){
			if($i+1 != $num_entries && $class_data[$i]->series_points == $class_data[$i+1]->series_points AND !$class_data[$i]->tie_fixed){
				// There's a tie in place. Skip ahead to find how many.
				$ties = array();
				for($j = $i+1; $j < $num_entries; $j++){
					if($class_data[$i]->series_points == $class_data[$j]->series_points AND !$class_data[$i]->tie_fixed){
						$ties[] = $i;
						$ties[] = $j;
					}
				}
				if(count($ties) > 0){
					$ties = array_unique($ties);
					$i += count($ties);
					$all_ties[] = $ties;
					continue;
				}
			}
			$i++;
		}
		if(count($all_ties) > 0){
			return $all_ties;
		}else{
			return false;
		}
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



	/**
	 * Function to break ties according to Rule A8.1 under the RRS
	 * It will also detect if ties still exist and flag them accordingly
	 * parameters:
	 *				array 		$class_data 	Array of class_data objects
	 *				array 		$ties 			An Array of indices that identify rows that are tied.
	 *  Returns
	 *				array 						An array of class_data objects
	 *	Modifies:
	 *				[n]->tie_fixed
	 *								boolean 	false if tie(s) remain(s)
	 *								string 		 If tie has been broken under this rule
	 *				[n]->position
	 *								Inserts the new position for elements and sorts the array accordingly.
	 */
	function a8_1($class_data, $ties){
		// First get the race results for each tied boat
		foreach ($ties as $t) {
			$positions[] = $class_data[$t]->position;
			$temp = $class_data[$t]->race_results;
			foreach ($temp as $race) {
				if($race->discarded == 0){
					$races[$t][] = intval($race->points);
				}
			}
			// Using sort because we want to lose the array keys. Otherwise two equal sets of data could be considered inequal
			sort($races[$t]);
		}
		asort($positions);
		asort($races);
		$boat_ids_by_rank = array_keys($races);
 		// $this->ci->firephp->log($boat_ids_by_rank, 'Boat IDs by rank');

		for($i = 0; $i < sizeof($ties); $i++){
			$boat_id = $boat_ids_by_rank[$i];
			// $this->ci->firephp->log('Comparing ' . $class_data[$boat_id]->name);
			$other_boats = $boat_ids_by_rank;
			unset($other_boats[$i]);
			$class_data[$boat_id]->position = $positions[$i];

			$tie_flag = false;
			foreach($other_boats as $ob){				
				if($races[$boat_id] === $races[$ob]){
				//	$this->ci->firephp->log('Tied with ' . $class_data[$ob]->name);					
					$tie_flag = true;
				}
			}
			if($tie_flag){
				$class_data[$boat_id]->tie_fixed = false;
			}else{
				$class_data[$boat_id]->tie_fixed = 'Tie breaker under rule A8.1';
			}	
		}
		// Sort the class_data based on the new positions
		usort($class_data, 'cmp_position');
		return $class_data;
	}

	/**
	 * Function to break ties based on the last result, working through each result until ties are resolved.
	 */
	function a8_2($class_data, $ties){
		// First get the race results for each tied boat
		foreach ($ties as $t) {
			$positions[] = $class_data[$t]->position;
			$temp = $class_data[$t]->race_results;
			$num_races = sizeof($temp);
			foreach ($temp as $race) {
				$boat_races[$t][] = intval($race->points);
			}
		}
		// fb($boat_races, 'Races');
		sort($positions);
		// fb($positions, 'Positions Sorted');
		$i = $num_races -1;

		// loop through each race until all ties are broken.
		while ($i >= 0 AND sizeof($positions) > 0) {
			// fb($i, 'ROUND ');
			$last_race = array();
			// Create an array of the points for the last (current) race.
			foreach($boat_races as $boat_id => $points){
				$last_race[$boat_id] = $points[$i];
			}
			// fb($last_race, 'Last Race Where i is ' .$i);
			asort($last_race);

			$boat_ids_by_rank = array_keys($last_race);

			for($j = 0; $j < sizeof($last_race); $j++){
				// fb($j, 'JAY IS');
				$boat_id = $boat_ids_by_rank[$j];
				$this_boat_result = $last_race[$boat_id];
				
				// fb($boat_ids_by_rank ,'Boat IDs by Rank');
				
				// Now get the results for all the boats, removing the currnent boat
				$other_boats_results = $last_race;
				unset($other_boats_results[$boat_id]);
				
				// fb($this_boat_result, $class_data[$boat_id]->name .' Result');
				// fb($other_boats_results, 'Other Boats');

				if(!in_array($this_boat_result, $other_boats_results)){
					// If the result for the current boat isn't found in the results for the other boats, then the tie has been broken for this.
					$class_data[$boat_id]->position = $positions[0];
					// fb($positions[$j], $class_data[$boat_id]->name . ' Set to Position');
					// fb($class_data[$boat_id], 'Boat Entry');
					$class_data[$boat_id]->tie_fixed = "Tie Broken Under Rule A8.2";
					
					unset($boat_races[$boat_id]);
					array_shift($positions);
					
					// fb($positions, 'Positions after unset');
				}
			}
			$i--;
		}
		usort($class_data, 'cmp_position');
		return $class_data;
	}

}
?>