<?php $title = _("Modifier le produit - laclef.cc"); ?>

<?php ob_start() ?>
<h3 class="ink-form top-space"><?php echo _('Modifier un produit'); ?></h3>
<div class="box">
  <form id="tagForm" class="ink-form" method="post" action="snacks" onsubmit="return Ink.UI.FormValidator.validate(this);">
    <fieldset>
      <div class="control-group required">
        <label for="id"><?php echo _('ID : '); ?></label>
				<div class="control">
					<input type="text" name="id" id="id" class="ink-fv-required" value="<?php echo $snack['id']; ?>" />
				</div>
				<p class="tip"><?php echo _("Indiquez ici l'identifiant unique du produit"); ?></p>
			</div>
			<div class="control-group required">
				<label for="description_fr_FR"><?php echo _('Description (français) : '); ?></label>
				<div class="control">
					<input type="text" name="description_fr_FR" id="description_fr_FR" class="ink-fv-required" value="<?php echo $snack['description_fr_FR']; ?>" />
				</div>
			</div>
			<div class="control-group required">
				<label for="description_en_US"><?php echo _('Description (anglais) : '); ?></label>
				<div class="control">
					<input type="text" name="description_en_US" id="description_en_US" class="ink-fv-required" value="<?php echo $snack['description_en_US']; ?>" />
				</div>
			</div>
			<div class="control-group required">
				<label for="price"><?php echo _('Prix : '); ?></label>
				<div class="control">
					<input type="text" name="price" id="price" class="ink-fv-required" value="<?php echo $snack['price']; ?>" />
				</div>
			</div>
	    <div class="control-group">
				<input type="checkbox" name="visible" id="visible" <? if($snack['visible'] == 1) echo 'checked="checked" '; ?>>
				<label for="visible"><?php echo _('Visible dans les tableaux de bord'); ?></label>
			</div>
    </fieldset>
		<div>
			<input type="submit" name="sub" value="<?php echo _("Sauvegarder les modifications"); ?>" class="ink-button success green" />
		</div>
	</form>
	<div>
	  <a href="tag/delete?uid=<?php echo $tag['uid']; ?>"><button class="ink-button red"><i class="icon-remove"></i> <?php echo _("Supprimer le tag"); ?></button></a>
	</div>
</div>
<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>
