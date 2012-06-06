<? if(isset($breadcrumb)): ?>
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

	<? if(isset($help)):?>
		<li class="pull-right"><a class="show-help">Show Help <i class="icon-chevron-down"></i></a></li>
	<? endif;?>
</ul>
<? endif;?>