<?
class classes_model extends CI_Model {
	

	function get_class_table($class_id){
		
		

		$class_boats = $this->boats_model->get_class_boats($class_id);
		if($class_boats){
			foreach($class_boats as &$b){
				$this->db->select('SUM(IF(discarded = 0, points, 0)) as series_points', false);
				$this->db->from('race_results');
				$this->db->join('races', 'races.id = race_results.race_id');
				$this->db->where('races.status', 'completed');
				$this->db->where('races.class_id', $class_id);
				$this->db->where('race_results.boat_id', $b->id);
				$query = $this->db->get();

				if($query->num_rows() > 0 ){
					$x = $query->row();
					$b->series_points = $x->series_points;
					
				}
				$query->free_result();

				$this->db->select('points, position, discarded, sc_races.name', false);
				$this->db->from('race_results');
				$this->db->join('races', 'races.id = race_results.race_id');
				$this->db->where('races.status', 'completed');
				$this->db->where('races.class_id', $class_id);
				$this->db->where('race_results.boat_id', $b->id);
				$this->db->order_by('races.start_date', 'asc');
				$query = $this->db->get();
				if($query->num_rows() >0){
					$b->race_results = $query->result();
				}else{
					$b->race_results = false;
				}
				$query->free_result();
			}
			return $class_boats;
		}else{
			return false;
		}
	}
	/**
	 * Method to apply discards to races given a class_id
	 * Iterates through each boat in the class and discards the worst result. Provided:
	 *			1. The class has discards
	 *			2. The minimum number of races for discards has been run
	 *			
	 */
	function apply_discards($class_id){
			
			

			// First clear the discards so we can apply them fresh.
			$this->race_model->clear_discards($class_id);

			// Get the class. We'll need this to know how many discards we can apply
			$class = $this->classes_model->get($class_id);
			
			$discardable_races = $this->race_model->get_discardable_races($class_id);

			if(count($discardable_races) >= $class->min_races_discard){
				$class_boats = $this->boats_model->get_class_boats($class_id);	
				$non_discardable_status = $this->config->item('sc_non_discardable');

				foreach($class_boats as $boat){
					$this->db->set('discarded', 1);
					$this->db->where('boat_id', $boat->id);
					$this->db->where_in('race_id', $discardable_races);
					$this->db->where_not_in('status', $non_discardable_status);
					$this->db->order_by('points', 'DESC');
					$this->db->limit($class->discards);
					$this->db->update('race_results');
				}
			}
	}

	/**
	 *  Method to insert class data into the database
	 */
	function insert($class_data){
		$this->db->insert('sc_classes', $class_data);
			$x = $this->db->insert_id();
			// $this->firephp->log($this->db->last_query());
			return $x;
	}

	/**
	 * Function to delete class based on class_id
	 * Also deletes meta data associated with a class
	 */
	function delete($class_id){
			
			//$this->db->where('class_id', $id)->delete('sc_class_boats');

			$this->db->where('id', $class_id);
			$x = $this->db->delete('sc_classes');

			$this->db->where('class_id', $class_id);
			$this->db->delete('sc_class_meta');

			return $x;
	}
	
	function get_classes($regatta_id){
		$this->db->select('sc_classes.id,  
							sc_classes.name, 
							sc_classes.description,
							sc_classes.discards,
							sc_classes.min_races_discard, 
							coalesce(count(sc_races.id)) as race_count, 
							sc_classes.scoring_system, 
							sc_classes.regatta_id');
		$this->db->select('sc_handicap_systems.name AS system_name');
		$this->db->from('sc_classes');
		$this->db->where('regatta_id', $regatta_id);
		$this->db->join('sc_races', 'sc_classes.id = sc_races.class_id', 'left');
		$this->db->join('sc_handicap_systems', 'sc_handicap_systems.id = sc_classes.rating_system_id');
		$this->db->order_by('sc_classes.name', 'asc');
		$this->db->group_by('sc_classes.id');
		$query = $this->db->get();
		$this->firephp->log($this->db->last_query());
		if($query->num_rows() > 0){
			return $query->result();
		}
	}

	/**
	 * Function to get the options for a dropdown list of classes given a regatta_id
	 */
	public function get_classes_dropdown($regatta_id){
		$query = $this->db->select('id, name')->from('sc_classes')->where('regatta_id', $regatta_id)->get();
		$classes_list[] = array('value' => 0, 'display' => 'Choose One');
		if($query->num_rows() > 0){
			foreach($query->result() as $r){
				$classes_list[] = array('value' => $r->id, 'display' => $r->name);
			}
		}
		return $classes_list;
	}
	
	function get($class_id){
		

		$this->db->select('sc_classes.id, 
				sc_classes.name,
				coalesce(count(sc_races.id)) as race_count, 
				sc_classes.description, 
				sc_classes.discards, 
				sc_classes.min_races_discard,
				sc_classes.status,
				sc_scoring_systems.name as scoring_name, 
				sc_scoring_systems.id as scoring_id, 
				sc_series_ties.name as ties_name, 
				sc_series_ties.id as ties_id, 
				sc_handicap_systems.name handicap_name,
				sc_handicap_systems.id as handicap_id,
				sc_classes.regatta_id');
		$this->db->from('sc_classes');
		$this->db->join('sc_races', 'sc_classes.id = sc_races.class_id', 'left');
		$this->db->join('sc_scoring_systems', 'sc_scoring_systems.id = sc_classes.scoring_system');
		$this->db->join('sc_series_ties', 'sc_series_ties.id = sc_classes.tiebreak_system');
		$this->db->join('sc_handicap_systems', 'sc_handicap_systems.id = sc_classes.rating_system_id');
		$this->db->where('sc_classes.id', $class_id);
		$query = $this->db->get();
		if($query->num_rows() > 0) {
			$class = $query->first_row();
			$class->scoring_system = $this->scoring_model->get($class->scoring_id);
			return $class;
		}else{
			return false;
		}
	}

	function get_tiebreakers(){
		$this->db->from('sc_series_ties')->where('club_id', 0)->or_where('club_id', $this->session->userdata['club_id'])->order_by('name', "asc");
		$query = $this->db->get();
		//$this->firephp->log($this->db->last_query());
			if($query->num_rows() > 0) return $query->result();
	}


	function get_field($field, $id){
		if($field == "handicap"){
			$query = $this->db->select('handicap')->from('sc_class_boats')->where('id',$id)->get();
		}else{
			$this->db->select($field);		
			$this->db->from('sc_classes')->where('id', $id);
			$query = $this->db->get();
		}
			if($query->num_rows() > 0)
				return $query->first_row();
	}

	function update_field($field, $data, $id, $type = null){
		if($type == 'date' OR $type == 'datetime'){
			$data = sc_strtotime($data);
		}

		$parameters = array($field => $data);

		if($field == 'handicap'){
			$this->db->where('id' , $id);
			$this->db->update('sc_class_boats', $parameters);
		}else{
			$this->db->where('id', $id);
			$this->db->update('sc_classes', $parameters);	
		}
	}

	function set_class_boats($boats, $class_id){
		foreach($boats as &$b){
			$b['class_id'] = $class_id;
		}
		$this->db->insert_batch('sc_class_boats', $boats);
	}

	function update_class_boats($class_id, $boats){
		// 1. Get all the current class boats. We'll need the handicap data later.
		// 2. Get the boat data for the boats_in form field
		// 3. If a boat was already in the class, then update the boat data with the existing handicap value
		// 3a. If not just double check that the user is allowed to use that boat.
		// 3b. If not, add the boat to race results for completed races.
		// 4. Clear all boats from the class
		// 5. Add the boats from #2 to the class

		if(!is_integer($class_id) AND !is_array($boats)) return false;
		
		// Get handicap name
		$this->db->select('sc_handicap_systems.name');
		$this->db->from('sc_handicap_systems');
		$this->db->join('sc_classes', 'sc_classes.rating_system_id = sc_handicap_systems.id');
		$this->db->where('sc_classes.id', $class_id);
		$query = $this->db->get();

		if($query->num_rows() > 0){
			$result = $query->first_row();
			$handicap_name = $result->name;
		}else{
			$this->firephp->log('No handicap name found');
		}

		$query = $this->db->get_where('sc_class_boats', array('class_id'=>$class_id));
		if($query->num_rows() > 0){
			$class_boats = $query->result();
			foreach($class_boats as $cb){
				$temp[$cb->boat_id] = new stdClass;
				$temp[$cb->boat_id]->id = $cb->id;
				$temp[$cb->boat_id]->handicap = $cb->handicap;
				$temp[$cb->boat_id]->boat_id = $cb->boat_id;
			}
			$class_boats = $temp;
		}
		// This array will be populated with all the boats the class should have
		$update_class_boats = array();
		// This will be populated with all the boats that are new to the class so we can process the races 
		$new_class_boats = array();

		foreach($boats as $boat_id){
			$update_class_boats[$boat_id]['class_id'] = $class_id;
			$update_class_boats[$boat_id]['boat_id'] = $boat_id;
			if(isset($class_boats[$boat_id])){
				// Use the existing handicap
				$update_class_boats[$boat_id]['handicap'] = $class_boats[$boat_id]->handicap;
				// Unset an entry that's already there so that we'll be left with old values that no longer belong
				unset($class_boats[$boat_id]); 
			}else{
				$handicap = $this->handicap_model->get_boat_handicap($boat_id, $handicap_name);
				$update_class_boats[$boat_id]['handicap'] = $handicap;
				$new_class_boats[$boat_id] = array('boat_id' => $boat_id, 'handicap'=> $handicap, 'class_id' => $class_id, 'status' => 'DNC');
			}
		}
		$remove_class_boats = $class_boats;
		// Remove the existing record of class boats
		$this->db->delete('class_boats', array('class_id' => $class_id));
		$this->db->insert_batch('class_boats', $update_class_boats);

		return array('remove_class_boats'=> $remove_class_boats, 'new_class_boats' => $new_class_boats);
	}

	/**
	 * function to change the status of a class.
	 * If races, or class rules are changed then the status needs to be flagged so 
	 * the user knows that a refresh is needed to cascade those changes down to the results.
	 * 
	 * Parameters: $change_object		array
	 *										'race_id' =>
	 * 								OR		'class_id' =>
	 *				$status 			string
	 *									'modified', or active, or other string to denote the status of the class
	 */
	function update_status($change_object, $status = 'modified'){
		extract($change_object);
		
		if(isset($race_id)){
			$query = $this->db->select('class_id')->where('sc_races.id', $race_id)->get('sc_races');
			if($query->num_rows() >0){
				$x = $query->first_row();
				$class_id = $x->class_id;
			}
		}
		$this->db->where('id', $class_id);
		$this->db->update('sc_classes', array('status' => $status));
	}

	function get_parent($class_id){
			$this->db->select('sc_regattas.id, sc_regattas.name');
			$this->db->from('sc_regattas');
			$this->db->join('sc_classes', 'sc_classes.regatta_id = sc_regattas.id');
			$this->db->where('sc_classes.id', $class_id);
			$query = $this->db->get();
			if($query->num_rows()){
				return $query->first_row();
			}
		}
}