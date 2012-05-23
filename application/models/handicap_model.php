<?
// CI model for handicap systems
class Handicap_model extends CI_Model {
	
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

	function get_boat_handicap($boat_id, $name){
		$this->load->model('boats_model');
		if($name == 'Level Rating'){
			return 1;
		}else{
			$handicap = $this->boats_model->get_boat_meta($boat_id, $name);
			if($handicap === false){
				return 0.00;
			}else{
				return $handicap->value;
			}
		}
	}
}
?>