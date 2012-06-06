<?
class Clubs extends CI_Controller{

	function index(){
		redirect(base_url('/'));
	}

	// View Club and all its regattas
	function view($club_name, $club_id){

	}

	// View a regatta and all its classes
	function series($club_name, $regatta_id){

	}

	// View a class and all its races
	function class($club_name, $class_id){

	}

	// View a race and it's results
	function race($club_name, $class_name, $race_id){

	}

}
?>