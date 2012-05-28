<?
class Scoring_model extends CI_Model{

	function get($system_id){
		$query = $this->db->where('id', $system_id)->limit(1)->get('scoring_systems');
		if($query->num_rows() >0){
			$system = $query->first_row();
			// Some data is json encoded so we'll extract that before returning it.		
			$system->rules = json_decode($system->rules);

			return $system;

		}else{
			return false;
		}
	}
}
?>