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
        <li><a class="scrollableLink" href="#swipes"><?php echo _("Logs"); ?></a></li>
        <li><a class="scrollableLink" href="#api"><?php echo _("API Rest"); ?></a></li>
      </ul>
    </nav>
  </div>
  <div class="large-80 medium-75 small-100">
    <section id="overview">
      <h2><?php echo _("Vue d'ensemble"); ?></h2>
      <p><?php echo _("Vue d'ensemble"); ?></p>
    </section>
    <section id="users">
      <h2><?php echo _("Vue d'ensemble"); ?></h2>
      <p><?php echo _("Vue d'ensemble"); ?></p>
      <p><span class="ink-label info">Tip</span>
    </section>
      <h2><?php echo _("API Rest"); ?></h2>
      <p><?php echo _("Cette application web dispose d'une API REST. Les ressources accessibles sont décrites ci-dessous."); ?>
      <p><?php echo _("Pour plus d'information sur une ressource, veuillez sélectionner sur son nom."); ?></p>
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
              <td><a href="<?php echo $href; ?>/users/$uid" ><span class="ink-label info">GET</span> /users/$uid</a></td>
              <td><?php echo _("Obtenir des informations à propos de l'utilisateur <span style=\"color:#0069D6;\">\$uid</span>."); ?></td>
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
          </tbody>
        </table>
      </section>
    </section>
  </div>
</div>
<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>
