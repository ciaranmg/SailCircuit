<?

/**
 * Function that accepts a race_data object array, and returns the race position.
 *	Parameters:
 *					array(objects) $entries 		A race_data array. containing elapsed time, finish time, handicap etc.
 *					int $n 							An integer value 
 */

function series_entry($entries, $n){
		
		return count($entries) + $n;

	}

	
?>