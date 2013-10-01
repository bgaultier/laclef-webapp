<?php $title = _('Connexion - laclef.cc'); ?>

<?php ob_start() ?>
	<div class="column-group vertical-space">
		<div class="box large-50 medium-100 small-100 push-center">
			<div class="space">
				<h3><?php echo _('Modifier votre compte'); ?></h3>
				<form class="ink-form" method="post" action="account">
					<fieldset>
						<div class="control-group required">
						  <label for="uid"><?php echo _('UID : '); ?></label>
				      <div class="control">
					      <input type="text" name="uid" id="uid" class="ink-fv-required" value="<?php echo $user['uid']; ?>" disabled />
				      </div>
			      </div>
			      <div class="control-group required">
						  <label for="uid"><?php echo _('Adresse email : '); ?></label>
				      <div class="control">
					      <input type="text" name="email" id="email" class="ink-fv-required" value="<?php echo $user['email']; ?>" disabled />
				      </div>
			      </div>
			      <div class="control-group required">
			        <label for="pass"><?php echo _('Modifier le mot de passe : '); ?></label>
			        <div class="control">
			          <input type="password" name="password" id="password" placeholder="<?php echo _('Ancien mot de passe'); ?>" class="ink-fv-required ink-fv-confirm" />
			        </div>
			      </div>
			      <div class="control-group required">
			        <div class="control">
			          <input type="password" name="password" id="password" placeholder="<?php echo _('Nouveau mot de passe'); ?>" class="ink-fv-required ink-fv-confirm" />
			        </div>
			      </div>
			      <div class="control-group">
			        <p class="label"><?php echo _('Langue : '); ?></p>
			        <select name="locale" class="control unstyled">
			          <option <?php if($user['locale'] == 'en_US') echo 'selected="selected" '; ?>value="en_US">en_US</option>
			          <option <?php if($user['locale'] == 'fr_FR') echo 'selected="selected" '; ?>value="fr_FR">fr_FR</option>
			        </select>
			      </div>
					</fieldset>
					<div>
						<button name="sub" class="ink-button success green large-100" type="submit"><i class="icon-ok-circle"></i> <?php echo _(' Enregistrer les modifications'); ?></input>
					</div>
				</form>
				<a href="logout"><button class="ink-button orange warning large-100" style="margin-top : 1.5em;"><i class="icon-signout"></i> <?php echo _("Déconnexion"); ?></button></a>
			</div>
		</div>
	</div>
<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>
