<?php $title = _('Kfet - laclef.cc'); ?>

<?php ob_start() ?>
  <header class="vertical-space">
    <h1 class="pull-left medium-100 small-100"><i class="icon-coffee"></i> Kfet <small style="font-family: 'Kreon', serif;">laclef.cc</small></h1>
    <nav class="ink-navigation pull-right hide-medium hide-small">
      <ul class="menu horizontal grey rounded shadowed">
        <li><a href="login"><?php echo _('Administration'); ?></a></li>
        <li><a href="signup"><?php echo _('Inscription'); ?></a></li>
        <li><a href="kfet"><?php echo _('Aide'); ?></a></li>
      </ul>
    </nav>
  </header>
  <div class="column-group">
		<div class="box large-80 medium-80 small-100 push-center">
		  <a href="dashboard"><button class="ink-button caution ink-dismiss"><i class="icon-chevron-left"></i> <?php echo _("Revenir"); ?></button></a>
			<div class="space">
			  <h3><?php echo _('Ajouter un utilisateur depuis le LDAP de Télécom Bretagne'); ?></h3>
        <p><?php echo _("Veuillez sélectionner votre nom dans la liste ci-dessous pour créer un nouveau compte. Si votre compte n'apparaît pas, merci de contacter <a href=\"mailto:baptiste.gaultier@telecom-bretagne.eu?Subject=Kfet signup problem\">Baptiste</a>. "); ?></p>
        <div>
          <nav class="ink-navigation vertical-space" style="font-weight : bold;">
            <ul class="menu vertical rounded grey">
              <?php
                usort($users, cmp);
                foreach ($users as $user): ?>
                <li><a href="signup?uid=<?php echo $user['uid']; ?>"><?php echo $user['firstname'] . ' ' . $user['lastname']; ?> <i class="icon-chevron-right push-right"></i></a></li>
              <?php endforeach; ?>
            </ul>
          </nav>
        </div>
		  </div>
	</div>
<?php $content = ob_get_clean() ?>
<?php include 'layout.php' ?>  
