<?
class Race_model extends CI_Model{
	
	var $race_data;
	/**
	 * Method to insert race data for boats that have just been added to a class
	 * Parameters:
	 *				array 		$boats
	 *				object 	$class
	 */
	function new_boats_to_races($boats, $class){
		if(is_array($boats) AND count($boats) == 0) return null;
		$lib = $class->scoring_system->library;
		$this->load->library('scoring/'. $lib);
		$query = $this->db->select('id')->from('races')->where('status', 'completed')->where('class_id', $class->id)->get();
		// if there's no races completed, do nothing.
		if($query->num_rows() > 0){
			foreach($query->result() as $r){
				$this->db->insert_batch('race_results', array_elements(array('boat_id', 'handicap', 'status', 'race_id'), $boats, $r->id));
				$race_data = $this->race_model->get_result_data($r->id);
				$race_data = $this->$lib->process_race($race_data, $class->scoring_system);
				$this->race_model->update_results($race_data);
			}
		}
	}

	/**
	 * Method to remove boat data from completed races
	 * Parameters:
	 *				array 		$boats
	 *								->id 	(boat_id)
	 *				object 		$class
	 */
	function remove_boats_races($boats, $class){
		if(is_array($boats) AND count($boats) < 0) return null;
		$lib = $class->scoring_system->library;
		$this->load->library('scoring/' . $lib);
		$query = $this->db->select('id')->from('races')->where('status', 'completed')->where('class_id', $class->id)->get();
		if($query->num_rows()>0){
			foreach($query->result() as $r ){
				foreach($boats as $b){
					$this->db->delete('race_results', array('boat_id' => $b->boat_id, 'race_id' => $r->id));
					$this->firephp->log($this->db->last_query());
				}
				$race_data = $this->race_model->get_result_data($r->id);
				$race_data = $this->$lib->process_race($race_data, $class->scoring_system);
				$this->race_model->update_results($race_data);
			}
		}
	}

	/**
	 * Method to compile the standings of a given class
	 */
	function get_points_table($class_id){
		
		$completed_races = $this->race_model->count_completed_races($class_id);		
		if($completed_races){
			$class = $this->classes_model->get($class_id);
			$scoring = $this->scoring_model->get($class->scoring_id);
			$slib = $scoring->library;
			$this->load->library('scoring/'.$slib);	

			$this->classes_model->apply_discards($class_id);
			
			$points_table = $this->classes_model->get_class_table($class_id);
			
			$points_table = $this->$slib->process_class($points_table, $class);

			return $points_table;
		}else{
			return false;
		}
	}

	/**
	 * Method to get the race_ids of all the races in a class that can be discarded;
	 */
	function get_discardable_races($class_id){
		$query = $this->db->select('id')->from('races')->where('discard', 1)->where('class_id', $class_id)->where('status', 'completed')->order_by('start_date', 'ASC')->get();
		if($query->num_rows() >0){

			foreach($query->result() as $r){
				$ids[] = $r->id;
			}
			return $ids;
		}else{
			return false;
		}
	}

	function clear_discards($class_id){
		$this->db->query('UPDATE sc_race_results, sc_races SET discarded = 0 WHERE sc_race_results.race_id = sc_races.id AND sc_races.class_id =' .$class_id);
	}

	/**
	 * Method to count the number of completed races in a given class
	 */
	function count_completed_races($class_id){
		return $this->db->from('races')->where('status', 'completed')->where('class_id', $class_id)->count_all_results();
	}

	/**
	 * Method to get list of races given a class_id
	 * Parameters
	 *				int 		$class_id
	 * Returns
	 *				array 		Array of race objects
	 */
	function get_races($class_id){
		$this->db->from('sc_races')->where('class_id', $class_id);
		$this->db->order_by('start_date','asc');
		$this->db->order_by('id', 'asc');
		$this->db->order_by('start_date', 'asc');
		$query = $this->db->get();
		if($query->num_rows() > 0) {
			// $this->firephp->log($query->result());
			return $query->result();
		}else{
			// $this->firephp->log('or here');
			return false;
		}
	}


	/**
	 * Method to get an individual race given it's ID
	 * Parameters:
	 *					int 			$race_id
	 * Returns:
	 *					object 			Object of race data
	 */
	function get($race_id){
		$this->db->select('races.id, 
							races.class_id,
							races.name, 
							races.start_date, 
							races.discard,
							races.status, 
							classes.scoring_system,
							classes.tiebreak_system,
							handicap_systems.id as handicap_id, 
							handicap_systems.name as handicap_name');
		$this->db->from('races');
		$this->db->join('classes', 'classes.id = races.class_id');
		$this->db->join('handicap_systems', 'handicap_systems.id = classes.rating_system_id');
		$this->db->where('races.id', $race_id);
		$this->db->group_by('races.id');
		$query = $this->db->limit(1)->get();

		if($query->num_rows() > 0){
			return $query->first_row();
		}else{
			return false;
		}

	}

	/**
	 * Method to get a list of race names, and ID's for use in a dropdown menu
	 * Parameters:
	 *					int 			$class_id
	 * 					string 			[$status] 		A string containing a status to filter for
	 */
	function get_races_dropdown($class_id, $status = 'open'){
		$query = $this->db->select('sc_races.id, sc_races.name')->from('sc_races')->where('class_id', $class_id)->where('status', $status)->get();
		$races_list[] = array('value' => '0', 'display' => 'Choose One');
		if($query->num_rows() > 0){
			foreach($query->result() as $r){
				$races_list[] = array('value' => $r->id, 'display' => $r->name);
			}
		}
		return $races_list;
	}

	/**
	 *	Method to delete races given a race_id
	 *  Also deletes meta data associated with Race
	 */
	function delete_races($id){
		if(is_array($id)){
			$this->db->where_in('id', $id);
		}else{
			$this->db->where('id', $id);
		}
		$this->db->delete('sc_races');
	}

	function clear_race_data($race_id){
		$this->db->where('race_id', $race_id)->delete('sc_race_data');
		$this->db->where('race_id', $race_id)->delete('sc_race_results');
		$this->db->where('id', $race_id)->update('sc_races', array('status'=>'open'));
	}


	/**
	 * Method to update the results table with the processed results
	 * Parameters:
	 *				array stdObject		An array of objects that relate to the sc_race_results table
	 */
	function update_results($race_data){

		foreach($race_data as $rd){
			$this->db->where('id', $rd->id);
			$this->db->update('race_results', $rd);
		}
	}

	function insert_results($race_data){
		$fields = array('elapsed_time', 'handicap', 'corrected_time', 'position', 'points', 'status', 'sail_number', 'boat_id', 'race_id');
		foreach($race_data as $rd){
			$rd = get_object_vars($rd);
			$this->db->insert('race_results', elements($fields, $rd));
		}
	}

	/**
	 * Method to get the result data for the given race_id
	 * Parameters:
	 *				integer: $race_id
	 */
	function get_result_data($race_id, $order_by = array('field' => 'corrected_time', 'order' => 'ASC')){
		$query = $this->db->order_by($order_by['field'], $order_by['order'])->get_where('race_results', array('race_id' => $race_id));
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}

	/**
	 * Method to get a readable results table for display to the user
	 */
	function get_readable_results($race_id){
		
		// Load the scoring library so we can fetch the order by info
		$race = $this->race_model->get($race_id);
		$scoring = $this->scoring_model->get($race->scoring_system);
		$slib = $scoring->library;
		$this->load->library('scoring/'.$slib);
		$order_by = $this->$slib->order_by();

		$this->db->select('race_results.points,
							 race_results.sail_number, 
							 boats.name as boat_name, 
							 coalesce(group_concat(sc_owners.name SEPARATOR \', \'), \' \') as owner,
							 race_results.elapsed_time, 
							 race_results.handicap, 
							 race_results.corrected_time,
							 race_results.position,
							 race_results.status,
							 race_results.boat_id,
							 race_results.discarded,
							 race_results.race_id,
							 race_results.id
							 ', false);
		$this->db->from('race_results');
		$this->db->join('boats', 'boats.id = race_results.boat_id');
		$this->db->join('boat_owners', 'race_results.boat_id = boat_owners.boat_id', 'left');
		$this->db->join('owners', 'boat_owners.owner_id = owners.id', 'left');
		$this->db->where('race_id', $race_id, false);
		$this->db->order_by($order_by['field'], $order_by['order']);
		$this->db->group_by('race_results.id');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}


	/**
	 * Method to calculate the race corrected times.
	 * Parameters:
	 *				int 	$race_id
	 *				array 	$race_data 		Array of race_data objects
	 * Returns:
	 *				array 					Array of race_data objects
	 */
	function calculate_corrected($race_id, $race_data){
		$race = $this->race_model->get($race_id);
		// Clear out any existing race results
		// $this->db->where('race_id', $race_id)->delete('race_results');
		
		// $race_data = $this->db->where('race_id', $race_id)->get('sc_race_data');
		$handicap_function = $race->handicap_name . '_calc';

		foreach($race_data as &$entry){
			$entry->corrected_time = 0;
			if(intval($entry->elapsed_time) > 0){

				$entry->corrected_time =  $handicap_function($entry->elapsed_time, $entry->handicap);
				
			}
		}
		return $race_data;
	} // End function calculate_corrected


	/**
	 * Method to take the form data of a race, process it into a usable array and return it to the controller.
	 * Parameters:
	 *				int 	$race_id
	 *				This method pulls from the post variables
	 */
	function process_data($race_id){	
		
		$i=0;
		$race = $this->race_model->get($race_id);

		foreach($this->input->post('entry') as $entry){
			$race_data[$i] = new stdClass;
			$boat_ids[] = $race_data[$i]->boat_id = $this->input->post('entry_boat_id_'.$entry);
			$race_data[$i]->race_id = $race_id;
			$race_data[$i]->sail_number = $this->input->post('entry_sail_number_'.$entry);
					
			$x = $this->handicap_model->get_class_handicap($race_data[$i]->boat_id, $race->class_id);
			if($x == 0 OR $x == 0.00){
				$x = $this->handicap_model->get_boat_handicap($race_data[$i]->boat_id, $race->handicap_name);
				if($x == 0 OR $x == 0.00){
					$race_data[$i]->status = 'DSQ';
					$this->session->set_flashdata('err_message', $race_data[$i]->sail_number . ' Was disqualified because they did not have a handicap for this class');
				}
				$race_data[$i]->handicap = $x;
			}else{
				$race_data[$i]->handicap = $x;
			}

			if($this->input->post('finish_date_'.$entry) && $this->input->post('timer') == 'finishtime'){	
				$ft = trim($this->post('finish_date_'.$entry)) . ' ' . trim($this->input->post('finish_time_' . $entry));
				$race_data[$i]->finish_time = $ft;
				$race_data[$i]->elapsed_time = sc_elapsed_time($this->input->post('race_date') . ' ' . $this->input->post('race_time'), $ft);
				unset($ft);		
			}else{
				$race_data[$i]->finish_time = '';
				$race_data[$i]->elapsed_time = time2sec(trim($this->input->post('finish_time_'.$entry)));
			}
			$race_data[$i]->status = $this->input->post('entry_status_' . $entry);
			$i++;
		}
		
		$missing_boats = $this->race_model->get_missing_boats($boat_ids, $race_id);
		$total_boats = count($race_data) + count($missing_boats);
		$j = 0;
		for($i = count($race_data); $i < $total_boats ; $i++){
			$race_data[$i] = new stdClass;
			$race_data[$i]->boat_id = $missing_boats[$j]->id;
			$race_data[$i]->race_id = $race_id;
			$race_data[$i]->sail_number = $missing_boats[$j]->sail_number;
			$race_data[$i]->finish_time = 0;
			$race_data[$i]->elapsed_time = 0;
			$race_data[$i]->status = 'DNC';
			$j++;
		}

		return $race_data;
		/* $result = $this->db->insert_batch('sc_race_data', $race_data);
		if($result){
			$this->db->where('id' , $race_id);
			$this->db->update('sc_races', array('status' => 'completed'));
			return true;
		}else{
			return false;
		} */
	}

	function get_missing_boats($boat_ids, $race_id){
		$this->db->select('sc_boats.id, sc_boats.sail_number')->from('boats');
		$this->db->join('sc_class_boats', 'sc_class_boats.boat_id = sc_boats.id');
		$this->db->join('sc_classes', 'sc_classes.id = sc_class_boats.class_id');
		$this->db->join('sc_races', 'sc_races.class_id = sc_classes.id');
		$this->db->where('sc_races.id', $race_id);
		$this->db->where_not_in('sc_boats.id', $boat_ids);
		$query = $this->db->get();
		if($query->num_rows > 0){
			return $query->result();
		}else{
			return false;
		}
	}

	/**
	 * Method to take data submitted by the form and convert it to usable variables & objects
	 * This method does not commit anything to the database, it returns the race data in a standardised format
	 * Parameters:
	 *				string 	$string 		- A string of text given to a textarea field of sail numbers and finish times (or statuses)
	 *				array 	$args 			- An array of arguments passed straight to the boats_model->search_boats method
	 * Returns:
	 *				array 			
	 *						=> 	object 		$count		An object containing data about the number of boats found, not-found etc.
	 *						=>  array 		$race_data 	An array of objects with the parsed race data
	 *											
	 */
	function process_raw_data($string, $args){
		
		
		$total = 0;
		$not_found = 0;
		$found = 0;
		$matches = 0;

		// Split into lines
		$lines = preg_split( '/\r\n|\r|\n/', $string );
		// Split lines into Sail number, and  time
		$total = count($lines);
		$i = 0;
		foreach($lines as $l){
			$line_data = explode(',', $l);
			$this->race_data[$i] = new stdClass;
			$this->race_data[$i]->id = $i;
			$this->race_data[$i]->sail_number = trim($line_data[0]);
			$args['sail_number'] = $line_data[0];
 			
 			$boat = $this->boats_model->search_boats($args);
 			if($boat === false){
 				$not_found++;
 			}elseif(isset($boat->id)){
 				$found++;
 			}else{
 				$matches++;
 			}
 			$this->race_data[$i]->boat = $boat;			

			if(strpos($line_data[1], ':')){
				// This is a time value
				if(strpos($line_data[1], '/') OR strpos($line_data[1], '-')){
					$date_time = explode(' ', $line_data[1]);
					$this->race_data[$i]->date = $date_time[0];
					$this->race_data[$i]->time = $date_time[1];
					unset($date_time);
				}else{
					$this->race_data[$i]->time = trim($line_data[1]);
				}
				$this->race_data[$i]->status = false;
			}else{
				// This is not a time value. Assign it to the status field
				$this->race_data[$i]->time = false;
				$this->race_data[$i]->status = trim($line_data[1]);
			}

			$i++;
		}

		$count = new stdClass;
		$count->total = $total;
		$count->found = $found;
		$count->not_found = $not_found;
		$count->matches = $matches;

		return array(
					'count' => $count,
					'entries'=> $this->race_data
					);
	}

	/**
	* Create a race, or races
	*
	* Parameters: $name: Array or String
	* 			$class_id: integer
	**/
	function initialise_races($name, $class_id, $races_to_create){
		

		$num_races = $this->db->where('class_id', $class_id)->count_all_results('sc_races');
		$class = $this->classes_model->get($class_id);
		if($num_races + $races_to_create < $this->config->item('sc_class_max_races')){

		}else{
			$overflow = $this->config->item('sc_class_max_races') - $num_races + $races_to_create;
			$races_to_create = $races_to_create - $overflow;
		}
		if($races_to_create > 0){
			for($i=1; $i<=$races_to_create; $i++){
				$races[] = array(
							'name' => $name ." $i",
							'start_date' => time(),
							'class_id' => $class_id,
							'discard' => ($class->discards > 0) ? 1 : 0
						);
			}
			$this->db->insert_batch('sc_races', $races);
		}
	}

	function get_field($field, $id){
		$this->db->select($field);
		$this->db->from('sc_races')->where('id', $id);
		$query = $this->db->get();
		if($query->num_rows() > 0)
			return $query->first_row();
	}

	function update_field($field, $data, $id, $type='text'){
		
		$this->db->where('id', $id);
		$this->db->update('sc_races', array($field => $data));
		// Finally update the class status because the reace info has changed.
		$this->classes_model->update_status(array('race_id' => $id), 'modified');
	}

	function get_parent($race_id){
			$this->db->select('classes.id, classes.name');
			$this->db->from('classes');
			$this->db->join('races', 'races.class_id = classes.id');
			$this->db->where('races.id', $race_id);
			$query = $this->db->get();
			if($query->num_rows()){
				return $query->first_row();
			}
		}

}
?>