<?
class boats_model extends CI_Model {

	function insert($boatData, $club_id) {
			$this->db->insert('sc_boats', $boatData); 
			$x = $this->db->insert_id();
			$this->boats_model->set_club_boat($club_id, $x);
			
			return $x;
	}	
	
	function get($id){
		$result = $this->db->get_where('sc_boats', array('id' => $id));
		if($result->num_rows() > 0){
			return $result->row();
		}else{
			return false;
		}
	}
	
	function set_boat_owner($boat_id, $owner_id){
		$this->db->insert('sc_boat_owners', array('owner_id'=>$owner_id, 'boat_id' => $boat_id));
		if($this->db->insert_id()) return true;
	}
	
	function set_club_boat($club_id, $boat_id){
		$this->db->insert('sc_club_boats', array('club_id'=>$club_id, 'boat_id'=> $boat_id));
		return true;
	}
	

	/**
	 * 	Method to search for boats given various different parameters
	 *	Parameters:
	 *				array $args
	 *	Returns:
	 *				object 
	 *						->id
	 *						->name
	 *			OR
	 *				array objects 	
	 *						->id
	 *						->name
	 */
	function search_boats($args){
		$this->db->select('sc_boats.id, sc_boats.name, sc_boats.sail_number')->from('sc_boats');

		if($args){
			
			foreach($args as $key => $value){
				switch($key){
					case 'club_id':
						$this->db->join('sc_club_boats', 'sc_club_boats.boat_id = sc_boats.id', 'left');
						$this->db->join('sc_clubs', 'sc_clubs.id = sc_club_boats.club_id', 'left');
						$this->db->where('sc_clubs.id', $value);
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
					case 'sail_number':
						$this->db->like('sc_boats.sail_number', $value);
					break;
				}
			}
			$query = $this->db->get();
			
			
			if($query->num_rows() == 0){
				return false;
			}elseif($query->num_rows() == 1){
				return $query->first_row();
			}else{
				return $query->result();
			}
		}
	}
	function get_boats($args, $order_by = null){
		$this->db->select('sc_boats.id, sc_boats.length, sc_boats.name, model, sail_number, coalesce(group_concat(sc_owners.name SEPARATOR \', \'), \' \') as owner ', FALSE);
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
					case 'main_class':
						$this->db->where('sc_boats.main_class', $value);
					break;
				}
			}			
		}
		if($order_by){
			$this->db->order_by($order_by, 'asc');
		}
		$this->db->group_by('sc_boats.id');
		//Todo: Pagination
		
		$query = $this->db->get();
		// $this->firephp->log($this->db->last_query());
		if($query->num_rows()>0)
		{
			return $query->result();
		}
	}
	
	function update(){
	
	}
	
	function delete(){
		
	}

	function get_boat_meta($boat_id, $field_name, $single = true){
		$query = $this->db->select('value', 'field', 'id')->from('sc_boat_meta')->where('boat_id', $boat_id)->where('field', $field_name)->get();
		if($query->num_rows() > 0){
			if($single === true){
				return $query->row();
			}else{
				$query->results();
			}
		}else{
			return false;
		}
	}

	function save_boat_meta($boat_id, $name, $value){
		$this->firephp->log('save_boat_meta');
		$this->db->insert('sc_boat_meta', array('boat_id' => $boat_id, 'field' => $name, 'value' => $value));
		$insert_id = $this->db->insert_id();
		if($insert_id){
			return true;
		}
	}

	/**
	 *		Function to delete boat meta data
	 * 		$args is an associative array and can be made up of:
	 * 			boat_id  			Must Be paired with field
	 * 			field 				Must be paired with boat_id
	 *			id 					Can be standalone, and used to delete an individual field
	 */	
	function delete_boat_meta($args){
		extract($args);
		if(isset($id)){
			$this->db->where('id', $id)->delete('sc_boat_meta');
		}elseif(isset($field) && isset($boat_id)){
			$this->db->where('boat_id', $boat_id)->where('field', $field)->delete('sc_boat_meta');
		}else{
			return false;
		}
	}

	function get_field($field, $id){
		$this->db->select($field);
		$this->db->from('sc_boats')->where('id', $id);
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
		$this->db->update('sc_boats', $parameters);
	}

	function get_class_boats($class_id){
		$this->db->select('sc_boats.id, 
							sc_boats.length, 
							sc_boats.name, 
							sc_boats.model, 
							sc_boats.sail_number, 
							coalesce(group_concat(sc_owners.name SEPARATOR \', \'), \' \') as owner,
							sc_class_boats.handicap as handicap,
							sc_class_boats.id as field_id', FALSE);
		$this->db->from('sc_class_boats');
		$this->db->join('sc_boats', 'sc_boats.id = sc_class_boats.boat_id', 'left');
		$this->db->join('sc_boat_owners', 'sc_boats.id = sc_boat_owners.boat_id', 'left');
		$this->db->join('sc_owners', 'sc_boat_owners.owner_id = sc_owners.id', 'left');
		$this->db->where('sc_class_boats.class_id', $class_id);
		$this->db->order_by('handicap', 'desc');
		$this->db->group_by('sc_boats.id');		
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}

	function get_owners($boat_id){
		$this->db->select('sc_owners.id, sc_owners.name, sc_owners.email, sc_owners.phone, sc_owners.user_id, sc_boats.id as boat_id');
		$this->db->from('sc_owners');
		$this->db->join('sc_boat_owners', 'sc_boat_owners.owner_id = sc_owners.id');
		$this->db->join('sc_boats', 'sc_boats.id = sc_boat_owners.boat_id');
		$this->db->where('sc_boats.id', $boat_id);
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}
}
?>