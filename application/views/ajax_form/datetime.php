<?

	$date_picker = array(
              'name'        => $field .'[]',
              'id'          => $field.'-1',
              'value'       => $value[0],
              'class'       => 'input-small datepicker required date',
              'type'		=> 'text'
            );
	$time_picker = array(
              'name'        => $field .'[]',
              'id'          => $field.'-2',
              'value'       => $value[1],
              'class'       => 'text input-tiny timepicker required',
              'type'		=> 'text'
            );
?>
<?=form_input($date_picker); ?>  <?=form_input($time_picker);?>
<script type="text/javascript">
       $(function() {
	      $('#<?=$date_picker['id'];?>').datepicker({dateFormat: datelocale});
       });
</script>