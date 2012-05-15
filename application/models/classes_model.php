<?
class classes_model extends CI_Model {
	
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
		$this->db->select('sc_classes.id, sc_classes.race_count, sc_classes.name, sc_classes.description, sc_classes.scoring_system');
		$this->db->select('sc_handicap_systems.name AS system_name');
		$this->db->from('sc_classes');
		$this->db->where('regatta_id', $regatta_id);
		$this->db->join('sc_handicap_systems', 'sc_handicap_systems.id = sc_classes.rating_system_id');
		$this->db->where('sc_classes.status', 'active');
		
		$query = $this->db->get();
		$this->firephp->log($this->db->last_query());
		if($query->num_rows() > 0){
			return $query->result();
		}
	}
	
	function get($class_id){
		$this->db->select('sc_classes.id, 
				sc_classes.race_count, 
				sc_classes.name, 
				sc_classes.description, 
				sc_classes.discards, 
				sc_scoring_systems.name as scoring_name, 
				sc_scoring_systems.id as scoring_id, 
				sc_series_ties.name as ties_name, 
				sc_series_ties.id as ties_id, 
				sc_handicap_systems.name handicap_name, 
				sc_handicap_systems.id as handicap_id');
		$this->db->from('sc_classes');
		$this->db->join('sc_scoring_systems', 'sc_scoring_systems.id = sc_classes.scoring_system');
		$this->db->join('sc_series_ties', 'sc_series_ties.id = sc_classes.tiebreak_system');
		$this->db->join('sc_handicap_systems', 'sc_handicap_systems.id = sc_classes.rating_system_id');
		$this->db->where('sc_classes.id', $class_id);
		$query = $this->db->get();
		if($query->num_rows() > 0) {
			$this->firephp->log($query->first_row());
			return $query->first_row();
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

	function get_scoring_systems(){
		$this->db->from('sc_scoring_systems')->where('club_id', 0)->or_where('club_id', $this->session->userdata['club_id'])->order_by('name', 'asc');
		$query = $this->db->get();
		require_once APPPATH.'libraries/data_objects.class.php';
		// $this->firephp->log($this->db->last_query());
		if($query->num_rows() >0){
			foreach($query->result() as $row){
				$scoring_systems[] = new scoring_system($row);
			}

			return $scoring_systems;	
		}
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

	function update_field($field, $data, $id, $type){
		if($type == 'date' OR $type == 'datetime'){
			$data = strtotime($data);
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

}