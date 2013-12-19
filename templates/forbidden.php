<?php $title = _('Kfet - laclef.cc'); ?>

<?php ob_start() ?>
  <header class="vertical-space">
    <h1 class="pull-left medium-100 small-100"><i class="icon-coffee"></i> Kfet <small style="font-family: 'Kreon', serif;">laclef.cc</small></h1>
    <nav class="ink-navigation pull-right hide-medium hide-small">
      <ul class="menu horizontal grey rounded shadowed">
        <li><a href="users"><?php echo _('Administration'); ?></a></li>
      </ul>
    </nav>
  </header>
  <div class="column-group gutters">
  	<div class="ink-alert block error">
  		<button class="ink-dismiss">×</button>
  		<h4>Connexion interdite</h4>
  		<ul>
  			<li>Vous ne pouvez pas vous connecter depuis un réseau externe à Télécom Bretagne</li>
  			<li>Merci de contacter <a href=\"mailto:baptiste.gaultier@telecom-bretagne.eu?Subject=Kfet connection\">Baptiste</a> pour plus d'informations.</li>
  		</ul>
  	</div>
  </div>
<?php $content = ob_get_clean() ?>
<?php include 'layout.php' ?>  
