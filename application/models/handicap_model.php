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
}
?>