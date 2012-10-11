<?
class boats_model extends CI_Model {

	/**
	 * Method to insert a boat into the database
	 *	Parameters: 
	 *					array 	$boatData		Associative array of boat data
	 *					int 	$club_id
	 * Returns:
	 *					int 	$boat_id of the inserted boat
	 */
	function insert($boatData, $club_id) {
			$this->db->insert('sc_boats', $boatData); 
			$x = $this->db->insert_id();
			$this->boats_model->set_club_boat($club_id, $x);
			
			return $x;
	}	
	

	/**
	 * Method to get boat data 
	 * Parameters
	 *				int 	$boat_id
	 */
	function get($id){
		$result = $this->db->get_where('sc_boats', array('id' => $id));
		if($result->num_rows() > 0){
			$boat = $result->row();
			$field_names = array_keys($this->config->item('boats_meta'));
			$fields = $this->config->item('boats_meta');

			$meta = $this->db->select('id, field, value')->from('sc_boat_meta')->where('boat_id', $id)->where_in('field', $field_names)->get();
			if($meta->num_rows() > 0){
				foreach($meta->result() as $meta_data){
					$meta_data->label = $fields[$meta_data->field]['label'];
					$meta_data->type = $fields[$meta_data->field]['type'];
					if($meta_data->field == '_image')
						$meta_data->value = json_decode($meta_data->value);
					$boat->meta[$meta_data->field] = $meta_data;
				}
			}
			return $boat;
		}else{
			return false;
		}
	}
	
	/**
	 * Method to set the owner of a boat
	 * Parameters
	 *				int 	$boat_id
	 *				int 	$owner_id
	 */
	function set_boat_owner($boat_id, $owner_id){
		$this->db->insert('sc_boat_owners', array('owner_id'=>$owner_id, 'boat_id' => $boat_id));
		if($this->db->insert_id()) return true;
	}
	

	/**
	 * Method to assign a boat to a club
	 * Parameters
	 *				int 	$club_id
	 *				int 	$boat_id
	 */
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

	/**
	 * Method to get a list of boats given search criteria
	 * Parameters
	 *				array 		$args 		Associative array of field names and values
	 *				string 		$order_by	The name of the field to order by
	 *				int 		$limit 		A limit value for pagination
	 *				int 		$offset 	An offset value for pagination
	 */
	function get_boats($args, $order_by = null, $limit = null, $offset = 0){
		$this->db->select('boats.id, 
							boats.length, 
							boats.name, 
							boats.model as boat_type, 
							boats.sail_number, 
							coalesce(group_concat(sc_owners.name SEPARATOR \', \'), \' \') as owner ', FALSE);
		$this->db->join('boat_owners', 'boats.id = boat_owners.boat_id', 'left');
		$this->db->join('owners', 'boat_owners.owner_id = owners.id', 'left');
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
		
		$query = $this->db->get('boats', $limit, $offset);
		if($query->num_rows()>0)
		{
			return $query->result();
		}
	}

	/**
	 * Method to get the number of boats given a club_id and an optional boat_type
	 * Parameters
	 *				int 		$club_id	
	 *				string 		$main_class
	 * Returns
	 *				int 		Count of the number of matching boats
	 */
	function num_rows($club_id, $main_class = null){
		$this->db->from('boats');
		$this->db->join('club_boats', 'club_boats.boat_id = boats.id');
		$this->db->where('club_boats.club_id', $club_id);
		if($main_class){
			$this->db->where('boats.main_class', $main_class);
		}

		$x =  $this->db->count_all_results();
		return $x;
	}


	/**
	 * Method to get boat meta information
	 * Parameters
	 *				int 		$boat_id
	 *				string 		$field_name
	 *				boolean		$single
	 * Returns
	 *				object 		Object
	 *							->value
	 *							->field
	 *							->id
	 *				array 		Array of objects above.
	 */
	function get_boat_meta($boat_id, $field_name, $single = true){
		$query = $this->db->select('value', 'field', 'id')->from('sc_boat_meta')->where('boat_id', $boat_id)->where('field', $field_name)->get();
		$boats_meta = $this->config->item('boats_meta');
		if($query->num_rows() > 0){
			if($single === true){
				$meta = $query->row();
				if($boats_meta[$field_name]['type'] == 'array' OR $boats_meta[$field_name]['type'] =='file'){

					$meta->value = json_decode($meta->value);
				}
				return $meta;
			}else{
				$query->results();
			}
		}else{
			return false;
		}
	}

	/**
	 * Method to save boat meta
	 * Parameters
	 *					int 		$boat_id
	 *					string 		$name 			Field Name
	 *					mixed 		$value
	 */
	function save_meta($boat_id, $name, $value, $type = 'text'){
		$this->db->insert('sc_boat_meta', array('boat_id' => $boat_id, 'field' => $name, 'value' => $value));
		$insert_id = $this->db->insert_id();
		if($insert_id){
			return $insert_id;
		}else{
			return false;
		}
	}

	/**
	 *		Function to delete boat meta data
	 * 		$args is an associative array and can be made up of:
	 * 			boat_id  			Must Be paired with field
	 * 			field 				Must be paired with boat_id
	 *			id 					Can be standalone, and used to delete an individual field
	 */	
	function delete_meta($args){
		extract($args);
		if(isset($id)){
			$this->db->where('id', $id)->delete('sc_boat_meta');
		}elseif(isset($field) && isset($boat_id)){
			$this->db->where('boat_id', $boat_id)->where('field', $field)->delete('sc_boat_meta');
		}else{
			return false;
		}
	}


	/**
	 * Method to get races the given boat completed recently
	 * Parameters:
	 *				int 	$boat_id
	 *				int 	$limit
	 */
	function get_boat_races($boat_id, $limit = 5){
		$this->db->select('races.id, races.name, races.start_date, race_results.position');
		$this->db->join('race_results', 'race_results.race_id = races.id');
		$this->db->where('race_results.boat_id', $boat_id);
		$this->db->where('race_results.status !=', 'DNC');
		$query = $this->db->get('races', $limit);
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}

	}

	/**
	 * Method to get value of a specific field
	 * Parameters
	 *					string 			$field
	 *					int 			$boat_id
	 */
	function get_field($field, $boat_id){
		$meta_fields = array_keys($this->config->item('boats_meta'));
		if(in_array($field, $meta_fields)){
			$query = $this->db->select('value')->from('boat_meta')->where('field', $field)->where('boat_id', $boat_id)->get();
			if($query->num_rows() > 0){
				$x = new stdClass;
				$x->$field = $query->first_row()->value;
				return $x;
			}
		}else{
			$this->db->select($field);
			$this->db->from('sc_boats')->where('id', $boat_id);
			$query = $this->db->get();
			if($query->num_rows() > 0)
				return $query->first_row();
		}
	}

	/**
	 * Method to update single field. Used for Ajax updates
	 * Parameters
	 *					string 			$field
	 *					mixed 			$data
	 *					int 			$boat_id
	 *					string 			$type 		A string identifying the type of data being sent.
	 */
	function update_field($field, $data, $boat_id, $type){
		if($type == 'date' OR $type == 'datetime'){
			$data = sc_strtotime($data);
		}

		$meta_fields = array_keys($this->config->item('boats_meta'));
		if(in_array($field, $meta_fields)){
			$parameters = array('value' => $data);
			$this->db->where('boat_id', $boat_id)->where('field', $field)->update('boat_meta', $parameters);
		}else{
			$parameters = array(
							$field => $data
							);
			$this->db->where('id', $boat_id);
			$this->db->update('sc_boats', $parameters);
		}
	}

	/**
	 * Method to get all boats belonging to a class
	 * Parameters
	 *				int 		$class_id
	 * Returns
	 *				array 		array of boat objects
	 */
	function get_class_boats($class_id){
		$this->db->select('sc_boats.id, 
							sc_boats.length, 
							sc_boats.name, 
							sc_boats.model as boat_type,
							boats.sub_class as class, 
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
			$class_boats = $query->result();
			foreach($class_boats as &$boat){
				foreach($this->config->item('boats_meta') as $meta_field){
					if($meta = $this->boats_model->get_boat_meta($boat->id, $meta_field['field']))
						$boat->$meta_field['field'] = $meta->value;
				}
			}
			return $class_boats;
		}else{
			return false;
		}
	}

	/**
	 * Method to get owner(s) of a boat
	 * Parameters
	 *				int 	$boat_id
	 */
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
	/**
	 * Method to get the list of meta fields available to add to a boat for use in a drop-down menu.
	 */
	function get_meta_options($boat_id){
		$all_fields = $this->config->item('boats_meta');
		$used_fields = $this->db->select('field')->where('boat_id', $boat_id)->get('boat_meta');
		if($used_fields->num_rows() > 0){
			foreach($used_fields->result() as $r){
				unset($all_fields[$r->field]);
			}
			$meta_options['0'] = 'Choose One...';
			foreach($all_fields as $f){
				// Don't use fields that start with an underscore, they're special
				if(substr($f['field'], 0, 1) == '_') continue;
				$meta_options[$f['field'] . '|' . $f['type']] = $f['label'];
			}
			return $meta_options;
		}
	}
}
?>