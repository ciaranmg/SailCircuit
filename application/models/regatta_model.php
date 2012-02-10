<?
class Regatta_model extends CI_Model{
		
		function insert($regatta_data) {
			$this->db->insert('sc_regattas', $regatta_data);
			$x = $this->db->insert_id();
			// $this->firephp->log($this->db->last_query());
			return $x;
		}
		
		function get($id){
			$this->db->from('sc_regattas')->where('id', $id);
			$query = $this->db->get();
			if($query->num_rows() > 0)
				return $query->row();
		}
		
		function get_field($field, $id){
			$this->db->select($field);
			$this->db->from('sc_regattas')->where('id', $id);
			$query = $this->db->get();
			if($query->num_rows() > 0)
				return $query->first_row();
		}
		
		function update(){
		
		}
		
		function delete(){
		
		}
		
		function get_regattas($club_id=null){		
			// Todo: Pagination & Sorting
			$this->db->select('sc_regattas.id, sc_regattas.name, sc_regattas.description, sc_regattas.start_date, sc_regattas.club_id');
			$this->db->from('sc_regattas');
			if($club_id) {
				$this->db->where('club_id', $club_id);
			}else{
				$this->db->join('sc_clubs', 'sc_clubs.id = sc_regattas.club_id');
				$this->db->select('sc_clubs.club_name');
			}
			$this->db->order_by('start_date', 'DESC');
			$query = $this->db->get();
			
			return $query->result();
			
		}
		
		function get_parent_regatta($class_id){
			$this->db->select('sc_regattas.id, sc_regattas.name');
			$this->db->from('sc_regattas');
			$this->db->join('sc_classes', 'sc_classes.regatta_id = sc_regattas.id');
			$this->db->where('sc_classes.id', $class_id);
			$query = $this->db->get();
			if($query->num_rows()){
				return $query->first_row();
			}
		}
		
		function update_field($field, $data, $id, $type){
			if($type == 'date' OR $type == 'datetime'){
				$data = strtotime($data);
			}
			$parameters = array(
								$field => $data
								);
			$this->db->where('id', $id);
			$this->db->update('sc_regattas', $parameters);	
		}
		
}

?>