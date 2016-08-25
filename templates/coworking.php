<?php $title = _('Cotravail - laclef.cc'); ?>

<?php ob_start() ?>
<?php if($error_message_active) echo '<div class="ink-alert basic error"><button class="ink-dismiss">×</button><p><b>' . _('Erreur : ') . '</b> ' . _('Le nombre de demi-journées doit être positif !') . '</p></div>'; ?>
<section>
  <div class="box">
    <table class="ink-table alternating hover" data-page-size="10">
      <thead>
        <tr>
          <th class="content-left"><?php echo _('Date'); ?></th>
          <th class="content-left"><?php echo _('UID'); ?></th>
          <th class="content-left hide-small hide-medium"><?php echo _('Prénom'); ?></th>
          <th class="content-left hide-small hide-medium"><?php echo _('Nom'); ?></th>
          <th class="content-left"><?php echo _('Demi-journées'); ?></th>
	    	</tr>
	    </thead>
			<tbody>
			  <?php foreach ($coworkings as $coworking): ?>
			    <tr>
			      <td class ="small"><?php echo datetime_to_string($coworking['timestamp']); ?></td>
			      <td><?php echo $coworking['uid']; ?></td>
						<td class="hide-small hide-medium"><?php echo $coworking['firstname']; ?></td>
						<td class="hide-small hide-medium"><?php echo $coworking['lastname']; ?></td>
						<?php
              if($coworking['halfdays'] > 0)
                echo '<td><span class="ink-label success">+'. $coworking['halfdays'] . '</span></td>';
              else
                echo '<td><span class="ink-label error">'. $coworking['halfdays'] . '</span></td>';
            ?>
			    </tr>
			  <?php endforeach; ?>
			</tbody>
    </table>
    <nav class="ink-navigation"><ul class="pagination rounded shadowed grey"></ul></nav>
  </div>
</section>
<div>
	<button id="creditModal" class="ink-button blue"><i class="icon-plus-sign"></i> <?php echo _('Créditer un compte'); ?></button>
  <button id="debitModal" class="ink-button red"><i class="icon-minus-sign"></i> <?php echo _('Débiter un compte'); ?></button>
</div>
<div class="ink-shade">
	<div id="creditModal" class="ink-modal" data-trigger="#creditModal">
		<div class="modal-header">
			<button class="modal-close ink-dismiss"></button>
			<h3><?php echo _('Créditer un compte cotravail'); ?></h3>
		</div>
		<div class="modal-body" id="modalContent">
			<form id="creditForm" class="ink-form" method="post" action="coworking" onsubmit="return Ink.UI.FormValidator.validate(this);">
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
						<label for="halfdays"><?php echo _('Nombre de demi-journées : '); ?></label>
						<div class="control">
							<input type="number" name="halfdays" id="halfdays" class="ink-fv-required" placeholder="10" />
						</div>
					</div>
				</fieldset>
				<div class="modal-footer">
					<button class="ink-button caution ink-dismiss"><?php echo _("Annuler"); ?></button>
					<input type="submit" name="sub" value="<?php echo _("Créditer les demis-journées"); ?>" class="ink-button success green" />
				</div>
			</div><!--/.modal-body -->
		</form>
	</div><!--/.ink-modal -->
</div><!--/.ink-shade -->
<div class="ink-shade">
  <div id="debitModal" class="ink-modal" data-trigger="#debitModal">
    <div class="modal-header">
      <button class="modal-close ink-dismiss"></button>
      <h3><?php echo _('Débiter un compte cotravail'); ?></h3>
    </div>
    <div class="modal-body" id="modalContent">
      <form id="debitForm" class="ink-form" method="post" action="coworking" onsubmit="return Ink.UI.FormValidator.validate(this);">
        <input type="hidden" name="debit" id="debit" value="true" hidden />
        <fieldset>
          <div class="control-group required">
            <p class="label"><?php echo _('Utilisateur : '); ?></p>
            <select name="uid" class="control unstyled">
              <?php foreach ($uids as $uid): ?>
                <option value="<?php echo $uid; ?>"><?php echo $uid; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="control-group required">
            <label for="halfdays"><?php echo _('Nombre de demi-journées à débiter : '); ?></label>
            <div class="control">
              <input type="number" name="halfdays" id="halfdays" class="ink-fv-required" placeholder="10" />
            </div>
          </div>
        </fieldset>
        <div class="modal-footer">
          <button class="ink-button caution ink-dismiss"><?php echo _("Annuler"); ?></button>
          <input type="submit" name="sub" value="<?php echo _("Débiter les demis-journées"); ?>" class="ink-button success green" />
        </div>
      </div><!--/.modal-body -->
    </form>
  </div><!--/.ink-modal -->
</div><!--/.ink-shade -->
<?php $content = ob_get_clean() ?>
<?php include 'layout.php' ?>
