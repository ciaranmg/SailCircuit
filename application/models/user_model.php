<?
class User_model extends CI_Model{
	
	function create($userData) {
		$this->load->database();
		
		if($userData['valid'] === true){
			unset($userData['valid']);
			$x = $this->db->insert('sc_users', $userData);
			// $this->firephp->log($x);
		}
	}
	
	//Function to retreive all user data
	function retrieve($id){
		$result = $this->db->get_where('sc_users', array('id' => $id));
		if($result->num_rows() > 0){
			return $result->row();
		}else{
			return false;
		}
	}
	
	function update(){
	
	}
	
	function delete(){
	
	}
	
	// Function to authenticate user login 
	// Parameters: userData = array('username' => 'xxx', 'password' => 'yyy')
	function authenticate($userData){
		$this->load->database();
		$result = $this->db->get_where('sc_users', $userData);
		
		if($result->num_rows() > 0){
			return $result->row();

		}else{
			return false;
		}
		
	}
	
	
	/**
	 * function to get the clubs name and ID that a user belongs to. If no parameter is passed, defaults to current session users id
	 *	Parameters:	$userid
	 *	Returns 2D array of club names and club IDs the user belongs to.
	 */
	function get_user_clubs($user_id){

		$this->db->select('name, sc_clubs.id as club_id, sc_clubs.description, sc_clubs.locale, sc_clubs.language');
		$this->db->from('sc_clubs');
		$this->db->join('sc_club_users', 'sc_club_users.club_id = sc_clubs.id');
		$this->db->where('sc_club_users.user_id', $user_id);
		$query = $this->db->get();

		if($query->num_rows() >0 ){
			return $query->result();
		}	
	}
	
	function validate_token($token){
		$pieces = explode('_', $token);
		$this->db->from('sc_login_tokens');
		$this->db->where('user_id', $pieces[0]);
		$this->db->where('token', $pieces[1]);
		$result = $this->db->get();
		if($result->num_rows() >0){
			$userData = $this->user_model->retrieve($pieces[0]);
			if($userData) return $userData;
		}
	}
	
	function check_user($email){
	// Function to check if a user is in the database
	// Returns:		TRUE is the user exists
	//				FALSE if the user does not exist		
		$query = "SELECT email FROM sc_users WHERE email=".$this->db->escape($email);
		$result = $this->db->query($query);
		
		// $this->firephp->log($email);
		
		if($result->num_rows() == 0){
			return false;
		}else{
			return true;
		}
	}
	
	function get_permission_subject($action_name){
		//convert CI style controller/method format to datbase friendly controller_method format
		// $this->firephp->log('user_model->get_permission_subject');
		$action_name = str_replace('/', '_', $action_name);
		$this->db->select('subject');
		$this->db->limit(1);
		$query = $this->db->get_where('sc_permissions', array('permission_name' => $action_name));
		// $this->firephp->log($this->db->last_query());
		if($query->num_rows() > 0){
			$row = $query->row();
			return $row->subject;
		} 
	}
	
	function query_permissions($userid, $action, $subject_id){
		// Query to see if the current user is part of the right club, and group to perform the given action.
		// $this->firephp->log('query_permissions');
		$this->db->select('sc_permissions.id');
		$this->db->from('sc_permissions');
		$this->db->join('sc_role_permissions', 'sc_role_permissions.permission_id = sc_permissions.id');
		$this->db->join('sc_roles', 'sc_role_permissions.role_id = sc_roles.id');
		$this->db->join('sc_club_users', 'sc_club_users.role_id = sc_roles.id');
		
		
		$this->db->where('sc_club_users.user_id', $userid);
		$this->db->where('sc_club_users.club_id', $subject_id);
		$this->db->where('sc_permissions.permission_name', $action);
		
		$query = $this->db->get();
		// $this->firephp->log("Query Permissions: " . $this->db->last_query()); 
		if($query->num_rows() > 0) {
			// $this->firephp->log('Permission: TRUE');
			return true;
			
		}else{
			// $this->firephp->log('Permission: FALSE');
			return false;
		}
	}
	
	function save_token($user_id){
		$time = time();
		$token = md5($user_id . $time);
		$data = array('user_id' => $user_id, 'token' => $token, 'timestamp' => $time);
		
		$this->db->insert('sc_login_tokens', $data);
		
		return $user_id .'_'.$token;
	}
	
}
?>