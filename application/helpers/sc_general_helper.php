<?
function is_ajax(){
    return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'));
}


function hcap_format($h, $name){
	if($name == 'ECHO' OR $name == 'IRC'){
		return number_format(floatval($h), 3, '.', '');
	}else{
		return $h;
	}
}


/**
 * Series of functions for comparing elements in objects, or arrays for use in the usort function
 */

function cmp_corrected_time($a, $b){
	if($b->corrected_time == 0 OR $b->corrected_time == null) {
		return -1;
	}
	return intval($a->corrected_time) > intval($b->corrected_time);
}

function cmp_position($a, $b){
	return $a->position > $b->position;
}

function cmp_lowpoints($a, $b){
 	return $a->series_points > $b->series_points;
}

function array_elements($fields, $data, $defaults = null){
	$return_array = array();
	$i=0;
	foreach($data as $x){
		foreach($fields as $field){
			if(!isset($x[$field]) OR $x[$field] === '' OR  $x[$field] === null ){
				if(is_array($defaults)){
					$return_array[$i][$field] = $defaults[$field];
				}else{
					$return_array[$i][$field] = $defaults;
				}
			}else{
				$return_array[$i][$field] = $x[$field];
			}
		}
		$i++;
	}

	return $return_array;
}


?>