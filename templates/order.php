<?php ob_start() ?>
<div class="box">
  <a href="soda?uid=<?php echo $client['uid']; ?>"><button class="ink-button push-right"><i class="icon-beer"></i> <?php $soda = get_snack_by_id(12); echo _("Soda express") . ' ' . number_format($soda['price'], 2, ',', ' ') . '&euro;';
    ?></button></a>
    <a href="coffee?uid=<?php echo $client['uid']; ?>"><button class="ink-button push-right"><i class="icon-coffee"></i> <?php $coffee = get_snack_by_id(2); echo _("Café express") . ' ' . number_format($coffee['price'], 2, ',', ' ') . '&euro;'; ?></button></a>
  <form id="orderForm" class="ink-form" method="post" action="dashboard">
    <h3><?php echo $client['firstname'] . ' ' . $client['lastname']; ?></h3>
    <div style="margin: 0;"><?php echo _('Solde : ') . number_format($client['balance'], 2, ',', ' ') . '&euro;'; ?></div>
    <fieldset class="vertical-space">
      <input type="hidden" name="client" id="client" value="<?php echo $client['uid']; ?>" hidden />
			<?php foreach ($snacks as $snack): ?>
			  <div class="control-group large-100">
			    <div class="column-group horizontal-gutters">
				    <p class="label large-30"><?php echo $snack['description_' . getenv('LANG')]; ?></p>
				    <p class="label large-20"><?php echo number_format($snack['price'], 2, ',', ' ') . '&euro;'; ?></p>
				    <select name="snack_<?php echo $snack['id']; ?>" class="control unstyled large-10">
					    <?php
					      for ($i = 0; $i <= 10; $i++)
					        echo "<option>$i</option>";
					    ?>
				    </select>
			    </div>
			  </div>
			<?php endforeach; ?>
    </fieldset>
		<div>
			<input type="submit" name="sub" value="<?php echo _("Payer la commande"); ?>" class="ink-button success green" />
		</div>
	</form>
	<div>
	  <a href="dashboard"><button class="ink-button red"><i class="icon-remove"></i> <?php echo _("Annuler"); ?></button></a>
	  <a href="dashboard"><button id="statisticsModal" class="ink-button"><i class="icon-bar-chart"></i> <?php echo _("Mes statistiques"); ?></button></a>
	  <a href="dashboard"><button id="messageModal" class="ink-button"><i class="icon-comment-alt"></i> <?php echo _("Envoyer un message"); ?></button></a>
	  <?php
      if(count($client['tags']) > 0) {
        echo '<div class="ink-dropdown">';
        echo '<button class="ink-button toggle" data-target="#dropdown-' . $client['uid'] . '">' . get_tag_icon_html(0) . _(" Mes tags ") . '<i class="icon-caret-down"></i></button>';
        echo '<ul id="dropdown-' .$client['uid'] . '" class="dropdown-menu">';
        foreach ($client['tags'] as $tag):
          echo '<li style="font-weight : normal;"><a href="tag?uid=' . $tag['uid'] . '">' . get_tag_icon_html($tag['type']) . ' ' . $tag['uid'] . '</a></li>';
        endforeach;
        echo '</ul></div>';
      }
    ?>
    <?php
      if(count($client['equipments']) > 0) {
        echo '<div class="ink-dropdown">';
        echo '<button class="ink-button toggle" data-target="#dropdown-equipments' . $client['uid'] . '">' . '<i class="icon-tablet"></i>' . _(" Mes équipements ") . '<i class="icon-caret-down"></i></button>';
        echo '<ul id="dropdown-equipments' . $client['uid'] . '" class="dropdown-menu">';
        foreach ($client['equipments'] as $equipment):
          echo '<li style="font-weight : normal;"><a href="equipment?id=' . $equipment['id'] . '"> ' . $equipment['name'] . '</a>'  . ' ' . _("jusqu'au") . ' ' . date_to_string($equipment['end']) .'</li>';
        endforeach;
        echo '</ul></div>';
      }
    ?>
	</div>
</div>
<div class="ink-shade">
	<div id="messageModal" class="ink-modal" data-trigger="#messageModal">
		<div class="modal-header">
			<button class="modal-close ink-dismiss"></button>
			<h3><?php echo _('Envoyer un message'); ?></h3>
		</div>
		<div class="modal-body" id="modalContent">
			<form id="messageForm" class="ink-form" method="post" action="dashboard" onsubmit="return Ink.UI.FormValidator.validate(this);">
				<fieldset>
					<input type="hidden" name="uid" id="uid" value="<?php echo $client['uid']; ?>" hidden />
					<div class="control-group required">
						<label for="message"><?php echo _('Message (max. 160 caractères) : '); ?></label>
						<div class="control">
							<input type="text" name="message" id="message" class="ink-fv-required" />
						</div>
					</div>
				</fieldset>
				<div class="modal-footer">
					<button class="ink-button caution ink-dismiss"><?php echo _("Annuler"); ?></button>
					<input type="submit" name="sub" value="<?php echo _("Envoyer le message"); ?>" class="ink-button success green" />
				</div>
			</div><!--/.modal-body -->
		</form>
	</div><!--/.ink-modal -->
</div><!--/.ink-shade -->
<div class="ink-shade">
	<div id="statisticsModal" class="ink-modal" data-trigger="#statisticsModal">
		<div class="modal-header">
			<button class="modal-close ink-dismiss"></button>
			<h3><?php echo _('Statistiques de ') . $client['firstname'] . ' ' . $client['lastname']; ?></h3>
		</div>
		<div class="modal-body" id="modalContent">
		  <h4 style="font-weight:normal;"><span class="ink-badge grey"><?php echo $client['coffees_today']; ?> <i class="icon-coffee"></i></span> <?php echo _("aujourd'hui"); ?></h4>
      <h4 style="font-weight:normal;"><span class="ink-badge grey"><?php echo $client['coffees_month']; ?> <i class="icon-coffee"></i></span> <?php echo _("ce mois"); ?></h4>
      <h4 style="font-weight:normal;"><span class="ink-badge grey"><?php echo number_format($client['money_today'], 0, ',', ' '); ?> <i class="icon-euro"></i></span> <?php echo _("dépensés aujourd'hui"); ?></h4>
      <h4 style="font-weight:normal;"><span class="ink-badge grey"><?php echo number_format($client['money_month'], 0, ',', ' '); ?> <i class="icon-euro"></i></span> <?php echo _("dépensés ce mois"); ?></h4>
      <?php if($client['lastorder']) echo '<p>' . _("La dernière commande a été passée") . ' ' . strtolower(datetime_to_string($client['lastorder'])) . '</p>'; ?>
      <?php if($client['lastpayment']) echo '<p>' . number_format($client['lastpayment']['amount'], 2, ',', ' ') . '&euro; ' . _("ont été crédités") . ' ' . strtolower(datetime_to_string($client['lastpayment']['timestamp'])) . '</p>'; ?>
    </div><!--/.modal-body -->
		<div class="modal-footer">
		  <button class="ink-button caution ink-dismiss"><i class="icon-chevron-left"></i> <?php echo _("Revenir à la commande"); ?></button>
		</div><!--/.modal-footer -->
	</div><!--/.ink-modal -->
</div><!--/.ink-shade -->
<?php echo ob_get_clean() ?>
