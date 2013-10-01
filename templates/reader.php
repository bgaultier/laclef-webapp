<?php $title = _("Modifier le lecteur - laclef.cc"); ?>

<?php ob_start() ?>
<h3 class="ink-form top-space"><?php echo _('Modifier un lecteur'); ?></h3>
<div class="box">
  <form id="readerForm" class="ink-form" method="post" action="readers" onsubmit="return Ink.UI.FormValidator.validate(this);">
    <fieldset>
      <div class="control-group required">
        <label for="id"><?php echo _('ID : '); ?></label>
				<div class="control">
					<input type="text" name="id" id="id" class="ink-fv-required" value="<?php echo $reader['id']; ?>" disabled />
				</div>
				<p class="tip"><?php echo _("Indiquez ici l'identifiant unique du lecteur"); ?></p>
			</div>
			<div class="control-group">
				<label for="location"><?php echo _('Emplacement : '); ?></label>
				<div class="control">
					<input type="text" name="location" id="location" value="<?php echo $reader['location']; ?>" />
				</div>
				<p class="tip"><?php echo _("Indiquez ici l'emplacement physique du lecteur de tags"); ?></p>
			</div>
    </fieldset>
		<div>
			<input type="submit" name="sub" value="<?php echo _("Sauvegarder les modifications"); ?>" class="ink-button success green" />
		</div>
	</form>
	<?php if(count($reader['permissions']) > 0) { ?>
	  <div class="control-group top-space">
	    <label><?php echo _('Permissions : '); ?></label>
	    <table class="ink-table bordered alternating hover">
	      <thead>
	        <tr>
	          <th class="content-left"><?php echo _('Utilisateur autorisé'); ?></th>
	          <th class="content-left"><?php echo _('Date de fin'); ?></th>
	          <th class="content-left"><?php echo _('Actions'); ?></th>
	        </tr>
	      </thead>
	      <tbody>
	        <?php
	          foreach ($reader['permissions'] as $permission):
	            echo '<tr><td>' . $permission['uid'] . '</td><td>' . datetime_to_string($permission['end']) . '</td>';
	            echo '<td><a href="permission?uid=' . $permission['uid'] . '&id=' . $reader['id'] . '"><button class="ink-button"><i class="icon-pencil"></i></button></a> <a href="permission/delete?uid=' . $permission['uid'] . '&id=' . $reader['id'] . '"><button class="ink-button red"><i class="icon-trash"></i></button></a></td></tr>';
            endforeach;
          ?>
        </tbody>
	    </table>
	  </div><!--/.control-group -->
	<?php
    }
	?>
	<div class="top-space">
	  <a href="reader/delete?id=<?php echo $reader['id']; ?>"><button class="ink-button red"><i class="icon-remove"></i> <?php echo _("Supprimer le lecteur"); ?></button></a>
	  <a href="reader/all?id=<?php echo $reader['id']; ?>"><button class="ink-button blue"><i class="icon-group"></i> <?php echo _("Ajouter tous les utilisateurs à ce lecteur"); ?></button></a>
	</div>
</div>
<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>
