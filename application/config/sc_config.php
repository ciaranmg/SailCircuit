<?
/**
 * Config File for General SailCircuit settings
 */

// With Debug enabled Codeigniter will output profiler information
$config['sc_debug'] = true;


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
?>