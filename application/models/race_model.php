<?
class Race_model extends CI_Model{
	
	
	function get_races($class_id){
		$this->db->from('sc_races')->where('class_id', $class_id);
		$this->db->order_by('start_date','asc');
		$this->db->order_by('id', 'asc');
		$this->db->order_by('name', 'asc');
		$query = $this->db->get();
		if($query->num_rows() > 0) {
			// $this->firephp->log($query->result());
			return $query->result();
		}else{
			// $this->firephp->log('or here');
			return false;
		}
	}
	

	/**
	 *	Method to delete races given a race_id
	 *  Also deletes meta data associated with Race
	 */
	function delete_races($id){
		if(is_array($id)){
			$this->db->where_in('id', $id);
		}else{
			$this->db->where('id', $id);
		}
		$this->db->delete('sc_races');
	}


	/*----------------------------------------------------------------------------
	Description: Create a race, or races
	
	Parameters: $name: Array or String
				$class_id: integer
	----------------------------------------------------------------------------*/
	function create_race_framework($name, $class_id, $discards = 0){
		if(is_array($name)){
			$races = array();		
			$i = 1;
		
			foreach($name as $n){	
				$races[] = array(
							'name' => $n ." $i",
							'start_date' => time(),
							'class_id' => $class_id,
							'discard' => ($discards > 0) ? 1 : 0
						);
				$i++;
			}
			$this->db->insert_batch('sc_races', $races);
		}else{
			$this->insert('sc_races', array('class_id'=> $class_id, 'start_date' => time(),  'name' => $name));
			$x = $this->db->insert_id();
			if($x) return $x;
		}
	}

	function get_field($field, $id){
		$this->db->select($field);
		$this->db->from('sc_races')->where('id', $id);
		$query = $this->db->get();
		if($query->num_rows() > 0)
			return $query->first_row();
	}

	function update_field($field, $data, $id, $type){
		$this->load->model('classes_model');
		$this->db->where('id', $id);
		$this->db->update('sc_races', array($field => $data));
		// Finally update the class status because the reace info has changed.
		$this->classes_model->update_status(array('race_id' => $id), 'modified');
	}

}
?>