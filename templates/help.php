<?php
  $title = _('Aide - laclef.cc');
  $href = "http://api." . $_SERVER['SERVER_NAME'];
?>


<?php ob_start() ?>
<div class="column-group gutters top-space">
  <div class="large-20 medium-25 small-100">
    <nav id="menu" class="ink-navigation sticky" data-offset-top="70px">
      <ul class="menu vertical rounded grey">
        <li><a class="scrollableLink" href="#overview"><?php echo _("Vue d'ensemble"); ?></a></li>
        <li><a class="scrollableLink" href="#users"><?php echo _("Utilisateurs"); ?></a></li>
        <li><a class="scrollableLink" href="#tags"><?php echo _("Tags"); ?></a></li>
        <li><a class="scrollableLink" href="#readers"><?php echo _("Lecteurs"); ?></a></li>
        <li><a class="scrollableLink" href="#permissions"><?php echo _("Permissions"); ?></a></li>
        <li><a class="scrollableLink" href="#equipments"><?php echo _("Équipements"); ?></a></li>
        <li><a class="scrollableLink" href="#swipes"><?php echo _("Historique des lectures"); ?></a></li>
        <li><a class="scrollableLink" href="#api"><?php echo _("API Rest"); ?></a></li>
      </ul>
    </nav>
  </div>
  <div class="large-80 medium-75 small-100">
    <section id="overview">
      <h2><?php echo _("Vue d'ensemble"); ?></h2>
      <p><?php echo _("L'application web laclef permet une gestion facilitée de tags (RFID/NFC, QR code, code-barres...) permettant à des utilisateurs d'accéder aux services suivants :"); ?>
        <ul>
          <li><?php echo _("<strong>Contrôle d'accès : </strong>ouvrir des portes selon leurs droits."); ?></li>
          <li><?php echo _("<strong>Gestion de cafétéria : </strong>payer leurs consommations (cafés, barres chocolatées, fruits)."); ?></li>
          <li><?php echo _("<strong>Prêt de matériel : </strong>louer des équipements."); ?></li>
      </p>
    </section>
    <section id="users">
      <h2><?php echo _("Utilisateurs"); ?></h2>
      <p><?php echo _("Les utilisateurs peuvent être identifiés par un ou plusieurs"); ?> <a href="#tags"><?php echo _("tags"); ?></a><?php echo _(". Seuls les administrateurs (utilisateurs dotés de droits d'administrations) peuvent créer, modifier et supprimer les"); ?> <a href="#tags"><?php echo _("tags"); ?></a>, <a href="#readers"><?php echo _("lecteurs"); ?></a> <?php echo _("et"); ?> <a href="#permissions"><?php echo _("permissions"); ?></a>.</p>
    </section>
    <section id="tags">
      <h2><?php echo _("Tags"); ?></h2>
      <p><?php echo _("Les tags sont des étiquettes digitales (RFID/NFC, QR code, code-barres) permettant d'identifier de manière unique un "); ?> <a href="#users"><?php echo _("utilisateur"); ?></a><?php echo _(" ou un "); ?> <a href="#equipments"><?php echo _("équipement"); ?></a>.</p>
    </section>
    <section id="readers">
      <h2><?php echo _("Lecteurs"); ?></h2>
      <p><?php echo _("Les lecteurs permettent de lire les"); ?> <a href="#tags"><?php echo _("tags"); ?></a>. <?php echo _("La lecture d'un tag peu provoquer différentes actions : l'ouverture d'une porte, le paiement d'un café, le début d'une location de matériel..."); ?></p>
    </section>
    <section id="permissions">
      <h2><?php echo _("Permissions"); ?></h2>
      <p><?php echo _("Les permissions sont définies par les administrateurs. Si une permission est créée pour un"); ?> <a href="#users"><?php echo _("utilisateur"); ?></a> <?php echo _("sur un"); ?> <a href="#readers"><?php echo _("lecteur"); ?></a> <?php echo _("alors celui-ci pourra ouvrir la porte pilotée par le lecteur."); ?></p>
    </section>
    <section id="equipments">
      <h2><?php echo _("Équipements"); ?></h2>
      <p><?php echo _("Un équipement est identifié par un"); ?> <a href="#tags"><?php echo _("tag"); ?></a> <?php echo _("unique. Il peut être loué par un "); ?> <a href="#users"><?php echo _("utilisateur"); ?></a>.</p>
    </section>
    <section id="swipes">
      <h2><?php echo _("Historique des lectures"); ?></h2>
      <p><?php echo _("Permet d'avoir un historique des lectures de"); ?> <a href="#tags"><?php echo _("tags"); ?></a>.</p>
    </section>
    <section id="api">
      <h2><?php echo _("API Rest"); ?></h2>
      <p><?php echo _("Les ressources accessibles en utilisant l'API Rest sont décrites ci-dessous : "); ?>
      <section id="api-users" class ="top-space" style="border-top: 1px solid rgb(204, 204, 204);">
        <h3><?php echo _("Utilisateurs"); ?></h3>
        <p><?php echo _("Actions liées à l'ajout, la suppression et l'affichage d'informations relatives aux utilisateurs."); ?></p>
        <table class="ink-table bordered">
          <thead>
            <tr>
              <th class="content-left"><?php echo _("Ressource"); ?></th>
              <th class="content-left"><?php echo _("Description"); ?></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><a href="<?php echo $href; ?>/users" ><span class="ink-label info">GET</span> /users</a></td>
              <td><?php echo _("Obtenir la liste de tous les utilisateurs."); ?></td>
            </tr>
            <tr>
              <td><a href="<?php echo $href; ?>/users/$uid" ><span class="ink-label info">GET</span> /users/$uid</a></td>
              <td><?php echo _('Obtenir les informations de l\'utilisateur <span style="color:#0069D6;">$uid</span>.'); ?></td>
            </tr>
            <tr>
              <td><a href="<?php echo $href; ?>/stats/$uid" ><span class="ink-label info">GET</span> /stats/$uid</a></td>
              <td><?php echo _('Obtenir les statistiques de consommation de l\'utilisateur <span style="color:#0069D6;">$uid</span>.'); ?></td>
            </tr>          
          </tbody>
        </table>
      </section>
      <section id="api-tags" class ="top-space" style="border-top: 1px solid rgb(204, 204, 204);">
        <h3><?php echo _("Tags"); ?></h3>
        <p><?php echo _("Actions liées à l'ajout, la suppression et l'affichage d'informations relatives aux tags."); ?></p>
        <table class="ink-table bordered">
          <thead>
            <tr>
              <th class="content-left"><?php echo _("Ressource"); ?></th>
              <th class="content-left"><?php echo _("Description"); ?></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><a href="<?php echo $href; ?>/tags" ><span class="ink-label info">GET</span> /tags</a></td>
              <td><?php echo _("Obtenir la liste de tous les tags."); ?></td>
            </tr>
            <tr>
              <td><a href="<?php echo $href; ?>/tags/$uid" ><span class="ink-label info">GET</span> /tags/$uid</a></td>
              <td><?php echo _('Obtenir les informations du tag <span style="color:#0069D6;">$uid</span>.'); ?></td>
            </tr>
          </tbody>
        </table>
      </section>
      <section id="api-readers" class ="top-space" style="border-top: 1px solid rgb(204, 204, 204);">
        <h3><?php echo _("Lecteurs"); ?></h3>
        <p><?php echo _("Actions liées à l'ajout, la suppression et l'affichage d'informations relatives aux lecteurs de tags."); ?></p>
        <table class="ink-table bordered">
          <thead>
            <tr>
              <th class="content-left"><?php echo _("Ressource"); ?></th>
              <th class="content-left"><?php echo _("Description"); ?></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><a href="<?php echo $href; ?>/readers" ><span class="ink-label info">GET</span> /readers</a></td>
              <td><?php echo _("Obtenir la liste de tous les lecteurs."); ?></td>
            </tr>
            <tr>
              <td><a href="<?php echo $href; ?>/readers/$id" ><span class="ink-label info">GET</span> /readers/$id</a></td>
              <td><?php echo _('Obtenir les informations du lecteur <span style="color:#0069D6;">$id</span>.'); ?></td>
            </tr>
          </tbody>
        </table>
      </section>
      <section id="api-payments" class ="top-space" style="border-top: 1px solid rgb(204, 204, 204);">
        <h3><?php echo _("Paiements"); ?></h3>
        <p><?php echo _("Actions liées à l'affichage d'informations relatives aux dépôts effectués par les utilisateurs."); ?></p>
        <table class="ink-table bordered">
          <thead>
            <tr>
              <th class="content-left"><?php echo _("Ressource"); ?></th>
              <th class="content-left"><?php echo _("Description"); ?></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><a href="<?php echo $href; ?>/payments/$uid" ><span class="ink-label info">GET</span> /payments/$uid</a></td>
              <td><?php echo _('Obtenir le montant et la date des paiements effectués par l\'utilisateur <span style="color:#0069D6;">$uid</span>.'); ?></td>
            </tr>
          </tbody>
        </table>
      </section>
      <section id="api-snacks" class ="top-space" style="border-top: 1px solid rgb(204, 204, 204);">
        <h3><?php echo _("Produits"); ?></h3>
        <p><?php echo _("Actions liées à l'ajout, la suppression et l'affichage d'informations relatives aux produits vendus."); ?></p>
        <table class="ink-table bordered">
          <thead>
            <tr>
              <th class="content-left"><?php echo _("Ressource"); ?></th>
              <th class="content-left"><?php echo _("Description"); ?></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><a href="<?php echo $href; ?>/snacks" ><span class="ink-label info">GET</span> /snacks</a></td>
              <td><?php echo _("Obtenir la liste de tous les produits."); ?></td>
            </tr>
            <tr>
              <td><a href="<?php echo $href; ?>/snacks/$id" ><span class="ink-label info">GET</span> /snacks/$id</a></td>
              <td><?php echo _('Obtenir les informations du produit <span style="color:#0069D6;">$id</span>.'); ?></td>
            </tr>
          </tbody>
        </table>
      </section>
      <section id="api-swipes" class ="top-space" style="border-top: 1px solid rgb(204, 204, 204);">
        <h3><?php echo _("Lectures des tag"); ?></h3>
        <p><?php echo _("Actions liées à l'ajout, la suppression et l'affichage d'un passage de tag sur un lecteur."); ?></p>
        <table class="ink-table bordered">
          <thead>
            <tr>
              <th class="content-left"><?php echo _("Ressource"); ?></th>
              <th class="content-left"><?php echo _("Description"); ?></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><a href="<?php echo $href; ?>/swipes/$id" ><span class="ink-label info">POST</span> /swipes/$id</a></td>
              <td><?php echo _('Effectuer un passage de tag sur le lecteur <span style="color:#0069D6;">$id</span>.'); ?></td>
            </tr>
            <tr>
              <td><a href="<?php echo $href; ?>/coffees/$uid" ><span class="ink-label info">POST</span> /coffees/$uid</a></td>
              <td><?php echo _('Effectuer le paiement d\'un café pour l\'utilisateur <span style="color:#0069D6;">$uid</span>.'); ?></td>
            </tr>
          </tbody>
        </table>
      </section>
      <section id="api-permissions" class ="top-space" style="border-top: 1px solid rgb(204, 204, 204);">
        <h3><?php echo _("Permissions"); ?></h3>
        <p><?php echo _("Actions liées à l'ajout, la suppression et l'affichage des permissions accordées aux utilisateurs sur un lecteur (il est à noter que si un utilisateur dispose de droits sur un lecteur alors tous les tags de cet utlisateur dispose de ce droit)."); ?></p>
        <table class="ink-table bordered">
          <thead>
            <tr>
              <th class="content-left"><?php echo _("Ressource"); ?></th>
              <th class="content-left"><?php echo _("Description"); ?></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><a href="<?php echo $href; ?>/permissions/$id/$uid" ><span class="ink-label info">GET</span> /permissions/$id/$uid</a></td>
              <td><?php echo _("Obtenir les permissions de l'utilisateur <span style=\"color:#0069D6;\">\$uid</span> sur le lecteur <span style=\"color:#0069D6;\">\$id</span>."); ?></td>
            </tr>
            <tr>
              <td><a href="<?php echo $href; ?>/permissions/$id" ><span class="ink-label info">GET</span> /permissions/$id</a></td>
              <td><?php echo _("Obtenir les utilisateurs autorisés à utiliser le lecteur <span style=\"color:#0069D6;\">\$id</span>."); ?></td>
            </tr>
          </tbody>
        </table>
      </section>
    </section>
  </div>
</div>
<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>
