<? 
if(!isset($options)){
	$options = array('class'=>'');
}
?>
<div class="btn-group pull-right">
		<? foreach($buttons as $button): 
		?>
			<? if($this->userlib->check_permission(str_replace('#', '', $button['action']))): ?>
					<? if(!isset($button['type']) OR $button['type'] == 'link'): ?>
						<a href="<?=base_url($button['action']) .'/' .$button['parameters']?>" class="btn <?=$button['classes']?>" title="<?=$button['title'];?>" <? if(isset($button['attributes'])) echo $button['attributes'];?> >
							<? if(isset($button['icon'])) echo '<i class="icon-'. $button['icon'] .'"></i> '; ?>
							<?=$button['title']?>
						</a>
					<? elseif($button['type'] == 'event'): ?>
						<a class="btn <?=$button['classes']?>" title="<?=$button['title'];?>" <? if(isset($button['attributes'])) echo $button['attributes'];?>>
							<? if(isset($button['icon'])) echo '<i class="icon-'. $button['icon'] .'"></i> '; ?>
							<?=$button['title']?>
						</a>
					<? elseif($button['type'] == 'submit'): ?>
						<button type="submit" class="btn <?=$button['classes']?>" title="<?=$button['title'];?>" <? if(isset($button['attributes'])) echo $button['attributes'];?>>
							<? if(isset($button['icon'])) echo '<i class="icon-'. $button['icon'] .'"></i> '; ?>
							<?=$button['title']?>
						</button>
					<? endif; ?>
			<? endif; ?>
		<? endforeach; ?>
</div>