<? 
class Club_model extends CI_Model{
	
	function create($clubData){
		$this->load->database();
		
		if($clubData['valid'] === true){
			unset($clubData['valid']);
			if($x === true){
				return $this->db->insert_id();
			}else{
				return false;
			}
			
		}else{
			return false;
		}
	}

	function get($club_id){
		$query = $this->db->get_where('clubs', array('id' => $club_id));
		if($query->num_rows() > 0){
			return $query->first_row();
		}
	}
	
	function update(){
	
	}
	
	function delete(){
	
	}
	
	
	function link_user_club($userID, $clubID, $role){
		$data = array(
						'user_id' => $userID,
						'club_id' => $clubID,
						'role' => $role
						);
		$x = $this->db->insert('sc_club_users', $data);
		if($x === true){
			return true;
		}else{
			return false;
		}
	}
	
	function get_parent_club($child_type, $child_id){
		// $this->firephp->log('get_parent_club');
		$this->db->select('sc_clubs.id', false);
		$this->db->from('sc_clubs');
		
		if($child_type == 'race'){
			$this->db->join('sc_regattas', 'sc_regattas.club_id = sc_clubs.id');
			$this->db->join('sc_classes', 'sc_classes.regatta_id = sc_regattas.id', 'left');
			$this->db->join('sc_races', 'sc_races.class_id = sc_classes.id', 'left');
			$this->db->where('sc_races.id', $child_id);
		}elseif($child_type =='class'){
			$this->db->join('sc_regattas', 'sc_regattas.club_id = sc_clubs.id');
			$this->db->join('sc_classes', 'sc_classes.regatta_id = sc_regattas.id', 'left');
			$this->db->where('sc_classes.id', $child_id, false);
		}elseif($child_type =='regatta'){
			$this->db->join('sc_regattas', 'sc_regattas.club_id = sc_clubs.id');
			$this->db->where('sc_regattas.id', $child_id, false);
		}elseif($child_type == 'boat'){
			$this->db->join('sc_club_boats', 'sc_club_boats.club_id = sc_clubs.id');
			$this->db->join('sc_boats', 'sc_boats.id = sc_club_boats.boat_id');
			$this->db->where('sc_boats.id', $child_id, false);
		}
		
		$query = $this->db->get();
		// $this->firephp->log($query);
		// $this->firephp->log($this->db->last_query());
		if($query->num_rows() == 0) return 0;
		$row = $query->row();
		return $row->id;
		
	}
}
?>