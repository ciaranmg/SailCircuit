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
		
		/**
		 * Function to delete regattas based on regatta_id
		 * Also deletes regatta meta data
		 */
		function delete($regatta_id){
			$this->db->where('id', $regatta_id);
			$x = $this->db->delete('sc_regattas');

			$this->db->where('regatta_id', $regatta_id);
			$this->db->delete('sc_regatta_meta');

			return $x;
		}
		
		function get_regattas($club_id=null, $criteria = null){
			
			// Todo: Pagination & Sorting
			$this->db->select('sc_regattas.id, 
								sc_regattas.name, 
								sc_regattas.description, 
								sc_regattas.start_date, 
								coalesce(count(sc_classes.id)) as classes,
								sc_regattas.club_id');
			$this->db->from('sc_regattas');
			$this->db->join('sc_classes', 'sc_regattas.id = sc_classes.regatta_id', 'left');
			if($club_id) {
				$this->db->where('club_id', $club_id);
			}else{
				$this->db->join('sc_clubs', 'sc_clubs.id = sc_regattas.club_id');
				$this->db->select('sc_clubs.club_name');
			}
			if(isset($criteria['active'])){
				$this->db->where('end_date >', time());
			}
			$this->db->order_by('start_date', 'DESC');
			$this->db->group_by('sc_regattas.id');
			$query = $this->db->get();
			$this->firephp->log($this->db->last_query());
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