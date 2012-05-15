<?
class User extends CI_Controller {
	
	private $userData = array(
							'name' => '',
							'email' => '',
							'id' => '',
							'password' => '',
							'valid' => 'false'
							);
	function index(){
		$this->load->view('common/header');
		$this->load->view('user/login_form');
		$this->load->view('common/footer');
	}
	
	// Function to create new user record.
	// Displays the form, validates the data, and inserts the record
	function create() {
		$this->load->library('Form_validation');
		$this->load->view('common/header');	
		$this->load->helper('form');
		if($this->input->post('submit') && $this->input->post('action') == 'user/create'){
			
			$this->form_validation->set_error_delimiters('<div class="error"><span>&nbsp;</span>', '</div>');
			if($this->form_validation->run('signup')===false){
				$this->load->view('user/new_user_form');
			}else{
				$this->userData['name'] = $this->input->post('name');
				$this->userData['email'] = $this->input->post('email');
				$this->userData['password'] = $this->input->post('password1');
				$this->userData['valid'] = true;
				$this->user_model->create($this->userData);
				$this->load->view('user/user_profile', $this->userData);
			}
		}else {
			$this->load->view('user/new_user_form');			
		}
		$this->load->view('common/footer');
	}
	
	// Function to display user profile
	function profile(){
		// Check that there is a user logged in
		if(isset($this->session->userdata['id'])){
			$result = $this->user_model->retrieve($this->session->userdata['id']);
			if($result === false){
				redirect('user/login');
			}else{
				$this->load->view('user/user_profile', $result);
			}
		}else{
			redirect('user/login');
		}
	}
	
	function update(){
	
	}
	
	function remove() {
	
	}
	
	// Function to process user login
	// Sets session variables on successful login.
	function login(){
		$this->load->helper('form');
		$this->load->library('Form_validation');
		
		$data['action'] = 'user/login';
		
		if($this->session->flashdata('redirect')){
			$data['redirect'] = $this->session->flashdata('redirect');
		}else{
			$data['redirect'] = '/'; // Set a default redirect for the login action
		}
		
		
		// Check if the login form has been submitted
		if($this->input->post('action') == 'user/login'){
			if($this->form_validation->run('login')===false){
				$this->session->set_flashdata('err_message', 'Invalid Username or Password');
				$this->session->set_flashdata('redirect', $data['redirect']);
				redirect('user/login');
			}else{
				
				$user = array(
								'email' => $this->input->post('username'), 
								'password' => $this->input->post('password')
							);
				$result = $this->user_model->authenticate($user);
				
				if($result !== false){
					$this->session->set_userdata($result);
					$this->session->set_flashdata('message', 'Login Successful');
					if($this->input->post('remember') == '1'){
						// $this->firephp->log('Remember set');
						$this->set_token($result->id);
					}
					redirect($this->input->post('redirect'));
				}else{
					$this->session->set_flashdata('err_message', 'Invalid Username or Password');
					$this->load->view('user/login', $data);
				}
			}
		}else {
			// Check if a redirect value has been set in the flash session and assign it to the template data.
			if($this->session->flashdata('redirect')) $data['redirect'] = $this->session->flashdata('redirect');
			$this->load->view('user/user_login', $data);
		}	
	}
	
	function set_token($id){
		$token = $this->user_model->save_token($id);						
		$cookie = array(
		    'name'   => 'sc_token',
		    'value'  => $token,
		    'expire' => '2592000',  // 30 days
		);
		set_cookie($cookie);
	}
	
	// Function to check the database for existing user based on email address
	// Parameters: 	Email address
	// Returns: 	TRUE if the user is not found
	//				FALSE if the user is found and the form fails validation
	function check_email($email){
		if($this->user_model->check_user($email) === true) {
			$this->form_validation->set_message('check_email', '%s is already taken!');
        	return false;
		}else{
			return true;
		};
		
	}
	
	// Function to log out the current user and destory all their session data
	function logout(){
		$this->session->sess_destroy();
		redirect('user/login');
	}
	
	function forbidden(){
		$data['breadcrumb'] = $this->breadcrumb->get_path();
		$this->load->view('common/header', $data);
		$this->load->view('common/forbidden');
		$this->load->view('common/footer');
		
	}
	
}
?>