<?
/**
 * Config File for General SailCircuit settings
 */

// With Debug enabled Codeigniter will output profiler information
$config['sc_debug'] = false;


// Maximum number of races a class can have
$config['sc_class_max_races'] = 50;

$config['race_status_options'] = array(
							'completed' => 'Completed',
							'dnc' => 'DNC',		// Did not come to the starting area
							'dns' => 'DNS',		// Did not start
							'ocs' => 'OCS',		// Over the start line
							'bfd' => 'BFD',		// Black Flag disqualification
							'dnf' => 'DNF',		// Did Not Finish
							'raf' => 'RAF',		// Retired after Finishing
							'oot' => 'OOT',		// Out of Time
							'dne' => 'DNE',		// Disqualification Not excludable
							'dgm' => 'DGM',		// Disqualification for Gross Misconduct
							'dsq' => 'DSQ',		// Disqualified
							'zfp' => 'ZFP',		// Z flag penalty
							'rdg' => 'RDG',		// Redress given
							'scp' => 'SCP',		// Scoring Penalty
							'Custom' => 'Other'	// Other
							);
$config['sc_non_discardable'] = array('DNE', 'DGM');
$config['sc_image_sizes'] = array(
							'large' => array('width' => 640, 'height' => 400),
							'medium' => array('width'=> 320, 'height' => 200),
							'small' => array('width' => 170, 'height' => 100)
							);

// Default values for the columns that can be displayed on the results pages
$config['class_columns'] = array(
							'fleet' => false,
							'age' => false,
							'owner' => true,
							'sail_number' => true,
							'boat_type' => false,
							'handicap' => true,
							'bow_number' => false,
							'alt_sail_number' => false,
							'crew' => false,
							);
$config['race_columns'] = array(
							'fleet' => false,
							'age' => false,
							'owner' => true,
							'sail_number' => true,
							'to_win' => true,
							'boat_type' => false,
							'handicap' => true,
							'bow_number' => false,
							'alt_sail_number' => false,
							'crew' => false,
							);
?>