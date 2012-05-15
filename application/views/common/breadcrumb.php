<? if($breadcrumb): ?>
<? 
	$items = sizeof($breadcrumb);
?>
<ul class="breadcrumb">
	<? foreach($breadcrumb as $b):?>
		<? if($b['current'] == true):?>
			<li class="active"><?=$b['title'];?></li>
		<? else:?>
			<li>
				<a href="<?=base_url($b['url']);?>" title="<?=$b['title'];?>"><?=$b['title'];?></a>
				<span class="divider">/</span>
			</li>
		<? endif;?>
	<? endforeach;?>
</ul>
<? endif;?>