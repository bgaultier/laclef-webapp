<?php $title = _("Impression 3D - laclef.cc"); ?>

<?php ob_start() ?>
<h3 class="ink-form top-space"><?php echo _('Modifier la tâche'); ?></h3>
<div class="box">
	<form id="jobForm" class="ink-form" method="post" action="jobs" onsubmit="return Ink.UI.FormValidator.validate(this);">
		<fieldset>
      <input type="hidden" name="id" id="id" value="<?php echo $job['id']; ?>" hidden />
			<div class="control-group required">
				<label for="delivery"><?php echo _('Date de livraison estimée : '); ?></label>
				<div class="control">
					<input id="delivery" name="delivery" type="text" class="ink-fv-required" placeholder="<?php echo date('Y-m-d'); ?>" value="<?php echo $job['delivery']; ?>"></input>
				</div>
				<p class="tip"><?php echo _("Indiquez ici la date d'impression de l'objet"); ?></p>
			</div>
			<div class="control-group required">
				<label for="price"><?php echo _('Prix : '); ?></label>
				<div class="control">
					<input type="text" name="price" id="price" class="ink-fv-required" placeholder="2.30" value="<?php echo $job['price']; ?>" />
				</div>
			</div>
		</fieldset>
		<div>
			<input type="submit" name="sub" value="<?php echo _("Enregistrer"); ?>" class="ink-button success green" />
		</div>
	</form>
	<div>
		<a href="job/delete?id=<?php echo $job['id']; ?>"><button class="ink-button red"><i class="icon-remove"></i> <?php echo _("Supprimer"); ?></button></a>
	</div>
</div>
<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>
