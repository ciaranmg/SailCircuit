<? if($breadcrumb): ?>
<? 

	$items = sizeof($breadcrumb);
	$currentItem = 1;
?>
<div id="breadcrumb">
	<ul>
		<? foreach($breadcrumb as $b):?>
			<li>
				<? if($b['current'] == true):?>
					<span><?=$b['title']?></span>
				<? else:?>
					<a href="<?=$b['url']?>" title="<?=$b['title']?>">
						<?=$b['title']?>
					</a>
				<? endif;?>
				<? echo ($currentItem < $items) ? ' > ' : ''; ?>
				<? $currentItem++; ?>
			</li>
		<? endforeach;?>
	</ul>
</div>
<? endif;?>