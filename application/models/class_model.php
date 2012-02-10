<?

class Class_model extends CI_Model {
	
	function insert($class_data){
		$this->db->insert('sc_classes', $class_data);
			$x = $this->db->insert_id();
			// $this->firephp->log($this->db->last_query());
			return $x;
	}
	
	function get_classes($regatta_id){
		$this->db->select('sc_classes.id, sc_classes.race_count, sc_classes.name, sc_classes.description, sc_classes.system_id');
		$this->db->select('sc_handicap_systems.name AS system_name');
		$this->db->from('sc_classes');
		$this->db->where('regatta_id', $regatta_id);
		$this->db->join('sc_handicap_systems', 'sc_handicap_systems.id = sc_classes.rating_system_id');
		$this->db->where('sc_classes.status', 'active');
		
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}
	}
	
	function get($class_id){
		$this->db->from('sc_classes')->where('id', $class_id);
		$query= $this->db->get();
		if($query->num_rows() > 0) return $query->first_row();
	}

}