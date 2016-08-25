<?php ob_start() ?>
<div class="box">
	<a href="coffee?uid=<?php echo $client['uid']; ?>"><button class="ink-button push-right"><i class="icon-coffee"></i> <?php $coffee = get_snack_by_id(2); echo _("Café express") . ' ' . money_format('%!n&euro;', $coffee['price']); ?></button></a>
	<form id="orderForm" class="ink-form" method="post" action="dashboard">
		<h3><?php echo $client['firstname'] . ' ' . $client['lastname']; ?></h3>
		<div style="margin: 0;"><?php echo _('Solde : ') . money_format('%!n&euro;', $client['balance']); ?></div>
		<fieldset class="vertical-space">
			<input type="hidden" name="client" id="client" value="<?php echo $client['uid']; ?>" hidden />
			<?php foreach ($snacks as $snack): ?>
				<div class="control-group large-100">
					<div class="column-group horizontal-gutters">
						<p class="label large-30"><?php echo $snack['description_' . getenv('LANG')]; ?></p>
						<p class="label large-20"><?php echo money_format('%!n&euro;', $snack['price']); ?></p>
						<select name="snack_<?php echo $snack['id']; ?>" class="control unstyled large-10">
							<?php
								for ($i = 0; $i <= 10; $i++)
									echo "<option>$i</option>";
							?>
						</select>
					</div>
				</div>
			<?php endforeach; ?>
			<div class="control-group large-100">
				<div class="column-group horizontal-gutters">
					<p class="label large-30"><?php echo _('Virement (beta)'); ?></p>
					<p class="label large-20"><?php echo money_format('%!n&euro;', 0.50); ?></p>
					<select name="transfers" class="control unstyled large-10">
						<?php
							for ($i = 0; $i <= 10; $i++)
								echo "<option>$i</option>";
						?>
					</select>
					<select name="recipient" class="control unstyled large-25" style="margin-left: 16px;">
						<?php
							foreach ($users	as $user)
								echo "<option value=" . $user['uid'] . ">" . $user['firstname'] . " " . $user['lastname'] . "</option>";
						?>
					</select>
				</div>
			</div>
		</fieldset>
		<div>
			<input type="submit" name="sub" value="<?php echo _("Payer la commande"); ?>" class="ink-button success green" />
		</div>
	</form>
	<div>
		<a href="dashboard"><button class="ink-button red"><i class="icon-remove"></i> <?php echo _("Annuler"); ?></button></a>
		<button id="statisticsModal" class="ink-button" onclick="loadStatsJSON()"><i class="icon-bar-chart"></i> <?php echo _("Mes statistiques"); ?></button>
		<button id="messageModal" class="ink-button"><i class="icon-comment-alt"></i> <?php echo _("Envoyer un message"); ?></button>
		<button id="paypalModal" class="ink-button"><i class="fa fa-paypal"></i> <?php echo _("Créditer"); ?></button>
		<button id="bitcoinModal" class="ink-button"><i class="fa fa-bitcoin"></i> <?php echo _("Créditer"); ?></button>
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
					echo '<li style="font-weight : normal;"><a href="equipment?id=' . $equipment['id'] . '"> ' . $equipment['name'] . ' ' . _("jusqu'au") . ' ' . date_to_string($equipment['end']) . '</a></li>';
				endforeach;
				echo '</ul></div>';
			}
		?>
		<?php
			if(count($client['jobs']) > 0) {
				echo '<div class="ink-dropdown">';
				echo '<button class="ink-button toggle" data-target="#dropdown-jobs' . $client['uid'] . '">' . '<i class="fa fa-cube"></i>' . _(" Mes impressions 3D ") . '<i class="icon-caret-down"></i></button>';
				echo '<ul id="dropdown-jobs' . $client['uid'] . '" class="dropdown-menu">';
				foreach ($client['jobs'] as $job):
					if($job['status'] == 0)
						echo '<li><a href="job?id=' . $job['id'] . '"> <i class="icon-circle ink-label error invert"></i> '. $job['file'] . ' <strong>' . money_format('%!n&euro;', $job['price']) .'</strong></a></li>';
					elseif ($job['status'] == 1)
						echo '<li><a href="job?id=' . $job['id'] . '"> <i class="icon-circle ink-label warning invert"></i> '. $job['file'] . ' <strong>' . money_format('%!n&euro;', $job['price']) .'</strong></a></li>';
					else
						echo '<li><a href="job?id=' . $job['id'] . '"> <i class="icon-circle ink-label success invert"></i> ' . $job['file'] . ' <strong>' . money_format('%!n&euro;', $job['price']) .'</strong></a></li>';
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
		<div class="modal-body" id="messageModalContent">
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
		<div class="modal-body" id="statsModalContent">
			<h4 style="font-weight:normal;"><span id="coffees_user_today" class="ink-badge grey"><i class="icon-spin icon-spinner"></i> <i class="icon-coffee"></i></span> <?php echo _("aujourd'hui"); ?></h4>
			<h4 style="font-weight:normal;"><span id="coffees_user_month" class="ink-badge grey"><i class="icon-spin icon-spinner"></i> <i class="icon-coffee"></i></span> <?php echo _("ce mois"); ?></h4>
			<h4 style="font-weight:normal;"><span id="money_user_today" class="ink-badge grey"><i class="icon-spin icon-spinner"></i> <i class="icon-euro"></i></span> <?php echo _("dépensés aujourd'hui"); ?></h4>
			<h4 style="font-weight:normal;"><span id="money_user_month" class="ink-badge grey"><i class="icon-spin icon-spinner"></i> <i class="icon-euro"></i></span> <?php echo _("dépensés ce mois"); ?></h4>
			<?php if($client['lastorder']) echo '<p>' . _("La dernière commande a été passée") . ' ' . strtolower(datetime_to_string($client['lastorder'])) . '</p>'; ?>
			<?php if($client['lastpayment']) echo '<p>' . money_format('%!n&euro;', $client['lastpayment']['amount']) . ' ' . _("ont été crédités") . ' ' . strtolower(datetime_to_string($client['lastpayment']['timestamp'])) . '</p>'; ?>
			<h4><?php echo _("Préférences"); ?></h4>
			<p><?php echo _("Survolez le graphique pour plus d'informations."); ?></p>
		</div><!--/.modal-body -->
		<div class="modal-footer">
			<button class="ink-button caution ink-dismiss"><i class="icon-chevron-left"></i> <?php echo _("Revenir à la commande"); ?></button>
		</div><!--/.modal-footer -->
	</div><!--/.ink-modal -->
</div><!--/.ink-shade -->
<div class="ink-shade">
	<div id="paypalModal" class="ink-modal" data-trigger="#paypalModal">
		<div class="modal-header">
			<button class="modal-close ink-dismiss"></button>
			<h3><?php echo _('Créditer le compte de') . ' ' . $client['firstname'] . ' ' . $client['lastname']; ?></h3>
		</div>
		<div class="modal-body" id="paypalModalContent">
			<?php if($client['lastpayment']) echo '<p>' . money_format('%!n&euro;', $client['lastpayment']['amount']) . ' ' . _("ont été crédités") . ' ' . strtolower(datetime_to_string($client['lastpayment']['timestamp'])) . '</p>'; ?>
			<p><?php echo _("Combien voulez vous créditer sur votre compte ?"); ?></p>
			<form id="paypalForm" class="ink-form" method="post" action="paypal" onsubmit="return Ink.UI.FormValidator.validate(this);">
				<fieldset>
					<input type="hidden" name="uid" id="uid" value="<?php echo $client['uid']; ?>" hidden />
          <input type="hidden" name="email" id="email" value="<?php echo $client['email']; ?>" hidden />
          <div class="control-group required">
            <p class="label"><?php echo _('Créditer '); ?></p>
						<select name="amount" class="control unstyled">
							<option value="10"><?php echo money_format('%!n&euro;', 10); ?></option>
							<option value="20"><?php echo money_format('%!n&euro;', 20); ?></option>
							<option value="30"><?php echo money_format('%!n&euro;', 30); ?></option>
							<option value="50"><?php echo money_format('%!n&euro;', 50); ?></option>
							<option value="100"><?php echo money_format('%!n&euro;', 100); ?></option>
						</select>
            <p class="tip"><?php echo _('Vous allez recevoir un email avec les insctructions pour payer avec votre carte bancaire ou compte Paypal dans les prochaines heures.'); ?></p>
					</div>
				</fieldset>
				<div class="modal-footer">
					<button class="ink-button caution ink-dismiss"><?php echo _("Annuler"); ?></button>
					<input type="submit" name="sub" value="<?php echo _("Créditer mon compte"); ?>" class="ink-button success green" />
				</div>
			</form>
		</div><!--/.modal-body -->
	</div><!--/.ink-modal -->
</div><!--/.ink-shade -->
<div class="ink-shade">
	<div id="bitcoinModal" class="ink-modal" data-trigger="#bitcoinModal">
		<div class="modal-header">
			<button class="modal-close ink-dismiss"></button>
			<h3><?php echo _('Créditer le compte de') . ' ' . $client['firstname'] . ' ' . $client['lastname']; ?></h3>
		</div>
		<div class="modal-body" id="bitcoinModalContent">
			<?php if($client['lastpayment']) echo '<p>' . money_format('%!n&euro;', $client['lastpayment']['amount']) . ' ' . _("ont été crédités") . ' ' . strtolower(datetime_to_string($client['lastpayment']['timestamp'])) . '</p>'; ?>
			<p><?php echo _("Veuillez utiliser le QRcode ci-dessous afin de recharger votre compte Kfet en Bitcoins :"); ?></p>
			<img src="templates/images/bitcoin_wallet.jpg" alt="Bitcoin wallet"  height="256" />
			<p class="small"><?php echo _('Valeur courante du bitcoin :') . ' ' . money_format('%!n&euro;', $bitcoin) . ' ' . _('(basée sur CoinDesk)'); ?></p>
		</div><!--/.modal-body -->
		<div class="modal-footer">
			<button class="ink-button caution ink-dismiss"><?php echo _("Fermer"); ?></button>
		</div><!--/.modal-footer -->
	</div><!--/.ink-modal -->
</div><!--/.ink-shade -->
<script src="templates/d3/d3.v3.min.js"></script>
<script type="text/javascript">
	function loadStatsJSON() {
		d3.json("stats.json?uid=<?php echo $client['uid']; ?>", function(data) {
			d3.select("#coffees_user_today").html(data.coffees_user_today + ' <i class="icon-coffee"></i>');
			d3.select("#coffees_user_month").html(data.coffees_user_month + ' <i class="icon-coffee"></i>');
			d3.select("#money_user_today").html(Math.round(data.money_user_today) + ' <i class="icon-euro"></i>');
			d3.select("#money_user_month").html(Math.round(data.money_user_month) + ' <i class="icon-euro"></i>');
			drawChart();
		});
	}

	function drawChart() {
		var width = 300,
				height = 300,
				radius = Math.min(width, height) / 2;

		var color = d3.scale.ordinal()
				.range(["#eeeeec", "#d3d7cf", "#888a85", "#555753", "#2e3436"]);

		var arc = d3.svg.arc()
				.outerRadius(radius - 10)
				.innerRadius(radius - 70);

		var pie = d3.layout.pie()
				.sort(null)
				.value(function(d) { return d.orders; });

		var svg = d3.select("#statsModalContent").append("svg")
				.attr("width", width)
				.attr("height", height)
			.append("g")
				.attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

		d3.tsv("stats.tsv?uid=<?php echo $client['uid']; ?>", function(error, data) {
			var total = 0;

			data.forEach(function(d) {
				d.orders = +d.orders;
				total += d.orders;
			});

			var g = svg.selectAll(".arc")
					.data(pie(data))
				.enter().append("g")
					.attr("class", "arc");

			g.append("path")
					.attr("d", arc)
					.style("fill", function(d) { return color(d.data.label); })
					.style("stroke", "#fff")
					.style("stroke-width", "1.5px");

			g.append("title")
					.text(function(d) {return d.data.label + " : "+ d.data.orders + " (" + Math.round((d.data.orders * 100) / total) + "%)"; });

			var legend = d3.select("#statsModalContent").append("svg")
					.attr("class", "legend")
					.attr("width", radius * 2)
					.attr("height", radius * 2)
				.selectAll("g")
					.data(data)
				.enter().append("g")
					.attr("transform", function(d, i) { return "translate(0," + i * 20 + ")"; });

			legend.append("rect")
					.attr("x", 2)
					.attr("y", 1)
					.attr("width", 16)
					.attr("height", 16)
					.attr("rx", 3)
					.attr("ry", 3)
					.style("fill", function(d) { return color(d.label); })
					.on("mouseover", fade(.1))
					.on("mouseout", fade(1));;

			legend.append("text")
					.attr("x", 24)
					.attr("y", 9)
					.attr("dy", ".35em")
					.text(function(d) {return d.label + " : "+ Math.round((d.orders * 100) / total) + "%"; });

			function fade(opacity) {
				return function(g, i) {
					svg.selectAll(".arc")
						 .filter(function(d) {
							return d.data.label != g.label;

						})
						.transition()
						.style("opacity", opacity);
				};
			}
		});
	}
</script>
<?php echo ob_get_clean() ?>
