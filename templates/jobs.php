<?php $title = _('Impressions 3D - laclef.cc'); ?>

<?php ob_start() ?>
<?php if($error_message_active) echo '<div class="ink-alert basic error"><button class="ink-dismiss">×</button><p><b>' . _('Erreur : ') . '</b> ' . _('Le montant doit être positif !') . '</p></div>'; ?>
<section>
	<div class="box">
		<table class="ink-table alternating hover" data-page-size="10">
			<thead>
				<tr>
					<th class="content-left"><?php echo _('Devis'); ?></th>
					<th class="content-left"><?php echo _('UID'); ?></th>
					<th class="content-left"><?php echo _('Fichier'); ?></th>
					<th class="content-left hide-small hide-medium"><?php echo _("Durée"); ?></th>
					<th class="content-left hide-small hide-medium"><?php echo _("Filament"); ?></th>
					<th class="content-left hide-small hide-medium"><?php echo _("Livraison"); ?></th>
					<th class="content-left"><?php echo _('Statut'); ?></th>
					<th class="content-left"><?php echo _('Prix'); ?></th>
					<th class="content-left"><?php echo _('Actions'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($jobs as $job): ?>
					<tr>
						<td class ="small"><?php echo datetime_to_string($job['timestamp']); ?></td>
						<td><?php echo $job['uid']; ?></td>
						<td><a href="/models/<?php echo $job['file']; ?>"><?php echo $job['file']; ?></td>
						<td class="hide-small hide-medium"><?php echo $job['duration']; ?></td>
						<td class="hide-small hide-medium"><?php echo money_format('%!nm', $job['filament']); ?></td>
						<td class="hide-small hide-medium"><?php echo date_to_string($job['delivery']); ?></td>
						<?php
							if($job['status'] == 0)
								echo '<td><span class="ink-label error">'. _("Non traité") . '</span></td>';
							elseif ($job['status'] == 1)
								echo '<td><span class="ink-label warning">'. _("Traitement") . '</span></td>';
							else
								echo '<td><span class="ink-label success">'. _("Livré") . '</span></td>';
						?>
						<td><?php echo money_format('%!n&euro;', $job['price']); ?></td>
						<td>
							<?php
								if ($job['status'] == 1)
									echo '<a href="job/checkout?id=' . $job['id'] .'"><button class="ink-button green"><i class="icon-shopping-cart"></i></button></a>';
								if ($job['status'] != 2)
									echo '<a href="job?id=' . $job['id']. '"><button class="ink-button"><i class="icon-pencil"></i></button></a>';
							?>
							<a href="job/delete?id=<?php echo $job['id']; ?>"><button class="ink-button red"><i class="icon-remove"></i></button></a>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<nav class="ink-navigation"><ul class="pagination rounded shadowed grey"></ul></nav>
	</div>
</section>
<div>
	<button id="jobModal" class="ink-button blue"><i class="icon-plus-sign"></i> <?php echo _('Nouvelle impression 3D'); ?></button>
</div>
<div class="ink-shade">
	<div id="jobModal" class="ink-modal" data-trigger="#jobModal">
		<div class="modal-header">
			<button class="modal-close ink-dismiss"></button>
			<h3><?php echo _('Nouvelle impression 3D'); ?></h3>
		</div>
		<div class="modal-body" id="modalContent">
			<form id="jobForm" class="ink-form" method="post" action="jobs" onsubmit="return Ink.UI.FormValidator.validate(this);">
				<fieldset>
					<div class="control-group required">
						<p class="label"><?php echo _('Bénéficiaire : '); ?></p>
						<select name="uid" class="control unstyled">
							<?php
								foreach ($users as $user)
									echo "<option value=" . $user['uid'] . ">" . $user['firstname'] . " " . $user['lastname'] . "</option>";
							?>
						</select>
					</div>
					<div class="control-group required">
						<label for="file"><?php echo _('Fichier : '); ?></label>
						<div class="control">
							<input type="text" name="file" id="file" class="ink-fv-required" />
						</div>
						<p class="tip"><?php echo _("Indiquez ici le chemin relatif vers le fichier .stl"); ?></p>
					</div>
					<div class="control-group required">
						<label for="duration"><?php echo _('Durée estimée : '); ?></label>
						<div class="control">
							<input type="text" name="duration" id="duration" class="ink-fv-required" />
						</div>
						<p class="tip"><?php echo _("Indiquez ici la durée estimée par Cura"); ?></p>
					</div>
					<div class="control-group required">
						<label for="filament"><?php echo _('Filament consommé : '); ?></label>
						<div class="control">
							<input type="text" name="filament" id="filament" class="ink-fv-required" />
						</div>
						<p class="tip"><?php echo _("Indiquez ici la longueur estimée de filament"); ?></p>
					</div>
					<div class="control-group">
						<label for="delivery"><?php echo _('Date de livraison estimée : '); ?></label>
						<div class="control">
							<input id="delivery" name="delivery" type="text" placeholder="<?php echo date('Y-m-d'); ?>"></input>
						</div>
						<p class="tip"><?php echo _("Indiquez ici la date d'impression de l'objet"); ?></p>
					</div>
					<div class="control-group required">
						<label for="price"><?php echo _('Prix : '); ?></label>
						<div class="control">
							<input type="text" name="price" id="price" class="ink-fv-required" placeholder="2.30" />
						</div>
					</div>
				</fieldset>
				<div class="modal-footer">
					<button class="ink-button caution ink-dismiss"><?php echo _("Annuler"); ?></button>
					<input type="submit" name="sub" value="<?php echo _("Ajouter l'impression"); ?>" class="ink-button success green" />
				</div>
			</div><!--/.modal-body -->
		</form>
	</div><!--/.ink-modal -->
</div><!--/.ink-shade -->
<?php $content = ob_get_clean() ?>
<?php include 'layout.php' ?>
