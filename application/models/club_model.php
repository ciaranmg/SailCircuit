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

	function retrieve(){
		
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
		$this->db->join('sc_regattas', 'sc_regattas.club_id = sc_clubs.id');
		
		if($child_type == 'race'){
			$this->db->join('sc_classes', 'sc_classes.regatta_id = sc_regattas.id', 'left');
			$this->db->join('sc_races', 'sc_races.class_id = sc_classes.id', 'left');
			$this->db->where('sc_races.id', $child_id);
		}elseif($child_type =='class'){
			$this->db->join('sc_classes', 'sc_classes.regatta_id = sc_regattas.id', 'left');
			$this->db->where('sc_classes.id', $child_id, false);
		}elseif($child_type =='regatta'){
			$this->db->where('sc_regattas.id', $child_id, false);
			
		}
		
		$query = $this->db->get();
		// $this->firephp->log($query);
		// $this->firephp->log($this->db->last_query());
		$row = $query->row();
		return $row->id;
		
	}
}
?>