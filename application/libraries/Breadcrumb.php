<?
/*----------------------------------------------------------------------------
Class to determine the breadcrumb path of the current page.
----------------------------------------------------------------------------*/
class breadcrumb {
	
	private $path = array(
					0 => array(
							'title' => 'Dashboard',
							'ci_url' => 'home/dashboard',
							'url' => '/',
							'current' => false
					));
	private $parent_id, $parent_name;
	
	function __construct(){
		$this->CI =& get_instance();
	}

	function get_path($trail = null){
		$segments = explode('/', uri_string());

		if($segments[0] == 'home' OR $segments[0] == ''){
			// Set the current flag to true
			$this->path[0]['current'] = true;

		}elseif($segments[0]== 'regatta'){
			// We're into the regattas controller. Determine how deep.
			
				if(!isset($segments[1])){
					$this->path[] = array(
									'title' => 'List Regattas',
									'ci_url' => 'regatta/list',
									'url' => 'regatta/list',
									'current' => true
								);
				}elseif($segments[1] == 'view'){
					$this->path[] = array(
										'title' => 'View Regatta',
										'ci_url' => 'regatta/view/' . $segments[2],
										'url' => 'regatta/view/' . $segments[2],
										'current' => true											
										);
				}elseif($segments[1] == 'create'){
					$this->path[] = array(
										'title' => 'Create New Regatta',
										'ci_url' => 'regatta/create/',
										'url' => 'regatta/create/',
										'current' => true
										);
				}elseif($segments[1] == 'edit'){
					$this->path[] = array(
										'title' => 'View Regatta',
										'ci_url' => 'regatta/view/' . $segments[2],
										'url' => 'regatta/view/' . $segments[2],
										'current' => false											
										);
					$this->path[] = array(
										'title' => 'Edit Regatta',
										'ci_url' => 'regatta/edit/' . $segments[2],
										'url' => 'regatta/edit/' . $segments[2],
										'current' => true											
										);
				}

		}elseif($segments[0] == 'classes'){
			// We're looking at a class, which has a parent which is a regatta
			$parent = $this->CI->classes_model->get_parent($segments[2]);
			if($segments[1]=='view'){
				$this->path[] = array(
										'title' => $parent->name,
										'ci_url' => 'regatta/view/' . $parent->id,
										'url' => 'regatta/view/' . $parent->id,
										'current' => false
									);
				$this->path[] = array(
										'title' => 'View Class',
										'ci_url' => 'class/view/' . $segments[2],
										'url' => 'class/view/' . $segments[2],
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
										'url' => 'class/edit/' . $segments[2],
										'current' => true
									);

			}elseif($segments[1] == 'create'){
				$regatta = $this->CI->regatta_model->get($segments[2]);
				$this->path[] = array(
										'title' => $regatta->name,
										'ci_url' => 'regatta/view/' . $regatta->id,
										'url' => 'regatta/view/' . $regatta->id,
										'current' => false
									);
				$this->path[] = array(
										'title' => 'Create Class',
										'ci_url' => 'class/create' . $segments[2],
										'url' => 'class/create/' . $segments[2],
										'current' => true
										);
			}
		}elseif($segments[0] == 'race'){
			if($segments[1] == 'input'){
				$this->path[] = array(
						'title' => 'Input Race Data',
						'ci_url' => 'races/input',
						'url' => 'races/input',
						'current' => true
					);
			}elseif($segments[1] == 'view'){
				$class = $this->CI->race_model->get_parent($segments[2]);
				$regatta = $this->CI->classes_model->get_parent($class->id);
				
				$this->path[] = array(
						'title' => $regatta->name,
						'ci_url' => 'regatta/view/' . $regatta->id,
						'url' => 'regatta/view/' . $regatta->id,
						'current' => false);
				$this->path[] = array(
						'title' => $class->name,
						'ci_url' => 'classes/view/' . $class->id,
						'url' => 'classes/view/' . $class->id,
						'current' => false);
				$this->path[] = array(
						'title' => 'View Race',
						'ci_url' => 'races/view',
						'url' => 'races/view',
						'current' => true
					);
			}
		}elseif($segments[0] == 'boats'){
			if(!isset($segments[1])){
				$this->path[] = array(
						'title' => 'List Boats',
						'ci_url' => 'boats',
						'url' => 'boats',
						'current' => true
					);
			}elseif($segments[1] == 'view'){
				$this->path[] = array(
						'title' => 'List Boats',
						'ci_url' => 'boats',
						'url' => 'boats',
						'current' => false
					);
				$this->path[] = array(
						'title' => 'View Boat',
						'ci_url' => 'boats/view',
						'url' => 'boats/view',
						'current' => true
						);
			}elseif($segments[1] == 'create'){
				$this->path[] = array(
						'title' => 'List Boats',
						'ci_url' => 'boats',
						'url' => 'boats',
						'current' => false
					);
				$this->path[] = array(
						'title' => 'Add New Boat',
						'ci_url' => 'boats/create',
						'url' => 'boats/create',
						'current' => true
						);
			}
		}elseif($segments[0] == 'user'){
			$this->path[] = array(
									'title' => 'Action Forbidden',
									'ci_url' => 'user/forbidden',
									'url' => 'user/forbidden',
									'current' => true
								);
			}
		return $this->path;
	}

}

?>