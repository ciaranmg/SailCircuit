<?
	$data = array(
              'name'        => $field,
              'id'          => $field,
              'value'       => $value,
              'class'       => 'text',
              'rows'		=> 5,
              'cols'		=> 30
            );
?>
<?=form_textarea($data); ?>
