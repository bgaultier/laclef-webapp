<?php $title = _("Modifier l'utilisateur - laclef.cc"); ?>

<?php ob_start() ?>
<h3 class="ink-form top-space"><?php echo _('Modifier un Tag'); ?></h3>
<div class="box">
  <form id="tagForm" class="ink-form" method="post" action="tags" onsubmit="return Ink.UI.FormValidator.validate(this);">
    <fieldset>
      <div class="control-group required">
        <label for="uid"><?php echo _('UID : '); ?></label>
				<div class="control">
					<input type="text" name="uid" id="uid" class="ink-fv-required" value="<?php echo $tag['uid']; ?>" />
				</div>
				<p class="tip"><?php echo _("Indiquez ici l'identifiant unique du tag"); ?></p>
			</div>
			<div class="control-group">
				<p class="label"><?php echo _('Type du tag : '); ?></p>
				<ul class="control unstyled">
					<?php $i = 0; foreach ($types as $type): ?>
						<li><input <?php if($tag['type'] == $i) echo 'checked="checked" '; ?>name="type<?php echo $i; ?>" type="radio"><label for="type<?php echo $i; ?>"> <?php echo get_tag_icon_html($i); ?> <?php echo $type;  $i++;?></label></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<div class="control-group">
				<p class="label"><?php echo _('Propriétaire : '); ?></p>
				<select name="owner" class="control unstyled">
					<?php foreach ($uids as $uid): ?>
						<option <?php if($tag['owner'] == $uid) echo 'selected="selected" '; ?>value="<?php echo $uid; ?>"><?php echo $uid; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
    </fieldset>
		<div>
			<input type="submit" name="sub" value="<?php echo _("Sauvegarder les modifications"); ?>" class="ink-button success green" />
		</div>
	</form>
	<div>
	  <a href="tag/delete?uid=<?php echo $tag['uid']; ?>"><button class="ink-button red"><i class="icon-remove"></i> <?php echo _("Supprimer le tag"); ?></button></a>
	</div>
</div>
<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>
