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
	

	function get_field($field, $id){
		$this->db->select($field);
		$this->db->from('sc_owners')->where('id', $id);
		$query = $this->db->get();
		if($query->num_rows() > 0)
			return $query->first_row();
	}

	function update_field($field, $data, $id, $type){
		if($type == 'date' OR $type == 'datetime'){
			$data = strtotime($data);
		}
		$parameters = array(
							$field => $data
							);
		$this->db->where('id', $id);
		$this->db->update('sc_owners', $parameters);	
	}

	function delete_owner($id){
		$this->db->where('id', $id)->delete('sc_owners');
	}
}