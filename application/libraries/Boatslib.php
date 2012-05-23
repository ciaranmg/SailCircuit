<? if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	/**
	* Library class to help setting up classes.
	*/
	class Boatslib {
		
		function __construct(){
			$this->CI =& get_instance();
		}

		function get_dropdown_options($field){
			
			$options['Keelboat'] = 'Keelboat';
			$options['Dinghy'] = 'Dinghy';
			
			return $options;
		}
	}
?>