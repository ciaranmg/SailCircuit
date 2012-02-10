<?
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function PYcalc($elapsed, $handicap){
// Function to calculate the corrected time based on RYA PY handicap
// Parameters: 	$elapsed
//				Type: integer, number of seconds of elapsed time
// 				$handicap
//				Type: float, the RYA PY handicap value
// Returns:		integer, number of seconds of corrected time

	if(is_int($elapsed) && is_int($handicap)){
			$tcc = round($elapsed * 1000 / $handicap, 0);
			return $tcc;
		} else {
			return false;
		}
}

function ECHOcalc($elapsed, $handicap){
// Function to calculate the corrected time based on ECHO handicap
// Parameters: 	$elapsed
//				Type: integer, number of seconds of elapsed time
// 				$handicap
//				Type: float, the ECHO handicap value
// Returns:		integer, number of seconds of corrected time

	if(is_int($elapsed) && is_float($handicap)){
			$tcc = round($elapsed * $handicap, 0);
			return $tcc;
		} else {
			return false;
		}
}

function IRCcalc($elapsed, $handicap){
// Function to calculate the corrected time based on IRC handicap
// Parameters: 	$elapsed
//				Type: integer, number of seconds of elapsed time
// 				$handicap
//				Type: float, the IRC handicap value
// Returns:		integer, number of seconds of corrected time

	if(is_int($elapsed) && is_float($handicap)){
			$tcc = round($elapsed * $handicap, 0);
			return $tcc;
		} else {
			return false;
		}
}

function sec2time($sec){
// Function to convert seconds to readable elapsed time
// Parameters:	$sec
//				Type: integer
// Returns:		string
	$returnstring = " ";
	$days = intval($sec/86400);
	$hours = intval ( ($sec/3600) - ($days*24));
	$minutes = intval( ($sec - (($days*86400)+ ($hours*3600)))/60);
	$seconds = $sec - ( ($days*86400)+($hours*3600)+($minutes * 60));

	$returnstring .= ($days)?(($days == 1) ? "1 Day " : sprintf("%02d", $days). " Days ") : "";
	$returnstring .= ($days && $hours && !$minutes && !$seconds) ? "" : "";
	$returnstring .= ($days > 0 && $hours == 0)? "00:": "";
	$returnstring .= ($hours)?( ($hours == 1) ? "01:" : sprintf("%02d", $hours) .":") : "";
	$returnstring .= (($days || $hours) && ($minutes && !$seconds))?"":"";
	$returnstring .= ($minutes)?( ($minutes == 1)?"1:": sprintf("%02d", $minutes) .":"):"";
	$returnstring .= (($days || $hours || $minutes) && $seconds)?"":" ";
	$returnstring .= ($seconds)?( ($seconds == 1)?"1": sprintf("%02d", $seconds)):"";
	if ($returnstring != " ") return ($returnstring);
}

function time2sec($time){
// Function to convert elapsed time to seconds
// Parameters: 	$time
//				Type: string
//				Format: dd:hh:mm:ss
// Returns:		integer

	$day = 86400;
	$hour = 3600;
	$minute = 60;

	$tc = explode(":", $time, 4);
	if(!is_array($tc)) return false;
	if(sizeof($tc)== 2){
		
		// This time has only minutes and seconds
		$seconds = (intval($tc[0]) * $minute) + (intval($tc[1]));
	}elseif(sizeof($tc) == 3){
	
		// This time has hours minutes and seconds
		$seconds = (intval($tc[0]) * $hour) + (intval($tc[1]) * $minute) + intval($tc[2]);
	}elseif(sizeof($tc) == 4){
		
		// This time has days, hours, and minutes
		$seconds = (intval($tc[0]) * $day) + (intval($tc[1]) * $hour) + (intval($tc[2]) * $minute) + intval($tc[3]);
	}else{
		// Something is wrong
		return false;
	}
	
	return $seconds;
}

function sc_date_format($date){
	return date('d/m/Y', $date);
}

function sc_db_datetime_format($mysqlDate){
	return date("F j, Y g:i a ", strtotime($mysqlDate));
}

function sc_php2db_timestamp($timestamp){
	return date('Y-m-d H:i:s', $timestamp);
}

?>