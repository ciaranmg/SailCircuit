<?

if(!function_exists('activeuser')){
	
	function activeuser(){
		$CI =& get_instance();
		if($CI->session->userdata('id')) $x = $CI->session->userdata('id');
		if(isset($x)){
			return true;
		}else{
			return false;
		}
	}
}
?>