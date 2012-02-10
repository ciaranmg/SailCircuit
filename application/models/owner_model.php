<?
class Owner_model extends CI_Model{

	function insert($ownerData){
		$this->db->insert('sc_owners', $ownerData);
		$x = $this->db->insert_id();
		return $x;
	}
	
	function get($owner_id){
	
		$this->db->from('sc_owners');
		$this->db->where('id', $owner_id);
		$query = $this->db->get();
		
		return $query->row();
	}
	
	function get_owners($owners){
		$owner_array = array();
		foreach($owners as $o){
			$owner_array[] = $o->owner_id;
			
		}
		// $this->firephp->log($owner_array);
		$this->db->from('sc_owners')->where_in('id', $owner_array);
		$query = $this->db->get();
		$this->firephp->log($this->db->last_query()); 
		return $query->result();
	}
}