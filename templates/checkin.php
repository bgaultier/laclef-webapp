<?php $title = _("Ajouter au stock - laclef.cc"); ?>

<?php ob_start() ?>
<h3 class="ink-form top-space"><?php echo _('Ajouter au stock'); ?></h3>
<div class="box">
	<form id="checkinForm" class="ink-form" method="post" action="stocks" onsubmit="return Ink.UI.FormValidator.validate(this);">
		<fieldset>
			<input type="hidden" name="checkin" id="checkin" value="1" />
			<div class="control-group">
				<p class="label"><?php echo _('Objet à ajouter : '); ?></p>
				<select name="item" class="control unstyled">
					<?php foreach ($items as $item): ?>
						<option value="<?php echo $item['id']; ?>"><?php echo $item['name']; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="control-group">
				<p class="label"><?php echo _('Quantité : '); ?></p>
				<select name="quantity" class="control unstyled large-10">
					<?php
						for ($i = 1; $i <= 10; $i++)
							echo "<option>$i</option>";
					?>
				</select>
			</div>
		</fieldset>
		<div>
			<input type="submit" name="sub" value="<?php echo _("Ajouter au stock"); ?>" class="ink-button success green" />
		</div>
	</form>
	<a href="/stocks"><button class="ink-button"><?php echo _("Annuler"); ?></button></a>
</div>
<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>
