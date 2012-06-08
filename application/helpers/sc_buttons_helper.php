<?

if(!defined('BASEPATH')) die('This script cannot be run alone');

function sc_button($action, $text, $classes=null){
// Function to output a button in the UI
// Paremeters:	$params: array
//						action - the url to go to on click
//						classes
//						priority - primary, secondary, tertiary

	if(!isset($classes)) $classes = "secondary center";
	if($type == 'link') $action = $url;

	$buttonCode = '<div class="button '. $classes . '">
					<a href="'. $action .'">'. $text .'</a>
					</div>';
	return $buttonCode;
}

?>