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

	function PY_calc($elapsed, $handicap){
	// Function to _calculate the corrected time based on RYA PY handicap
	// Parameters: 	$elapsed
	//				Type: integer, number of seconds of elapsed time
	// 				$handicap
	//				Type: float, the RYA PY handicap value
	// Returns:		integer, number of seconds of corrected time

		if(is_int($elapsed) && is_int($handicap)){
				$tcc = round($elapsed * 1000 / $handicap, 0);
				return $tcc;
			} else {
				error_log('Invalid data types supplied to PY_calc');
				return false;
			}
	}

	function ECHO_calc($elapsed, $handicap){
	// Function to calculate the corrected time based on ECHO handicap
	// Parameters: 	$elapsed
	//				Type: integer, number of seconds of elapsed time
	// 				$handicap
	//				Type: float, the ECHO handicap value
	// Returns:		integer, number of seconds of corrected time

		if(is_int($elapsed) && is_float($handicap)){
				$tcc = round($elapsed * $handicap, 0);
				return $tcc;
			} else {
				error_log('Invalid data types supplied to ECHO_calc');
				return false;
			}
	}

	function IRC_calc($elapsed, $handicap){
	// Function to calculate the corrected time based on IRC handicap
	// Parameters: 	$elapsed
	//				Type: integer, number of seconds of elapsed time
	// 				$handicap
	//				Type: float, the IRC handicap value
	// Returns:		integer, number of seconds of corrected time

		if(is_int($elapsed) && is_float($handicap)){
				$tcc = round($elapsed * $handicap, 0);
				return $tcc;
			} else {
				error_log('Invalid data types supplied to IRC_calc');
				return false;
			}
	}

	// Function to calculate for level timed races
	// Parameters: 	$elapsed
	//				Type: integer, number of seconds of elapsed time
	// 				$handicap
	//				Type: This is ignored anyway.
	// Returns:		integer, number of seconds of corrected time
	function Level_calc($elapsed, $handicap){
		return $elapsed;
	}
}
?>