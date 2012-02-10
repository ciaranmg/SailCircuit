<?

class Boat_model extends CI_Model {


	function insert($boatData) {
			$this->db->insert('sc_boats', $boatData);
			$this->firephp->log($this->db->last_query()); 
			$x = $this->db->insert_id();
			return $x;
	}
	
	
	function get($id){
		$this->load->database();
		$result = $this->db->get_where('sc_boats', array('id' => $id));
		if($result->num_rows() > 0){
			return $result->row();
			
		}
	}
	
	function set_boat_owner($boat_id, $owner_id){
		$this->db->insert('sc_boat_owners', array('owner_id'=>$owner_id, 'boat_id' => $boat_id));
		if($this->db->insert_id()) return true;
	}
	
	function get_boat_owners($boat_id){
		$this->db->select('owner_id')->from('sc_boat_owners')->where('boat_id', $boat_id);
		$query = $this->db->get();
		$this->firephp->log($this->db->last_query());
		if($query->num_rows() > 0){
			return $query->result();
		}
	}
	
	function set_club_boat($club_id, $boat_id){
		$this->db->insert('sc_club_boats', array('club_id'=>$club_id, 'boat_id'=> $boat_id));
		return true;
	}
	
	
	function get_by_sail_number($sailNumber) {
		$this->load->database();
		$result = $this->db->get_where('sc_boats', array('sail_number' => $sailNumber));
		if($result->num_rows() > 0){
			$row = $result->row();
			return $this->boat_model->retrieve($row->id);
		}else{
			return false;
		}
	}
	
	function get_boats($args=null){
		$this->db->select('sc_boats.id, sc_boats.name, model, sail_number, coalesce(group_concat(sc_owners.name SEPARATOR \', \'), \' \') as owner ', FALSE);
		$this->db->from('sc_boats');
		$this->db->join('sc_boat_owners', 'sc_boats.id = sc_boat_owners.boat_id', 'left');
		$this->db->join('sc_owners', 'sc_boat_owners.owner_id = sc_owners.id', 'left');
		if ($args){
			foreach($args as $key => $value){
				switch($key){
					case 'club_id':
						$this->db->join('sc_club_boats', 'sc_club_boats.boat_id = sc_boats.id', 'left');
						$this->db->join('sc_clubs', 'sc_clubs.id = sc_club_boats.club_id', 'left');
						$this->db->where('sc_clubs.id', $value);
					break;
					
					case 'owner_id':
						$this->db->where('sc_owners.owner_id', $value);
					break;
					
					case 'class_id':
						$this->db->join('sc_class_boats', 'sc_class_boats.boat_id = sc_boats.id', 'left');
						$this->db->where('sc_class_boats.class_id', $value);
					break;
					
					case 'regatta_id':
						$this->db->join('sc_class_boats', 'sc_class_boats.boats_id = sc_boats.id', 'left');
						$this->db->join('sc_classes', 'sc_classes.id = sc_class_boats.class_id', 'left');
						$this->db->where('sc_classes.regatta_id', $value);
					break;
					
					case 'race_id':
						$this->db->join('sc_race_data', 'sc_race_data.boat_id = sc_boats.id', 'left');
						$this->db->where('sc_race_data.race_id', $value);
					break;
				}
			}			
		}
		$this->db->group_by('sc_boats.id');
		//Todo: Pagination
		
		$query = $this->db->get();
		$this->firephp->log($this->db->last_query());
		if($query->num_rows()>0)
		{
			return $query->result();
		}
	}
	
	function update(){
	
	}
	
	function delete(){
	
	}
}
?>