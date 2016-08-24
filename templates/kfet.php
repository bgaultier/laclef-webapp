<?php
	$title = _('Aide Kfet - laclef.cc');
	$href = "http://api." . $_SERVER['SERVER_NAME'];
?>


<?php ob_start() ?>
	<header class="vertical-space">
		<h1 class="pull-left medium-100 small-100"><i class="icon-coffee"></i> Kfet <small style="font-family: 'Kreon', serif;">laclef.cc</small></h1>
		<nav class="ink-navigation pull-right hide-medium hide-small">
			<ul class="menu horizontal grey rounded shadowed">
					<li><a href="dashboard"><i class="icon-chevron-left"></i> <?php echo _('Retour'); ?></a></li>
				<li><a href="users"><?php echo _('Administration'); ?></a></li>
				<li><a href="signup"><?php echo _('Inscription'); ?></a></li>
				<li><a href="kfet"><?php echo _('Aide'); ?></a></li>
				<li><a href="grid"><i class="icon-th"></i></a></li>
			</ul>
		</nav>
	</header>
	<div class="column-group gutters top-space">
		<div class="large-20 medium-25 small-100">
			<nav id="menu" class="ink-navigation sticky" data-offset-top="70px">
				<ul class="menu vertical rounded grey">
					<li><a class="scrollableLink" href="#overview"><?php echo _("Fonctionnement"); ?></a></li>
					<li><a class="scrollableLink" href="#accounts"><?php echo _("Comptes"); ?></a></li>
					<li><a class="scrollableLink" href="#3dprinting"><?php echo _("Impression 3D"); ?></a></li>
					<li><a class="scrollableLink" href="#api"><?php echo _("API Rest"); ?></a></li>
				</ul>
			</nav>
		</div>
		<div class="large-80 medium-75 small-100">
			<section id="overview">
				<h2><?php echo _("Fonctionnement"); ?></h2>
				<p><?php echo _("Cette application web cafète vous permet de régler vos commandes de la cafète RSM grâce à une magnifique interface."); ?></p>
				<h3><?php echo _("Votre compte est dans le négatif ?"); ?></h3>
				<p><?php echo _("Rendez-vous sans plus tarder dans le bureau de Laurent et donnez lui de l’argent :)"); ?></p>
				<h3><?php echo _('À quoi sert le bouton "Café express" ?'); ?></h3>
				<p><?php echo _("Il vous permet de commander directement un café sans gobelet et ainsi retourner plus rapidement à votre travail."); ?></p>
				<h3><?php echo _("Vous n’êtes pas dans la liste des utilisateurs ?"); ?></h3>
				<p><?php echo _('Veuillez cliquer sur le bouton "Inscription" en haut de cette page pour créer un nouveau compte. Si votre compte n\'apparaît pas, merci de contacter <a href="mailto:baptiste.gaultier@telecom-bretagne.eu?Subject=Kfet signup problem">Baptiste</a>. '); ?></p>
				<h3><?php echo _("Vous souhaitez accéder à l’appli cafète depuis votre bureau ?"); ?></h3>
				<p><?php echo _('Entrez l’adresse suivante dans votre navigateur internet : <a href="http://laclef.cc/dashboard">laclef.cc/dashboard</a>.'); ?></p>
			</section>
			<section id="accounts">
				<h3><?php echo _("Votre compte est dans le négatif ?"); ?></h3>
				<p><?php echo _("Rendez-vous sans plus tarder dans le bureau de Laurent, Nicolas ou Baptiste et donnez leur de l’argent :)"); ?></p>
			</section>
			<section id="3dprinting">
				<h3><?php echo _("Vous souhaitez commander une impression 3D ?"); ?></h3>
				<p><?php echo _('Envoyez un email à <a href="mailto:3dprinting@laclef.cc?Subject=3D print request">3dprinting@laclef.cc</a> avec votre fichier .stl et la couleur que vous souhaitez (voir les couleurs diponibles ci-dessous). Vous recevrez sous quelques jours un devis à valider. Votre compte kfet sera ensuite prélevé du montant du devis si vous acceptez celui-ci.'); ?></p>
				<div><strong>Ultimaker PLA</strong></div>
				<div><a href="https://shop.ultimaker.com/product/24/PLARed" target="_blank">Red</a> <i class="fa fa-square" style="color:#e21912"></i></div>
				<div><a href="https://shop.ultimaker.com/product/25/PLABlue" target="_blank">Blue</a> <i class="fa fa-square" style="color:#191ec7"></i></div>
				<div style="margin-top:8px;"><strong>colorFabb PLA</strong><div>
				<div><a href="http://colorfabb.com/signal-yellow" target="_blank">Signal Yellow</a> <i class="fa fa-square" style="color:#FFEB3A"></i></div>
				<div><a href="http://colorfabb.com/blue-grey" target="_blank">Blue Grey</a> <i class="fa fa-square" style="color:#97B1CC"></i></div>
								<div><a href="http://colorfabb.com/naturel" target="_blank">Naturel</a> <i class="fa fa-square" style="color:#F3E9CF"></i></div>
				<div><a href="http://colorfabb.com/intense-green" target="_blank">Intense Green</a> <i class="fa fa-square" style="color:#B7FF1F"></i></div>
				<div><a href="http://colorfabb.com/fluorescent-pink" target="_blank">Fluorescent Pink</a> <i class="fa fa-square" style="color:#FF6BB5"></i></div>
				<div><a href="http://colorfabb.com/sky-blue" target="_blank">Sky Blue</a> <i class="fa fa-square" style="color:#1FAFF9"></i></div>
				<div><a href="http://colorfabb.com/dutch-orange" target="_blank">Dutch Orange</a> <i class="fa fa-square" style="color:#FBB02D"></i></div>
				<div><a href="http://colorfabb.com/light-brown" target="_blank">Light Brown</a> <i class="fa fa-square" style="color:#D9A166"></i></div>
				<div><a href="http://colorfabb.com/woodfill-fine" target="_blank">Woodfill fine</a> <i class="fa fa-square" style="color:#F4DAB8"></i></div>
				<div><a href="http://colorfabb.com/standard-white" target="_blank">Standard White</a> <i class="fa fa-square" style="color:#FFFFFC"></i></div>
				<div><a href="http://colorfabb.com/standard-black" target="_blank">Standard Black</a> <i class="fa fa-square" style="color:#333"></i></div>

			</section>
			<section id="api">
				<h2><?php echo _("API Rest"); ?></h2>
				<p><?php echo _("Les ressources accessibles en utilisant l'API Rest sont décrites ci-dessous : "); ?>
				<section class ="top-space">
					<h3><?php echo _("Utilisateurs"); ?></h3>
					<p><?php echo _("Actions liées aux commandes et à leurs visualisations"); ?>
					<table class="ink-table bordered">
						<thead>
							<tr>
								<th class="content-left"><?php echo _("Ressource"); ?></th>
								<th class="content-left"><?php echo _("Description"); ?></th>
							</tr>
						</thead>
						<tbody>
								<tr>
								<td><a href="<?php echo $href; ?>/users/$uid" ><span class="ink-label info">GET</span> /users/$uid</a></td>
								<td><?php echo _('Obtenir les informations de l\'utilisateur <span style="color:#0069D6;">$uid</span>.'); ?></td>
							</tr>
							<tr>
								<td><a href="<?php echo $href; ?>/stats/$uid" ><span class="ink-label info">GET</span> /stats/$uid</a></td>
								<td><?php echo _('Obtenir les statistiques de consommation de l\'utilisateur <span style="color:#0069D6;">$uid</span>.'); ?></td>
							</tr>
							<tr>
								<td><a href="<?php echo $href; ?>/payments/$uid" ><span class="ink-label info">GET</span> /payments/$uid</a></td>
								<td><?php echo _('Obtenir le montant et la date des paiements effectués par l\'utilisateur <span style="color:#0069D6;">$uid</span>.'); ?></td>
							</tr>
							<tr>
								<td><a href="<?php echo $href; ?>/snacks" ><span class="ink-label info">GET</span> /snacks</a></td>
								<td><?php echo _("Obtenir la liste de tous les produits."); ?></td>
							</tr>
							<tr>
								<td><a href="<?php echo $href; ?>/snacks/$id" ><span class="ink-label info">GET</span> /snacks/$id</a></td>
								<td><?php echo _('Obtenir les informations du produit <span style="color:#0069D6;">$id</span>.'); ?></td>
							</tr>
							<tr>
								<td><a href="<?php echo $href; ?>/swipes/$id" ><span class="ink-label info">POST</span> /swipes/$id</a></td>
								<td><?php echo _('Effectuer un passage de tag sur le lecteur <span style="color:#0069D6;">$id</span>.'); ?></td>
							</tr>
							<tr>
								<td><a href="<?php echo $href; ?>/coffees/$uid" ><span class="ink-label info">POST</span> /coffees/$uid</a></td>
								<td><?php echo _('Effectuer le paiement d\'un café pour l\'utilisateur <span style="color:#0069D6;">$uid</span>.'); ?></td>
							</tr>
							<tr>
								<td><a href="<?php echo $href; ?>/jobs/$uid" ><span class="ink-label info">GET</span> /jobs/$uid</a></td>
								<td><?php echo _('Obtenir le suivi des impressions 3D de l\'utilisateur <span style="color:#0069D6;">$uid</span>.'); ?></td>
							</tr>
						</tbody>
					</table>
				</section>
			</section>
		</div>
	</div>
<style>
	li {
		list-style: none;
	}
</style>
<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>
