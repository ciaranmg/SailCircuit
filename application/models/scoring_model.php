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

	function get_tiebreakers($tiebreaker_id){
		$query = $this->db->where('id', $tiebreaker_id)->limit(1)->get('series_ties');
		if($query->num_rows() > 0){
			$tb = $query->row();
			$tb->rules = json_decode($tb->rules);
			return $tb;
		}else{
			return false;
		}
	}


	function get_scoring_systems(){
		$this->db->from('sc_scoring_systems')->where('club_id', 0)->or_where('club_id', $this->session->userdata['club_id'])->order_by('name', 'asc');
		$query = $this->db->get();
		if($query->num_rows() >0){
			$result = $query->result();
			foreach ($result as &$r) {
				$r->rules = json_decode($r->rules);
			}
			return $result;
		}else{
			return false;
		}
	}
}
?>