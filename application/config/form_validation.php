<?
$config = array(
				'signup' => array(
									array(
										'field' => 'name',
										'label' => 'Name',
										'rules' => 'trim|required|min_length[3]|max_length[30]|xss_clean'
										),
									array(
										'field' => 'password1',
										'label' => 'Password',
										'rules' => 'trim|required|min_length[6]|md5'
										),
									array(
										'field' => 'password2',
										'label' => 'Verify Password',
										'rules' => 'trim|required|matches[password1]'
										),
									array(
										'field' => 'email',
										'label' => 'Email Address',
										'rules' => 'trim|required|valid_email|callback_check_email'
										)
									),
				'login' => array(
									array(
										'field' => 'username',
										'label' => 'Username',
										'rules' => 'trim|required|valid_email|xss_clean'
										
									),
									array(
										'field' => 'password',
										'label' => 'Password',
										'rules' => 'trim|required|min_length[6]|md5'
										
									)
								),
				'club' => array(
									array(
											'field'=> 'name',
											'label' => 'Club Name',
											'rules' => 'trim|alpha|required|xss_clean'
									),
									array(
											'field'=> 'description',
											'label' => 'Description',
											'rules' => 'trim|xss_clean'
									)
								),
				'boats/create' => array(
									array(
											'field'=> 'name',
											'label' => 'Boat Name',
											'rules' => 'trim|required|xss_clean'
									),
									array(
											'field'=> 'sail_number',
											'label' => 'Sail Number',
											'rules' => 'trim|required|xss_clean'
									),
									array(
											'field'=> 'make',
											'label' => 'Manufacturer/Builder',
											'rules' => 'trim|xss_clean'
									),
									array(
											'field'=> 'model',
											'label' => 'Model',
											'rules' => 'trim|required|xss_clean'
									),
									array(
											'field'=> 'length',
											'label' => 'Boat Length',
											'rules' => 'trim|numeric|xss_clean'
									),
									array(
											'field' => 'sub_class',
											'label' => 'Class',
											'rules' => 'trim|xss_clean'
									)
								),
				'regatta/create' => array(
									array(
											'field'=> 'regatta_name',
											'label' => 'Regatta Name',
											'rules' => 'trim|required|xss_clean'
									),
									array(
											'field'=> 'regatta_start_date',
											'label' => 'Start Date',
											'rules' => 'trim|xss_clean|callback_date_compare'
									),
									array(
											'field'=> 'regatta_end_date',
											'label' => 'End Date',
											'rules' => 'trim|xss_clean|callback_check_end_date'
									),
									array(
											'field'=> 'regatta_description',
											'label' => 'Description',
											'rules' => 'trim|xss_clean|addslashes'
									)
								),
				'classes_create' =>	array(
									array(
											'field'=> 'name',
											'label' => 'Class Name',
											'rules' => 'trim|required|xss_clean'
									),
									array(
											'field'=> 'description',
											'label' => 'Class Description',
											'rules' => 'trim|xss_clean|addslashes'
									),
									array(
											'field'=> 'race_count',
											'label' => 'Number of Races',
											'rules' => 'trim|required|integer|xss_clean'
									),
									array(
											'field'=> 'discards',
											'label' => 'Number of Discards',
											'rules' => 'trim|is_natural|xss_clean'
									),
									array(
											'field'=> 'rating_system_id',
											'label' => 'Rating System',
											'rules' => 'trim|required|is_natural_no_zero|xss_clean'
									),
									array(
											'field'=> 'tiebreak_system',
											'label' => 'Tiebreak System',
											'rules' => 'trim|required|is_natural_no_zero|xss_clean'
									),
									array(
											'field'=> 'scoring_system',
											'label' => 'Scoring System',
											'rules' => 'trim|required|is_natural_no_zero|xss_clean'
									),
									array(
											'field'=> 'boats[]',
											'label' => 'Boats in Class',
											'rules' => 'trim|integer|xss_clean'
									),
								),
				'owner/create' =>	array(
									array(
											'field'=> 'name',
											'label' => 'Name',
											'rules' => 'trim|string|required|xss_clean'
									),
									array(
											'field'=> 'email',
											'label' => 'Email Address',
											'rules' => 'trim|valid_email|xss_clean'
									),
									array(
											'field'=> 'phone',
											'label' => 'Phone Number',
											'rules' => 'trim|xss_clean'
									)
								),
				'handicap' => array(
									array(
											'field' => 'system_name',
											'label' => 'Handicap System Name',
											'rules' => 'trim|string|required|xss_clean'
										),
									array(
											'field' => 'handicap_value',
											'label' => 'Handicap Value',
											'rules' => 'trim|required|numeric|xss_clean'
										)
					)
				);
?>