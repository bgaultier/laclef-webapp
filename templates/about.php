<?php $title = _('À propos - laboîte.cc'); ?>

<?php ob_start() ?>
  <div class="column-group vertical-space">
		<div class="box large-50 medium-100 small-100 push-center">
			<div class="space">
				<h2><?php echo _('laclef-webapp v0.1'); ?></h2>
				<p><?php echo _("Cette application incroyable est développée avec fougue et détermination par <a href=\"http://baptistegaultier.fr/website/Accueil.html\">Baptiste Gaultier</a>. En 2013, Baptiste trouva amusant de programmer une application web capable d'interagir avec de nombreux objets (l'amusement se dissipa après avoir passer ses vacances et ses nuits à coder") . ' <i class="icon-smile"></i>)<br/>' . _("Le code de cette application est open source (<a href=\"http://www.gnu.org/licenses/agpl-3.0.fr.html\">GPL Affero v3</a>), ce qui signifie qu'il peut être être téléchargé gratuitement <a href=\"https://github.com/bgaultier/laclef-webapp\">ici</a>, modifié, redistribué et amélioré par tous."); ?></p>
      <img style="display: block; margin-left: auto; margin-right: auto;" src="templates/images/agpl-v3-logo.svg">
			</div>
		</div>
	</div>
<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>
