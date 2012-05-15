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

	function get_boat_handicap($boat_id, $name){
		$this->load->model('boats_model');
		if($name == 'Level Rating'){
			return 1;
		}else{
			$handicap = $this->boats_model->get_boat_meta($boat_id, $name);
			if($handicap === false){
				return 0.00;
			}else{
				return $handicap;
			}
		}
	}
}
?>