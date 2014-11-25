<?php $title = _("Modifier l'équipement - laclef.cc"); ?>

<?php ob_start() ?>
<h3 class="ink-form top-space"><?php echo _('Modifier un équipement'); ?></h3>
<div class="box">
	<form id="equipmentForm" class="ink-form" method="post" action="equipments" onsubmit="return Ink.UI.FormValidator.validate(this);">
		<fieldset>
			<input type="hidden" name="id" id="id" value="<?php echo $equipment['id']; ?>" hidden />
			<div class="control-group required">
				<label for="uid"><?php echo _('UID : '); ?></label>
				<div class="control">
					<input type="text" name="uid" id="uid" class="ink-fv-required" value="<?php echo $equipment['uid']; ?>" />
				</div>
				<p class="tip"><?php echo _("Indiquez ici le tag de l'équipement (") . get_tag_icon_html(1) . ' ou ' . get_tag_icon_html(2) . ')'; ?></p>
			</div>
			<div class="control-group required">
				<label for="name"><?php echo _('Nom : '); ?></label>
				<div class="control">
					<input type="text" name="name" id="name" class="ink-fv-required" value="<?php echo $equipment['name']; ?>" />
				</div>
				<p class="tip"><?php echo _("Indiquez ici un nom pour l'équipement"); ?></p>
			</div>
			<div class="control-group required">
				<label for="description"><?php echo _('Description : '); ?></label>
				<div class="control">
					<input type="text" name="description" id="description" class="ink-fv-required" value="<?php echo $equipment['description']; ?>" />
				</div>
				<p class="tip"><?php echo _("Indiquez ici une description courte de l'équipement"); ?></p>
			</div>
			<h4>Location</h4>
			<p><?php echo _("Veuillez remplir les champs ci-dessous pour une nouvelle location : "); ?></p>
			<div class="control-group">
				<p class="label"><?php echo _('Emprunteur : '); ?></p>
				<select name="hirer" class="control unstyled">
					<?php foreach ($uids as $uid): ?>
						<option <?php if($equipment['hirer'] == $uid) echo 'selected="selected" '; ?>value="<?php echo $uid; ?>"><?php echo $uid; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="control-group">
				<label for="end"><?php echo _('Fin de la location prévue : '); ?></label>
				<div class="control">
					<input id="end" name="end" type="text" value="<?php if($equipment['end']) echo $equipment['end']; ?>" placeholder="<?php echo date('Y-m-d'); ?>"></input>
				</div>
				<p class="tip"><?php echo _("Indiquez ici la date à laquelle l'utilisateur devra rendre l'équipement"); ?></p>
			</div>
		</fieldset>
		<div>
			<input type="submit" name="sub" value="<?php echo _("Sauvegarder les modifications"); ?>" class="ink-button success green" />
		</div>
	</form>
	<div>
		<a href="equipment/delete?id=<?php echo $equipment['id']; ?>"><button class="ink-button red"><i class="icon-remove"></i> <?php echo _("Supprimer l'équipement"); ?></button></a>
	</div>
</div>
<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>
