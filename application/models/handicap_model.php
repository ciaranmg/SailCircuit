<?
// CI model for handicap systems
class Handicap_model extends CI_Model {

	// Function to update the handicap of a boat within a class. 
	// Also calls special processor functions for specific handicaps
	function update_class_boat($class_id, $row_id, $data){
		
	}

	// Function to get all current handicap systems
	function get_handicaps(){
		$this->db->select('*')->from('sc_handicap_systems')->order_by('name', 'asc');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}
	}

	function get($id){
		$query = $this->db->select()->from('sc_handicap_systems')->where('id', $id)->get();
		if($query->num_rows() > 0){
			return $query->row();
		}else{
			return false;
		}
	}

	/**
	 * Method to get the boat handicap for a given class
	 */
	function get_class_handicap($boat_id, $class_id){
		$this->db->select('sc_class_boats.handicap')->from('sc_class_boats')->where('boat_id', $boat_id)->where('class_id', $class_id)->limit(1);
		$query = $this->db->get();
		if($query->num_rows() >0 ){
			$x = $query->first_row();
			$x->handicap;
			return $x->handicap;
		}else{
			return 0.00;
		}
	}

	function get_boat_handicaps($boat_id){
		$this->db->select('sc_boat_meta.field as name, sc_boat_meta.value, sc_boat_meta.boat_id, sc_boat_meta.id');
		$this->db->from('sc_boat_meta');
		$this->db->join('sc_handicap_systems', 'sc_handicap_systems.name = sc_boat_meta.field');
		$this->db->where('sc_boat_meta.boat_id', $boat_id);
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}

	}

	function get_boat_handicap($boat_id, $handicap_name){
		
		if($handicap_name == 'Level Rating'){
			return 1;
		}else{
			$handicap = $this->boats_model->get_boat_meta($boat_id, $handicap_name);
			if($handicap === false){
				return 0.00;
			}else{
				return $handicap->value;
			}
		}
	}
}
?>