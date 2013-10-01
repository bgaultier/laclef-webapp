<?php $title = _('À propos - laboîte.cc'); ?>

<?php ob_start() ?>
  <div class="container">
    <div class="form-signin" style="max-width : 600px;">
      <h2 class="form-signin-heading"><?php echo _('laboîte-webapp v0.1'); ?></h2>
      <p class="lead"><?php echo _("Cette application géniale est dévellopée par <a href=\"http://baptistegaultier.fr/website/Accueil.html\">Baptiste Gaultier</a> dont le plan secret est de conquérir le monde avec ses boîtes. Le code de cette application est open source (<a href=\"http://www.gnu.org/licenses/agpl-3.0.fr.html\">GPL Affero v3</a>), ce qui signifie qu'il peut être être téléchargé gratuitement <a href=\"https://github.com/bgaultier/laboite-webapp\">ici</a>, modifié, redistribué et amélioré par tous."); ?></p>
      <img style="display: block; margin-left: auto; margin-right: auto;" src="templates/images/agpl-v3-logo.svg">
  </div> <!-- /container -->
<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>
