<div class="container_12">
	<section class="grid_12 leading">
		<div class="message error">
			<? if(isset($message)): ?>
				<h3><?=$message['title']?></h3>
				<p><?=$message['text']?></p>
			<? else: ?>
				<h3>Not Found</h3>
			<? endif;?>
		</div>
	</section>
</div>