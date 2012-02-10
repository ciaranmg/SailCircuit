<?
/*----------------------------------------------------------------------------
Class to determine the breadcrumb path of the current page.
----------------------------------------------------------------------------*/
class breadcrumb {
	
	private $path = array(
					0 => array(
							'title' => 'Dashboard',
							'ci_url' => 'home/dashboard',
							'url' => '#home/dashboard',
							'current' => false
					));
	
	function __construct(){
		$this->CI =& get_instance();
		$segments = explode('/', uri_string());
		if($segments[0] == 'dashboard'){
			// Set the current flag to true
			$this->path[0]['current'] = true;
		}elseif($segments[0]== 'regatta'){
			// We're into the regattas controller. Determine how deep.
			if($segments[1] == 'view'){
				$this->path[] = array(
									'title' => 'View Regatta',
									'ci_url' => 'regatta/view/' . $segments[2],
									'url' => '#regatta/view/' . $segments[2],
									'current' => true											
									);
			}elseif($segments[1] == 'create'){
				$this->path[] = array(
									'title' => 'Create New Regatta',
									'ci_url' => 'regatta/create/',
									'url' => '#regatta/create/',
									'current' => true
									);
			}elseif($segments[1] == 'edit'){
				$this->path[] = array(
									'title' => 'View Regatta',
									'ci_url' => 'regatta/view/' . $segments[2],
									'url' => '#regatta/view/' . $segments[2],
									'current' => false											
									);
				$this->path[] = array(
									'title' => 'Edit Regatta',
									'ci_url' => 'regatta/edit/' . $segments[2],
									'url' => '#regatta/edit/' . $segments[2],
									'current' => true											
									);
			}
		}elseif($segments[0] == 'classes'){
			// We're looking at a class, which has a parent which is a regatta
			$this->CI->load->model('regatta_model');
			$parent = $this->CI->regatta_model->get_parent_regatta($segments[2]);
			if($segments[1]=='view'){
				$this->path[] = array(
										'title' => $parent->name,
										'ci_url' => 'regatta/view/' . $parent->id,
										'url' => '#regatta/view/' . $parent->id,
										'current' => false
									);
				$this->path[] = array(
										'title' => 'View Class',
										'ci_url' => 'class/view/' . $segments[2],
										'url' => '#class/view/' . $segments[2],
										'current' => true
									);

			}elseif($segments[1]=='edit'){
				$this->path[] = array(
										'title' => $parent->name,
										'ci_url' => 'regatta/view/' . $parent->id,
										'url' => '#regatta/view/' . $parent->id,
										'current' => false
									);
				$this->path[] = array(
										'title' => 'View Class',
										'ci_url' => 'class/view/' . $segments[2],
										'url' => '#class/view/' . $segments[2],
										'current' => false
									);									
				$this->path[] = array(
										'title' => 'Edit Class',
										'ci_url' => 'class/edit/' . $segments[2],
										'url' => '#class/edit/' . $segments[2],
										'current' => true
									);

			}
		}elseif($segments[0] == 'race'){
			$this->CI->load->model('regatta_model');
			$this->CI->load->model('class_model');
			
		}elseif($segments[0] == 'boat'){
		
		}
	}
	
	function get_path(){
		return $this->path;
	}

}

?>