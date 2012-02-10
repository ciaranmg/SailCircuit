<section class="portlet leading" id="boatOwners">
	<header>
		<h2>Owners</h2>
	</header>
	<section>
		<dl>
			<? foreach($owners as $owner):?>
				<dt class="expander">
					<?=$owner->name?>
						<dd>Phone: <?=$owner->phone?></dd>
						<dd>Email: <a href="mailto:<?=$owner->email?>"><?=$owner->email?></a></dd>
				</dt>
			<? endforeach;?>
		</dl>
	</section>
	<section>
		<? if($this->userlib->check_permission('owner/create')): ?>
			<a href="owner/create/<?=$boat->id?>" class="button" title="Add Owner">Add Owner</a>
		<? endif;?>
	</section>
</section>