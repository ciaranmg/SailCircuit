<?
/**
* Race Data class.
* Data structures and methods for handling recorded race data.
*/

class race_data
{
	var $race_data;

	function __construct()
	{
		$this->CI =& get_instance();
	}

	/**
	 * Method to take data submitted by the form and convert it to usable variables & objects
	 */
	function process_raw_data($string, $args){
		

		// Split into lines
		$lines = preg_split( '/\r\n|\r|\n/', $string );
		$this->CI->firephp->log($lines);
		// Split lines into Sail number, and  time

		$i = 0;
		foreach($lines as $l){
			$line_data = explode(',', $l);
			$this->race_data[$i] = new stdClass;
			$this->race_data[$i]->sail_number = trim($line_data[0]);

			$this->race_data[$i]->boat = $this->boats_model->search_boats($args);
			if(strpos($line_data[1], ':')){
				// This is a time value
			}else{
				// This is not a time value. Assign it to the status field
			}
			$this->race_data[$i]->time = trim($line_data[1]);
			$i++;
		}
		$this->CI->firephp->log($this->race_data);
		// Calculate seconds 
	}

	/**
	 * Method to return data ready to be inserted in the database.
	 */
	function dbData(){

	}


}
?>