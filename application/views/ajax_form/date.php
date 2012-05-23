<?
	$data = array(
              'name'        => $field,
              'id'          => $field,
              'value'       => sc_date_format($value),
              'class'       => 'date',
              'type'		=> 'date'
            );
?>
<?=form_input($data); ?>
<script>
	$('#<?=$field;?>').datepicker({dateFormat: datelocale});
</script>
