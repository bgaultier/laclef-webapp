<?php $title = _('Stock - laclef.cc'); ?>

<?php ob_start() ?>
	<section>
		<div class="column-group gutters">
			<?php foreach ($items as $item): ?>
            <div class="large-33 medium-33 small-100">
				<div class="box">
					<h1><?php echo $item['stocks'] . ' ' . $item['unit']; if (intval($item['stocks']) > 1) echo 's'; ?></h1>
					<p class="small"><?php echo $item['name']; ?></p>
				</div>
            </div>
			<?php endforeach; ?>
		</div>
	</section>
	<nav class="ink-navigation">
		<ul class="pills shadowed rounded ">
			<li><a href="/checkin"><i class="fa fa-plus-square" aria-hidden="true"></i> <?php echo _('Ajout'); ?></a></li>
			<li><a href="/checkout"><i class="fa fa-minus-square" aria-hidden="true"></i> <?php echo _('Retrait'); ?></a></li>
		</ul>
	</nav>
	<section>
		<div class="box">
			<table class="ink-table" data-page-size="10">
				<thead>
					<tr>
						<th class="content-left"><?php echo _('Date'); ?></th>
						<th class="content-left"><?php echo _('Article'); ?></th>
						<th class="content-left"><?php echo _('Client'); ?></th>
						<th class="content-left"><?php echo _('Quantité'); ?></th>
						<th class="content-left"><?php echo _('Actions'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($checkouts as $checkout):
						  $item = get_item_by_id($checkout['item']); ?>
						<tr>
							<td class="small"><?php echo datetime_to_string($checkout['timestamp']); ?></td>
							<td><?php echo $item['name']; ?></span></td>
							<td><?php echo get_customer_by_id($checkout['customer'])['name']; ?></span></td>
							<td><span <?php
										if(intval($checkout['checkin?']) == 0)
											echo ' class="ink-badge red">-';
										else echo ' class="ink-badge green">+';
									  ?><?php echo $checkout['quantity'] . ' ' .  $item['unit']; if (intval($checkout['quantity']) > 1) echo 's'; ?></span></td>
							<td>
	  							<a href="checkout/delete?id=<?php echo $checkout['id']; ?>"><button class="ink-button red"><i class="icon-trash"></i></button></a>
	  						</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<nav class="ink-navigation"><ul class="pagination rounded shadowed grey"></ul></nav>
		</div>
	</section>
	<div>
	  <button id="itemModal" class="ink-button blue push-left"><i class="icon-plus-sign"></i> <?php echo _('Ajouter un objet'); ?></button>
	  <button id="customerModal" class="ink-button blue push-left"><i class="icon-plus-sign"></i> <?php echo _('Ajouter un client'); ?></button>
	</div>
	<div class="ink-shade">
		<div id="itemModal" class="ink-modal" data-trigger="#itemModal">
			<div class="modal-header">
				<button class="modal-close ink-dismiss"></button>
				<h3><?php echo _('Ajouter un objet'); ?></h3>
			</div>
			<div class="modal-body" id="modalContent">
				<form id="itemForm" class="ink-form" method="post" action="" onsubmit="return Ink.UI.FormValidator.validate(this);">
					<fieldset>
						<div class="control-group required">
							<label for="name"><?php echo _('Nom : '); ?></label>
							<div class="control">
								<input type="text" name="name" id="name" class="ink-fv-required" />
							</div>
							<p class="tip"><?php echo _('Indiquez ici un nom simple pour votre objet (exemple : Sac de café)'); ?></p>
						</div>
						<div class="control-group required">
							<label for="unit"><?php echo _('Unité : '); ?></label>
							<div class="control">
								<input type="text" name="unit" id="unit" class="ink-fv-required" />
							</div>
							<p class="tip"><?php echo _('Indiquez ici une unité pour cet objet (exemple : sac ou paquet)'); ?></p>
						</div>
						<div class="control-group required">
							<label for="alert_on"><?php echo _("Seuil d'alerte : "); ?></label>
							<div class="control">
								<input type="number" name="alert_on" id="alert_on" class="ink-fv-required" />
							</div>
							<p class="tip"><?php echo _('Indiquez ici un seuil pour recevoir une alerte (un chiffre entier)'); ?></p>
						</div>
					</fieldset>
					<div class="modal-footer">
						<button class="ink-button caution ink-dismiss"><?php echo _("Annuler"); ?></button>
						<input type="submit" name="sub" value="<?php echo _("Ajouter l'objet"); ?>" class="ink-button success green" />
					</div>
				</div><!--/.modal-body -->
			</form>
		</div><!--/.ink-modal -->
	</div><!--/.ink-shade -->
	<div class="ink-shade">
		<div id="customerModal" class="ink-modal" data-trigger="#customerModal">
			<div class="modal-header">
				<button class="modal-close ink-dismiss"></button>
				<h3><?php echo _('Ajouter un client'); ?></h3>
			</div>
			<div class="modal-body" id="modalContent">
				<form id="customerForm" class="ink-form" method="post" action="" onsubmit="return Ink.UI.FormValidator.validate(this);">
					<fieldset>
						<div class="control-group required">
							<label for="customer_name"><?php echo _('Nom : '); ?></label>
							<div class="control">
								<input type="text" name="customer_name" id="customer_name" class="ink-fv-required" />
							</div>
							<p class="tip"><?php echo _('Indiquez ici un nom pour le client (exemple : entreprise extérieure)'); ?></p>
						</div>
					</fieldset>
					<div class="modal-footer">
						<button class="ink-button caution ink-dismiss"><?php echo _("Annuler"); ?></button>
						<input type="submit" name="sub" value="<?php echo _("Ajouter le client"); ?>" class="ink-button success green" />
					</div>
				</div><!--/.modal-body -->
			</form>
		</div><!--/.ink-modal -->
	</div><!--/.ink-shade -->
<?php $content = ob_get_clean() ?>
<?php include 'layout.php' ?>
