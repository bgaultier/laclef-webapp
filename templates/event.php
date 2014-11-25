<?php $title = _("Modifier l'événement - laclef.cc"); ?>

<?php ob_start() ?>
<h3 class="ink-form top-space"><?php echo _('Modifier un événement'); ?></h3>
<div class="box">
  <form id="eventForm" class="ink-form" method="post" action="events" onsubmit="return Ink.UI.FormValidator.validate(this);">
    <fieldset>
      <input type="hidden" name="id" id="id" value="<?php echo $event['id']; ?>" hidden />
      <div class="control-group required">
        <label for="title"><?php echo _('Titre : '); ?></label>
				<div class="control">
					<input type="text" name="title" id="title" class="ink-fv-required" value="<?php echo $event['title']; ?>" />
				</div>
				<p class="tip"><?php echo _("Indiquez ici le nom de votre évènement"); ?></p>
			</div>
			<div class="control-group">
        <label for="description"><?php echo _('Description : '); ?></label>
				<div class="control">
					<textarea name="description" id="description" class="ink-fv"><?php echo $event['description']; ?></textarea>
				</div>
				<p class="tip"><?php echo _("Indiquez ici une description pour votre événement"); ?></p>
			</div>
			<div class="control-group required">
			  <label for="date"><?php echo _('Date : '); ?></label>
			  <div class="control">
			    <input id="date" name="date" class="ink-fv-required" type="text" value="<?php if($event['date']) echo $event['date']; ?>" placeholder="<?php echo date('Y-m-d H:i:s'); ?>"></input>
			  </div>
			  <p class="tip"><?php echo _("Indiquez ici la date à laquelle se déroule l'événement"); ?></p>
			</div>
			<div class="control-group required">
        <label for="max"><?php echo _('Participants : '); ?></label>
				<div class="control">
					<input type="text" name="max" id="max" class="ink-fv-required" value="<?php echo $event['max']; ?>" />
				</div>
				<p class="tip"><?php echo _("Indiquez ici le nombre maximum de participants pour cet événement"); ?></p>
			</div>
			<div class="control-group required">
        <label for="registrationfee"><?php echo _("Frais d'inscription : "); ?></label>
				<div class="control">
					<input type="text" name="registrationfee" id="registrationfee" class="ink-fv-required" value="<?php echo $event['registrationfee']; ?>" />
				</div>
				<p class="tip"><?php echo _("Indiquez ici le prix pour une personne"); ?></p>
			</div>
    </fieldset>
		<div>
			<input type="submit" name="sub" value="<?php echo _("Sauvegarder les modifications"); ?>" class="ink-button success green" />
		</div>
	</form>
	<?php if(count($event['registrations']) > 0) { ?>
	  <div class="control-group top-space">
	    <h4><?php echo _('Inscrits : '); ?></h4>
	    <table class="ink-table bordered alternating hover">
	      <thead>
	        <tr>
	          <th class="content-left"><?php echo _('Nom'); ?></th>
	          <th class="content-left"><?php echo _("Date de l'inscription"); ?></th>
	          <th><?php echo _('Payé'); ?></th>
	        </tr>
	      </thead>
	      <tbody>
	        <?php
	          foreach ($event['registrations'] as $registration):
	            echo '<tr><td>' . $registration['firstname'] .' ' . $registration['lastname'] . '</td><td>' . datetime_to_string($registration['registration']) . '</td><td class="content-right"> ' . money_format('%!n&euro;', $registration['paid']) . '</td></tr>';
            endforeach;
          ?>
        </tbody>
	    </table>
	  </div><!--/.control-group -->
	<?php
    }
	?>
</div>
<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>
