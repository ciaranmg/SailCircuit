<dl>
	<? foreach($owners as $owner):?>
		<dt class="editable" id="hc_edit_owner_<?=$owner->id;?>" target="<?=base_url('ajax/edit/owner/name/text') . '/' . $owner->id;?>">
			<?=$owner->name?>
		</dt>
		<dd>Phone: <span class="editable" id="hc_edit_phone_<?=$owner->id;?>" target="<?=base_url('ajax/edit/owner/phone/text') . '/' . $owner->id;?>"><?=$owner->phone?></span></dd>
		<dd>Email: <span class="editable" id="hc_edit_email_<?=$owner->id;?>" target="<?=base_url('ajax/edit/owner/email/text') . '/' . $owner->id;?>"><?=$owner->email?></span></a></dd>	
	<? endforeach;?>
</dl>