<? 
if(!isset($options)){
	$options = array('class'=>'');
}
?>
<div class="ac">
	<ul class="toolbar clearfix <?=$options['class'];?>" style="display: inline-block;">
		<? foreach($buttons as $button): 
		?>
			<? if($this->userlib->check_permission($button['action'])): ?>
				<li>
					<? if(!isset($button['type']) OR $button['type'] == 'link'): ?>
						<a href="#<?=$button['action'] .'/' .$button['parameters']?>" class="button <?=$button['classes']?>" title="<?=($button['title'] !='') ? $button['title'] : $button['tooltip'];?>">
							<? if(isset($button['icon'])) echo '<img src="'. base_url() .'images/navicons-small/'.$button['icon'].'.png" alt=""/>'; ?>
							<?=$button['title']?>
						</a>
					<? elseif($button['type'] == 'event'): ?>
						<a class="button <?=$button['classes']?>" title="<?=($button['title'] !='') ? $button['title'] : $button['tooltip'];?>">
							<? if(isset($button['icon'])) echo '<img src="'. base_url() .'images/navicons-small/'.$button['icon'].'.png" alt=""/>'; ?>
							<?=$button['title']?>
						</a>
					<? elseif($button['type'] == 'submit'): ?>
						<button type="submit" class="button <?=$button['classes']?>" title="<?=($button['title'] !='') ? $button['title'] : $button['tooltip'];?>">
							<? if(isset($button['icon'])) echo '<img src="'. base_url() .'images/navicons-small/'.$button['icon'].'.png" alt=""/>'; ?>
							<?=$button['title']?>
						</button>
					<? endif; ?>
				</li>
			<? endif; ?>
		<? endforeach; ?>
	</ul>
</div>