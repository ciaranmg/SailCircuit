<?
$config['boats_meta'] = array(
							'age' => array(
							'field' => 'age',
							'label' => 'Age',
							'type' => 'text'
								),
							'age_group' => array(
							'field' => 'age_group',
							'label' => 'Age Group',
							'type' => 'text'
								),
							'helm' => array(
							'field' => 'helm',
							'label' => 'Helm',
							'type' => 'text'
								),
							'bow_number' => array(
							'field' => 'bow_number',
							'label' => 'Bow Number',
							'type' => 'text',
								),
							'alt_sail_number' => array(
							'field' => 'alt_sail_number',
							'label' => 'Alternative Sail Number',
							'type' => 'text',
								),
							'_image' => array(
							'field' => '_image',
							'label' => 'Image',
							'type' => 'file',
							'single' => true
								),
							'notes' => array(
							'field' => 'notes',
							'label' => 'Notes',
							'type' => 'text',
								),
							'fleet' => array(
							'field' => 'fleet',
							'label' => 'Fleet',
							'type' => 'text',
							'single' => true
								),
							'crew' => array(
							'field' => 'crew',
							'label' => 'Crew',
							'type' => 'text',
								));

$config['classes_meta'] = array(
							'notes' => array(
								'field' => 'notes',
								'label' => 'Notes',
								'type' => 'text',
								),
							'sponsor_message' => array(
								'field' => 'sponsor_message',
								'label' => 'Sponsor Message',
								'type' => 'text',
								'single' => true
								),
							'_race_columns' => array(
								'field' => '_race_columns',
								'label' => 'Race Columns',
								'type' => 'array'
								),
							'_class_columns' => array(
								'field' => '_class_columns',
								'label' => 'Class Columns',
								'type' => 'array'
								),
							'_race_settings' => array(
								'field' => '_race_settings',
								'label' => 'General Race Settings',
								'type' => 'array'
								),
							'_class_settings' => array(
								'field' => '_class_settings',
								'label' => 'Class Settings',
								'type' => 'array',
								),
							'_image' => array(
								'field' => '_image',
								'label' => 'Sponsor Image',
								'type' => 'file',
								'single' => true
								));
							
$config['regatta_meta'] = array(
							'notes' => array(
							'field' => 'notes',
							'label' => 'Notes',
							'type' => 'text',
								),
							'sponsor_message' => array(
							'field' => 'sponsor_message',
							'label' => 'Sponsor Message',
							'type' => 'text',
							'single' => true
								),
							'_image' => array(
							'field' => '_image',
							'label' => 'Sponsor Image',
							'type' => 'file',
							'single' => true
								),
							'file' => array(
							'field' => 'file',
							'label' => 'File',
							'type' => 'file'
								)
							);
$config['club_meta'] = array(
							'notes' => array(
							'field' => 'notes',
							'label' => 'Notes',
							'type' => 'text',
								),
							'sponsor_message' => array(
							'field' => 'sponsor_message',
							'label' => 'Sponsor Message',
							'type' => 'text',
							'single' => true
								),
							'_image' => array(
							'field' => '_image',
							'label' => 'Sponsor Image',
							'type' => 'file',
							'single' => true
								));