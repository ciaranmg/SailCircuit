<?
function is_ajax(){
    return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'));
}

function ucomp($a, $b){
	return intval($a->points) > intval($b->points);
}
?>