<?
class Race_model extends CI_Model{
	
	
	function get_races($class_id){
		$this->db->from('sc_races')->where('class_id', $class_id);
		$this->db->order_by('start_date','asc');
		$this->db->order_by('id', 'asc');
		$this->db->order_by('name', 'asc');
		$query = $this->db->get();
		if($query->num_rows() > 0) {
			$this->firephp->log($query->result());
			return $query->result();
		}else{
			$this->firephp->log('or here');
			return false;
		}
	}
	
	
	/*----------------------------------------------------------------------------
	Description: Create a race, or races
	
	Parameters: $name: Array or String
				$class_id: integer
	----------------------------------------------------------------------------*/
	function create_race_framework($name, $class_id){
		if(is_array($name)){
			$races = array();		
			$i = 1;
			
			foreach($name as $n){	
				$races[] = array(
									'name' => $n ." $i",
									'start_date' => sc_php2db_timestamp(time()),
									'class_id' => $class_id
								);
				$i++;
			}
			$this->db->insert_batch('sc_races', $races);
		}else{
			$this->insert('sc_races', array('class_id'=> $class_id, 'start_date' => sc_php2db_timestamp(time()),  'name' => $name));
			$x = $this->db->insert_id();
			if($x) return $x;
		}
	}
}
?>