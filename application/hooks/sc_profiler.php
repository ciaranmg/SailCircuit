<?
function sc_profiler(){
	$CI =& get_instance();
	if(!is_ajax() && $CI->config->item('sc_debug'))	$CI->output->enable_profiler(TRUE);
}
?>