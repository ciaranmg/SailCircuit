<?
class Race_model extends CI_Model{
	
	var $race_data;

	function get_races($class_id){
		$this->db->from('sc_races')->where('class_id', $class_id);
		$this->db->order_by('start_date','asc');
		$this->db->order_by('id', 'asc');
		$this->db->order_by('start_date', 'asc');
		$query = $this->db->get();
		if($query->num_rows() > 0) {
			// $this->firephp->log($query->result());
			return $query->result();
		}else{
			// $this->firephp->log('or here');
			return false;
		}
	}

	function get($race_id){
		$this->db->select('sc_races.id, 
							sc_races.class_id,
							sc_races.name, 
							sc_races.start_date, 
							sc_races.discard, 
							sc_handicap_systems.id as handicap_id, 
							sc_handicap_systems.name as handicap_name');
		$this->db->from('sc_races');
		$this->db->join('sc_classes', 'sc_classes.id = sc_races.class_id');
		$this->db->join('sc_handicap_systems', 'sc_handicap_systems.id = sc_classes.rating_system_id');
		$this->db->where('sc_races.id', $race_id);
		$query = $this->db->limit(1)->get();
		if($query->num_rows() > 0){
			return $query->first_row();
		}else{
			return false;
		}

	}

	function get_races_dropdown($class_id, $status){
		$query = $this->db->select('sc_races.id, sc_races.name')->from('sc_races')->where('class_id', $class_id)->where('status', $status)->get();
		$races_list[] = array('value' => '0', 'display' => 'Choose One');
		if($query->num_rows() > 0){
			foreach($query->result() as $r){
				$races_list[] = array('value' => $r->id, 'display' => $r->name);
			}
		}
		return $races_list;
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


	/**
	 * Method to take the form data of a race, calculate the corrected times and commit to the database.
	 * Parameters:
	 *				None: 	This method pulls from the post variables
	 */
	function process_data(){
		$data['race'] = $this->race_model->get($this->input->post('race_id'));			
		foreach($this->input->post('entry') as $entry){

			$race_data[]['boat_id'] = $this->input->post('entry_boat_id_'.$entry);

			if($this->input->post('finish_date_'.$entry) && $this->input->post('timer') == 'finishtime'){
			
				$ft = trim($this->post('finish_date_'.$entry)) . ' ' . trim($this->input->post('finish_time_' . $entry));
				$race_data[]['finish_time'] = $ft;
				$race_data[]['elapsed_time'] = sc_elapsed_time($this->input->post('race_date') . ' ' . $this->input->post('race_time'), $ft);
				unset($ft);
			
			}else{
				$race_data[]['finish_time'] = '';
				$race_data[]['elapsed_time'] = time2sec(trim($this->post('finish_time_'.$entry)));
			}
			$race_data[]['status'] = $this->input->post('entry_status_' . $entry);
		}
		$this->db->insert_batch('sc_race_data', $race_data);
	}

	/**
	 * Method to take data submitted by the form and convert it to usable variables & objects
	 * Parameters:
	 *				string 	$string 		- A string of text given to a textarea field of sail numbers and finish times (or statuses)
	 *				array 	$args 			- An array of arguments passed straight to the boats_model->search_boats method
	 *							
	 */
	function process_raw_data($string, $args){
		$this->load->model('boats_model');
		
		$total = 0;
		$not_found = 0;
		$found = 0;
		$matches = 0;

		// Split into lines
		$lines = preg_split( '/\r\n|\r|\n/', $string );
		// Split lines into Sail number, and  time
		$total = count($lines);
		$i = 0;
		foreach($lines as $l){
			$line_data = explode(',', $l);
			$this->race_data[$i] = new stdClass;
			$this->race_data[$i]->id = $i;
			$this->race_data[$i]->sail_number = trim($line_data[0]);
			$args['sail_number'] = $line_data[0];
 			
 			$boat = $this->boats_model->search_boats($args);
 			if($boat === false){
 				$not_found++;
 			}elseif(isset($boat->id)){
 				$found++;
 			}else{
 				$matches++;
 			}
 			$this->race_data[$i]->boat = $boat;			

			if(strpos($line_data[1], ':')){
				// This is a time value
				if(strpos($line_data[1], '/') OR strpos($line_data[1], '-')){
					$date_time = explode(' ', $line_data[1]);
					$this->race_data[$i]->date = $date_time[0];
					$this->race_data[$i]->time = $date_time[1];
					unset($date_time);
				}else{
					$this->race_data[$i]->time = trim($line_data[1]);
				}
				$this->race_data[$i]->status = false;
			}else{
				// This is not a time value. Assign it to the status field
				$this->race_data[$i]->time = false;
				$this->race_data[$i]->status = trim($line_data[1]);
			}

			$i++;
		}

		$count = new stdClass;
		$count->total = $total;
		$count->found = $found;
		$count->not_found = $not_found;
		$count->matches = $matches;

		return array(
					'count' => $count,
					'entries'=> $this->race_data
					);
	}

	/*----------------------------------------------------------------------------
	Description: Create a race, or races
	
	Parameters: $name: Array or String
				$class_id: integer
	----------------------------------------------------------------------------*/
	function initialise_races($name, $class_id, $races_to_create){
		$this->load->model('classes_model');

		$num_races = $this->db->where('class_id', $class_id)->count_all_results('sc_races');
		$class = $this->classes_model->get($class_id);
		if($num_races + $races_to_create < $this->config->item('sc_class_max_races')){

		}else{
			$overflow = $this->config->item('sc_class_max_races') - $num_races + $races_to_create;
			$races_to_create = $races_to_create - $overflow;
		}
		if($races_to_create > 0){
			for($i=1; $i<=$races_to_create; $i++){
				$races[] = array(
							'name' => $name ." $i",
							'start_date' => time(),
							'class_id' => $class_id,
							'discard' => ($class->discards > 0) ? 1 : 0
						);
			}
			$this->db->insert_batch('sc_races', $races);
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