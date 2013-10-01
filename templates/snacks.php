<?php $title = _('Produits - laclef.cc'); ?>

<?php ob_start() ?>
<section>
  <div class="box">
    <table class="ink-table alternating hover" data-page-size="10">
      <thead>
        <tr>
          <th class="content-left hide-small hide-medium"><?php echo _('ID'); ?></th>
          <th class="content-left"><?php echo _('Description'); ?></th>
          <th class="content-left"><?php echo _('Prix'); ?></th>
          <th class="content-left hide-small hide-medium"><?php echo _('Visible'); ?></th>
          <th class="content-left"><?php echo _('Actions'); ?></th>
	    	</tr>
	    </thead>
			<tbody>
			  <?php foreach ($snacks as $snack): ?>
			    <tr>
			      <td class="hide-small hide-medium"><?php echo $snack['id']; ?></td>
			      <td><?php echo $snack['description_' . getenv('LANG')]; ?></td>
						<td><?php echo $snack['price']; ?></td>
						<td class="hide-small hide-medium"><?php if($snack['visible'] == 1) echo '<i class="icon-ok" style="margin-left:12px;"></i>'; ?></td>
						<td>
					    <a href="snack?id=<?php echo $snack['id']; ?>"><button class="ink-button"><i class="icon-pencil"></i></button></a>
					    <a href="snack/delete?id=<?php echo $snack['id']; ?>"><button class="ink-button red"><i class="icon-remove"></i></button></a>
				    </td>
			    </tr>
			  <?php endforeach; ?>
			</tbody>
    </table>
    <nav class="ink-navigation"><ul class="pagination rounded shadowed grey"></ul></nav>
  </div>
</section>
<div>
	<button id="snackModal" class="ink-button blue"><i class="icon-plus-sign"></i> <?php echo _('Ajouter'); ?></button>
</div>
<div class="ink-shade">
	<div id="snackModal" class="ink-modal" data-trigger="#snackModal">
		<div class="modal-header">
			<button class="modal-close ink-dismiss"></button>
			<h3><?php echo _('Ajouter un produit'); ?></h3>
		</div>
		<div class="modal-body" id="modalContent">
			<form id="snackForm" class="ink-form" method="post" action="snacks" onsubmit="return Ink.UI.FormValidator.validate(this);">
				<fieldset>
					<div class="control-group required">
						<label for="description_fr_FR"><?php echo _('Description (français) : '); ?></label>
						<div class="control">
							<input type="text" name="description_fr_FR" id="description_fr_FR" class="ink-fv-required" />
						</div>
					</div>
					<div class="control-group required">
						<label for="description_en_US"><?php echo _('Description (anglais) : '); ?></label>
						<div class="control">
							<input type="text" name="description_en_US" id="description_en_US" class="ink-fv-required" />
						</div>
					</div>
					<div class="control-group required">
						<label for="price"><?php echo _('Prix : '); ?></label>
						<div class="control">
							<input type="text" name="price" id="price" class="ink-fv-required" />
						</div>
					</div>
			    <div class="control-group">
						<input type="checkbox" name="visible" id="visible">
						<label for="visible"><?php echo _('Visible dans les tableaux de bord'); ?></label>
					</div>
				</fieldset>
				<div class="modal-footer">
					<button class="ink-button caution ink-dismiss"><?php echo _("Annuler"); ?></button>
					<input type="submit" name="sub" value="<?php echo _("Ajouter le produit"); ?>" class="ink-button success green" />
				</div>
			</div><!--/.modal-body -->
		</form>
	</div><!--/.ink-modal -->
</div><!--/.ink-shade -->
<?php $content = ob_get_clean() ?>
<?php include 'layout.php' ?>
