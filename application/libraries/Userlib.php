<?
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class userlib {

	private $userid = null;
	private $name = null;
	private $clubs = null;
	private $club_id = null;
	private $club_name = null;
	private $language = 'en';
	private $locale = 'uk';
	private $CI = null;
	
	function __construct(){
		$this->CI =& get_instance();
		$this->CI->load->model('user_model');
		
		if($this->CI->session->userdata('id')){	
			$this->userid = $this->CI->session->userdata('id');
			$this->name = $this->CI->session->userdata('name');
			$this->clubs =  $this->CI->user_model->get_user_clubs($this->userid);
			
			if($this->CI->session->userdata('club_id') && $this->CI->session->userdata('name')){
				$this->club_id = $this->CI->session->userdata('club_id');
				$this->club_name = $this->CI->session->userdata('name');
			}else{
				$this->club_id = $this->clubs[0]->club_id;
				$this->club_name = $this->clubs[0]->club_name;
				$this->set_club($this->club_id, $this->club_name);
			}
		}elseif($this->restore_login()){
			$this->userid = $this->CI->session->userdata('id');
			$this->name = $this->CI->session->userdata('name');
			$this->clubs =  $this->CI->user_model->get_user_clubs($this->userid);
			$this->club_id = $this->clubs[0]->club_id;
			$this->club_name = $this->clubs[0]->name;
			$this->locale = $this->clubs[0]->locale;
			$this->language = $this->clubs[0]->language;
			$this->set_club($this->club_id, $this->club_name);	
		}
	//	$this->CI->firephp->log("Name: ". $this->name);	
	//	$this->CI->firephp->log("User ID: ". $this->userid);
	//	$this->CI->firephp->log($this->clubs);
	//	$this->CI->firephp->log("Club ID: ". $this->club_id);
	}
	
	function user_clubs(){
		return $this->clubs;
	}
	
	function force_login(){
	// Function to check if a user is logged in and if they are not, redirects them to the login screen.
	// This function WILL NOT check if a user has sufficient permissions to perform a particular action.
		if(!$this->CI->session->userdata('id')){
			
			// if($this->restore_login() === false){
				$this->CI->session->set_flashdata('redirect',  current_url());
				redirect('user/login');
			//}
		}
	}
	
	function restore_login(){
	// Function to check for the presence of a cookie to restore the users login
		if(get_cookie('sc_token')){
			$userData = $this->CI->user_model->validate_token($this->CI->input->cookie('sc_token'));
	
			if($userData){
				$result = $this->CI->user_model->authenticate(array('email' => $userData->email, 'password' => $userData->password));
				if($result !== false){
					$this->CI->session->set_userdata($result);
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}
	}
	
	function get_clubs(){
		return $this->clubs;
	}
	
	function set_club($id, $name){
	// Function to set the club session variable
		$this->CI->session->set_userdata('club_id', $id);
		$this->CI->session->set_userdata('club_name', $name);
		$this->CI->session->set_userdata('language', $this->language);
		$this->CI->session->set_userdata('locale', $this->locale);
	}
	
	function activeuser(){
		if($this->userid) {
			return $this->userid;
		}else{
			return false;
		}	
	}
	
	
	function force_permission($action, $args=null){
		$this->CI->load->model('club_model');
		// Function to check if a user has permission to perform a particular action
		// Parameters:
		//				$userID : comes from the current session
		//				$action: Text, takes the form controller/method e.g. boat/view
		//				$args: array, specific to the action being performed
		// Returns:
		//				Nothing: Redirects to the forbidden page if the action is not allowed
				
		// 1. determine action
		// 2. determine if action has required subject
		// 3. determine if user has permission to perform action on required subject
		
		$subject = $this->CI->user_model->get_permission_subject($action, $args);
		
		//if There's no proper subject for the action then there's no permission
		if($subject =='' OR !$subject) redirect('user/forbidden');
		
		// If there's no arguments, then default to the users currently selected club_id
		if($args) {
			extract($args);
		}else{
			$club_id = $this->club_id;
		}
		
		
		if(isset($club_id)){
			// do nothing
		}elseif(isset($race_id)){
			$club_id = $this->CI->club_model->get_parent_club('race', $race_id);
		}elseif(isset($class_id)){
			$club_id = $this->CI->club_model->get_parent_club('class', $class_id);
		}elseif(isset($regatta_id)){
			$club_id = $this->CI->club_model->get_parent_club('regatta', $regatta_id);
		}elseif(isset($boat_id)){
			$club_id = $this->CI->club_model->get_parent_club('boat', $boat_id);
		}
		
		$result = $this->CI->user_model->query_permissions($this->userid, $action, $club_id);

		if($result === false){
			redirect('user/forbidden');
		}	
	}
	
	function check_permission($action, $args=null){
		$action = str_replace('/', '_', $action);
		// Function to check if a user has permission to perform a particular action
		// Parameters:
		//				$userID
		//				$action: Text, takes the form controller/method e.g. boat/view
		//				$args: array, specific to the action being performed
		// Returns:
		//				TRUE if permission is granted
		//				FALSE if permission is not granted
				
		// 1. determine action
		// 2. determine if action has required subject
		// 3. determine if user has permission to perform action on required subject
		
		$subject = $this->CI->user_model->get_permission_subject($action, $args);
		
		//if There's no proper subject for the action then there's no permission
		if(!$subject) return false;
		// If there's no arguments, then default to the users currently selected club_id
		if($args) {
			extract($args);
		}else{
			$club_id = $this->club_id;
		}
		
		
		$this->CI->load->model('club_model');
		
		if(isset($club_id)){
			// do nothing
		}elseif(isset($race_id)){
			$club_id = $this->CI->club_model->get_parent_club('race', $race_id);
		}elseif(isset($class_id)){
			$club_id = $this->CI->club_model->get_parent_club('class', $class_id);
		}elseif(isset($regatta_id)){
			$club_id = $this->CI->club_model->get_parent_club('regatta', $regatta_id);
		}elseif(isset($boat_id)){
			$club_id = $this->CI->club_model->get_parent_club('boat', $boat_id);
		}
		$result = $this->CI->user_model->query_permissions($this->userid, $action, $club_id);
		return $result;	
	}
	
	
	function active_club(){
		return $this->club_id;
	}
}

?>