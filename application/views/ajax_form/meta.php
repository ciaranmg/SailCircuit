<?=form_dropdown('meta_name', $meta_options, 0);?>
<?=form_hidden('controller', $controller);?>
<?=form_hidden('object_id', $object_id);?>
<?=form_input(array('name' => 'text_meta', 'id' => 'text_meta_' .$object_id, 'class' => 'input-medium'));?>
