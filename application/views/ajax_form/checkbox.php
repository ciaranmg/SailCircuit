<?
	$data = array(
              'name'        => $field,
              'id'          => $field,
              'value'       => 1,
              'checked' => ($value == 1) ? true : false,
            );
?>
<?=form_checkbox($data); ?>
