<?php $title = _("Modifier l'utilisateur - laclef.cc"); ?>

<?php ob_start() ?>
<h3 class="ink-form top-space"><?php echo _('Modifier un utilisateur'); ?></h3>
<div class="box">
	<form id="userForm" class="ink-form" method="post" action="users" onsubmit="return Ink.UI.FormValidator.validate(this);">
		<fieldset>
			<div class="control-group">
				<label for="uid"><?php echo _('UID : '); ?></label>
				<div class="control">
					<input type="text" name="uid" id="uid" value="<?php echo $user['uid']; ?>" />
				</div>
			</div>
			<div class="control-group required">
				<label for="firstname"><?php echo _('Prénom : '); ?></label>
				<div class="control">
					<input type="text" name="firstname" id="firstname" class="ink-fv-required" value="<?php echo $user['firstname']; ?>" />
				</div>
			</div>
			<div class="control-group required">
				<label for="lastname"><?php echo _('Nom : '); ?></label>
				<div class="control">
					<input type="text" name="lastname" id="lastname" class="ink-fv-required" value="<?php echo $user['lastname']; ?>" />
				</div>
			</div>
			<div class="control-group required">
				<label for="email"><?php echo _('Email : '); ?></label>
				<div class="control">
					<input type="text" name="email" id="email" class="ink-fv-required ink-fv-email" value="<?php echo $user['email']; ?>" />
				</div>
			</div>
			<div class="control-group">
				<label for="pass"><?php echo _('Mot de passe : '); ?></label>
				<div class="control">
					<input type="password" name="password" id="password" />
				</div>
				<p class="tip"><?php echo _('Le mot de passe est obligatoire pour les administrateurs'); ?></p>
			</div>
			<div class="control-group">
				<input type="checkbox" name="admin" id="admin">
				<label for="admin"><?php echo _('Administrateur'); ?></label>
			</div>
		</fieldset>
		<div>
			<input type="submit" name="sub" value="<?php echo _("Sauvegarder les modifications"); ?>" class="ink-button success green" />
		</div>
	</form>
	<div>
		<a href="user/delete?uid=<?php echo $user['uid']; ?>"><button class="ink-button red dismiss"><i class="icon-remove"></i> <?php echo _("Supprimer l'utilisateur"); ?></button></a>
	</div>
</div>
<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>
