<?php $title = _("Modifier les permissions - laclef.cc"); ?>

<?php ob_start() ?>
<h3 class="ink-form top-space"><?php echo _('Modifier les permissions'); ?></h3>
<div class="box">
  <form id="permissionForm" class="ink-form" method="post" action="readers" onsubmit="return Ink.UI.FormValidator.validate(this);">
    <fieldset>
      <div class="control-group required">
        <label for="id"><?php echo _('ID : '); ?></label>
        <select name="id" class="control unstyled">
					<?php foreach ($ids as $id): ?>
						<option <?php if($permission['id'] == $id) echo 'selected="selected" '; ?>value="<?php echo $id; ?>"><?php echo $id; ?></option>
					<?php endforeach; ?>
				</select>
				<p class="tip"><?php echo _("Indiquez ici l'identifiant unique du lecteur auquel l'utilisateur ci-dessous pourra accéder"); ?></p>
			</div>
			<div class="control-group required">
				<p class="label"><?php echo _('Utilisateur : '); ?></p>
				<select name="uid" class="control unstyled">
					<?php foreach ($uids as $uid): ?>
						<option <?php if($permission['uid'] == $uid) echo 'selected="selected" '; ?>value="<?php echo $uid; ?>"><?php echo $uid; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="control-group">
			  <label for="end"><?php echo _('Date de fin : '); ?></label>
			  <div class="control">
			    <input id="end" name="end" type="text" value="<?php echo $permission['end']; ?>" placeholder="2013-10-12 13:37:00"></input>
			  </div>
			</div>
			<p class="tip"><?php echo _("Indiquez ici la date à laquelle l'utilisateur ne pourra plus accéder au lecteur décrits ci-dessus"); ?></p>
    </fieldset>
		<div>
			<input type="submit" name="sub" value="<?php echo _("Sauvegarder les modifications"); ?>" class="ink-button success green" />
		</div>
	</form>
	<div>
		<a href="permission/delete?id=<?php echo $permission['id']; ?>"><button class="ink-button red"><i class="icon-remove"></i> <?php echo _("Supprimer la permission"); ?></button></a>
  </div>
</div>
<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>
