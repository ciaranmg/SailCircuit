<? if($breadcrumb): ?>
<? 

	$items = sizeof($breadcrumb);
	$currentItem = 1;
?>
<ul class="breadcrumb">
	<? foreach($breadcrumb as $b):?>
		<? if($b['current'] === true): ?>
			<li class="active"><?$b['title'];?></li>
		<? else:?>
			<li>
				<a href="<?$b['url'];?>" title="<?=$b['title'];?>">
					<?=$b['title'];?>
				</a>
				<span class="divider">/</span>
			</li>
		<? endif;?>
	<? endforeach;?>
</ul>
<? endif;?>