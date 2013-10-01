<?php $title = _('Connexion - laclef.cc'); ?>

<?php ob_start() ?>
	<div class="column-group vertical-space">
		<div class="box large-50 medium-100 small-100 push-center">
			<div class="space">
				<h3><?php echo _('Connexion'); ?></h3>
				<form class="ink-form" method="post" action="login">
					<fieldset>
						<div class="control-group">
							<div class="control">
								<input type="text" name="uid" id="uid" placeholder="<?php echo _("Nom d'utilisateur"); ?>" />
							</div>
						</div>
						<div class="control-group">
							<div class="control">
								<input type="password" name="password" id="password" placeholder="<?php echo _('Mot de passe'); ?>" />
							</div>
						</div>
					</fieldset>
					<div>
						<button name="sub" class="ink-button success" type="submit"><span class="icon-signin"></span> <?php echo _('Connexion'); ?></input>
					</div>
				</form>
			</div>
		</div>
	</div>
<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>
