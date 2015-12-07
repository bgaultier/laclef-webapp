<?php $title = _('Paiements - laclef.cc'); ?>

<?php ob_start() ?>
<?php if($error_message_active) echo '<div class="ink-alert basic error"><button class="ink-dismiss">×</button><p><b>' . _('Erreur : ') . '</b> ' . _('Le montant doit être positif !') . '</p></div>'; ?>
<section>
  <div class="box">
    <table class="ink-table alternating hover" data-page-size="10">
      <thead>
        <tr>
          <th class="content-left"><?php echo _('Date'); ?></th>
          <th class="content-left"><?php echo _('UID'); ?></th>
          <th class="content-left hide-small hide-medium"><?php echo _('Prénom'); ?></th>
          <th class="content-left hide-small hide-medium"><?php echo _('Nom'); ?></th>
          <th class="content-left"><?php echo _('Montant'); ?></th>
	    	</tr>
	    </thead>
			<tbody>
			  <?php foreach ($payments as $payment): ?>
			    <tr>
			      <td class ="small"><?php echo datetime_to_string($payment['timestamp']); ?></td>
			      <td><?php echo $payment['uid']; ?></td>
						<td class="hide-small hide-medium"><?php echo $payment['firstname']; ?></td>
						<td class="hide-small hide-medium"><?php echo $payment['lastname']; ?></td>
						<td><?php echo money_format('%!n&euro;', $payment['amount']); ?></td>
			    </tr>
			  <?php endforeach; ?>
			</tbody>
    </table>
    <nav class="ink-navigation"><ul class="pagination rounded shadowed grey"></ul></nav>
  </div>
</section>
<div>
	<button id="paymentModal" class="ink-button blue"><i class="icon-money"></i> <?php echo _('Créditer un compte'); ?></button>
</div>
<div class="ink-shade">
	<div id="paymentModal" class="ink-modal" data-trigger="#paymentModal">
		<div class="modal-header">
			<button class="modal-close ink-dismiss"></button>
			<h3><?php echo _('Créditer un compte'); ?></h3>
		</div>
		<div class="modal-body" id="modalContent">
			<form id="paymentForm" class="ink-form" method="post" action="payments" onsubmit="return Ink.UI.FormValidator.validate(this);">
				<fieldset>
					<div class="control-group required">
						<p class="label"><?php echo _('Bénéficiaire : '); ?></p>
						<select name="uid" class="control unstyled">
                            <?php
        				    	foreach ($users	as $user)
        				    		echo "<option value=" . $user['uid'] . ">" . $user['firstname'] . " " . $user['lastname'] . "</option>";
        				    ?>
						</select>
					</div>
					<div class="control-group required">
						<label for="amount"><?php echo _('Montant : '); ?></label>
						<div class="control">
							<input type="text" name="amount" id="amount" class="ink-fv-required" placeholder="2.30" />
						</div>
					</div>
				</fieldset>
				<div class="modal-footer">
					<button class="ink-button caution ink-dismiss"><?php echo _("Annuler"); ?></button>
					<input type="submit" name="sub" value="<?php echo _("Créditer le compte"); ?>" class="ink-button success green" />
				</div>
			</div><!--/.modal-body -->
		</form>
	</div><!--/.ink-modal -->
</div><!--/.ink-shade -->
<?php $content = ob_get_clean() ?>
<?php include 'layout.php' ?>
