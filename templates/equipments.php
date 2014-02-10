<?php $title = _('Équipements - laclef.cc'); ?>

<?php ob_start() ?>
<section>
  <div class="box">
    <table class="ink-table alternating hover" data-page-size="10">
      <thead>
        <tr>
          <th><?php echo _('UID'); ?></th>
          <th class="content-left"><?php echo _('Nom'); ?> <i class="icon-sort-by-alphabet"></i></th>
          <th class="content-left hide-small hide-medium"><?php echo _('Description'); ?></th>
          <th class="content-left"><?php echo _('État'); ?></th>
          <th class="content-left"><?php echo _('Actions'); ?></th>
	    	</tr>
	    </thead>
			<tbody>
			  <?php foreach ($equipments as $equipment): ?>
			    <tr>
			      <td><?php echo $equipment['uid']; ?></td>
			      <td><?php echo $equipment['name']; ?></td>
						<td class="hide-small hide-medium"><?php echo $equipment['description']; ?></td>
						<td><?php if($equipment['hirer']) echo '<span class="ink-label error invert">' . _("Loué par") . ' ' . $equipment['hirer'] . ' ' . _("jusqu'au") . ' ' . date_to_string($equipment['end']) . '</span>'; else echo '<span class="ink-label success invert">' . _("Disponible") . '</span>'; ?></td>
						<td>
					    <a href="equipment?id=<?php echo $equipment['id']; ?>"><button class="ink-button"><i class="icon-pencil"></i></button></a>
					    <a href="equipment/delete?id=<?php echo $equipment['id']; ?>"><button class="ink-button red"><i class="icon-remove"></i></button></a>
					    <?php
					      if($equipment['hirer'])
					        echo '<a href="equipments/available?id=' . $equipment['id'] . '"><button class="ink-button green"><i class="icon-level-down"></i></button></a>';
					    ?>
				    </td>
			    </tr>
			  <?php endforeach; ?>
			</tbody>
    </table>
    <nav class="ink-navigation"><ul class="pagination rounded shadowed grey"></ul></nav>
  </div>
</section>
<div>
	<button id="equipmentModal" class="ink-button blue"><i class="icon-plus-sign"></i> <?php echo _('Ajouter'); ?></button>
</div>
<div class="ink-shade">
	<div id="equipmentModal" class="ink-modal" data-trigger="#equipmentModal">
		<div class="modal-header">
			<button class="modal-close ink-dismiss"></button>
			<h3><?php echo _('Ajouter un équipement'); ?></h3>
		</div>
		<div class="modal-body" id="modalContent">
			<form id="equipmentForm" class="ink-form" method="post" action="equipments" onsubmit="return Ink.UI.FormValidator.validate(this);">
        <fieldset>
          <div class="control-group required">
            <label for="uid"><?php echo _('UID : '); ?></label>
				    <div class="control">
					    <input type="text" name="uid" id="uid" class="ink-fv-required" />
				    </div>
				    <p class="tip"><?php echo _("Indiquez ici le tag de l'équipement (") . get_tag_icon_html(1) . ' ou ' . get_tag_icon_html(2) . ')'; ?></p>
			    </div>
			    <div class="control-group required">
            <label for="name"><?php echo _('Nom : '); ?></label>
				    <div class="control">
					    <input type="text" name="name" id="name" class="ink-fv-required" />
				    </div>
				    <p class="tip"><?php echo _("Indiquez ici un nom pour l'équipement"); ?></p>
			    </div>
			    <div class="control-group required">
				    <label for="description"><?php echo _('Description : '); ?></label>
				    <div class="control">
					    <input type="text" name="description" id="description" class="ink-fv-required" />
				    </div>
				    <p class="tip"><?php echo _("Indiquez ici une description courte de l'équipement"); ?></p>
			    </div>
			    <h4><?php echo _("Location"); ?></h4>
			    <p><?php echo _("Veuillez remplir les champs ci-dessous pour une nouvelle location : "); ?></p>
			    <div class="control-group">
				    <p class="label"><?php echo _('Emprunteur : '); ?></p>
				    <select name="hirer" class="control unstyled">
				      <option></option>
					    <?php foreach ($uids as $uid): ?>
						    <option><?php echo $uid; ?></option>
					    <?php endforeach; ?>
				    </select>
			    </div>
			    <div class="control-group">
			      <label for="end"><?php echo _('Fin de la location prévue : '); ?></label>
			      <div class="control">
			        <input id="end" name="end" type="text" placeholder="<?php echo date('Y-m-d'); ?>"></input>
			      </div>
			      <p class="tip"><?php echo _("Indiquez ici la date à laquelle l'utilisateur devra rendre l'équipement"); ?></p>
			    </div>
        </fieldset>
				<div class="modal-footer">
					<button class="ink-button caution ink-dismiss"><?php echo _("Annuler"); ?></button>
					<input type="submit" name="sub" value="<?php echo _("Ajouter l'équipement"); ?>" class="ink-button success green" />
				</div>
			</div><!--/.modal-body -->
		</form>
	</div><!--/.ink-modal -->
</div><!--/.ink-shade -->
<?php $content = ob_get_clean() ?>
<?php include 'layout.php' ?>
