<?
	
	foreach($boats as &$boat){
		$boat->link = base_url('boats/view') . '/' .$boat->id .'/rest';
	}
		// --------------------- Array Output  ------------------------
		print "<pre>";
		print_r($boats);
		print "</pre>";
		// --------------------- End Array Output  --------------------
?>

	<?=stripslashes(json_encode($boats))?>