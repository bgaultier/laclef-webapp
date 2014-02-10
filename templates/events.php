<?php $title = _('Événements - laclef.cc'); ?>

<?php ob_start() ?>
<section>
  <div class="box">
    <table class="ink-table alternating hover" data-page-size="10">
      <thead>
        <tr>
          <th class="content-left"><?php echo _('Date'); ?> <i class="icon-sort-numeric"></i></th>
          <th class="content-left"><?php echo _('Titre'); ?></th>
          <th class="content-left hide-small hide-medium"><?php echo _('Description'); ?></th>
          <th class="content-left"><?php echo _('Inscrits'); ?></th>
          <th class="content-left"><?php echo _('Actions'); ?></th>
	    	</tr>
	    </thead>
			<tbody>
			  <?php foreach ($events as $event): ?>
			    <tr>
			      <td><?php echo datetime_to_string($event['date']); ?></td>
			      <td><?php echo $event['title']; ?></td>
			      <td class="hide-small hide-medium"><?php echo substr($event['description'], 0, 32) . "..."; ?></td>
						<td><?php if(count($event['registrations']) < intval($event['max'])) echo '<span class="ink-label success invert">' . count($event['registrations']) . '/' . $event['max'] . '</span>'; else echo '<span class="ink-label error invert">' . count($event['registrations']) . '/' . $event['max'] . '</span>'; ?></td>
						<td>
					    <a href="event?id=<?php echo $event['id']; ?>"><button class="ink-button"><i class="icon-pencil"></i></button></a>
					    <a href="events/delete?id=<?php echo $event['id']; ?>"><button class="ink-button red"><i class="icon-remove"></i></button></a>
					    <?php
						      if(count($event['registrations']) > 0) {
						        echo '<div class="ink-dropdown">';
						        echo '<button class="ink-button toggle" data-target="#dropdown-' . $event['id'] . '"><i class="icon-group"></i> <i class="icon-caret-down"></i></button>';
						        echo '<ul id="dropdown-' . $event['id'] . '" class="dropdown-menu">';
						        foreach ($event['registrations'] as $registration):
						          echo '<li style="font-weight : normal;"><a href="user?uid=' . $registration['uid'] . '"><i class="icon-user"></i> ' . $registration['uid'] . '</a></li>';
						        endforeach;
						        echo '</ul></div>';
						      }
						    ?>
				    </td>
			    </tr>
			  <?php endforeach; ?>
			</tbody>
    </table>
    <nav class="ink-navigation"><ul class="pagination rounded shadowed grey"></ul></nav>
  </div>
</section>
<div>
	<button id="eventModal" class="ink-button blue"><i class="icon-plus-sign"></i> <?php echo _('Ajouter'); ?></button>
</div>
<div class="ink-shade">
	<div id="eventModal" class="ink-modal" data-trigger="#eventModal">
		<div class="modal-header">
			<button class="modal-close ink-dismiss"></button>
			<h3><?php echo _('Ajouter un événement'); ?></h3>
		</div>
		<div class="modal-body" id="modalContent">
			<form id="eventForm" class="ink-form" method="post" action="events" onsubmit="return Ink.UI.FormValidator.validate(this);">
				<fieldset>
					<div class="control-group required">
						<label for="title"><?php echo _('Titre : '); ?></label>
						<div class="control">
							<input type="text" name="title" id="title" class="ink-fv-required" />
						</div>
						<p class="tip"><?php echo _("Indiquez ici le nom de votre évènement"); ?></p>
					</div>
					<div class="control-group">
				        <label for="description"><?php echo _('Description : '); ?></label>
						<div class="control">
							<textarea name="description" id="description" class="ink-fv"></textarea>
						</div>
						<p class="tip"><?php echo _("Indiquez ici une description pour votre événement"); ?></p>
					</div>
					<div class="control-group required">
						<label for="date"><?php echo _('Date : '); ?></label>
						<div class="control">
							<input id="date" name="date" class="ink-fv-required" type="text" placeholder="<?php echo date('Y-m-d H:i:s'); ?>"></input>
						</div>
						<p class="tip"><?php echo _("Indiquez ici la date à laquelle se déroule l'événement"); ?></p>
					</div>
					<div class="control-group required">
						<label for="max"><?php echo _('Participants : '); ?></label>
						<div class="control">
							<input type="text" name="max" id="max" class="ink-fv-required" />
						</div>
						<p class="tip"><?php echo _("Indiquez ici le nombre maximum de participants pour cet événement"); ?></p>
					</div>
					<div class="control-group required">
						<label for="registrationfee"><?php echo _("Frais d'inscription : "); ?></label>
						<div class="control">
							<input type="text" name="registrationfee" id="registrationfee" class="ink-fv-required" />
						</div>
						<p class="tip"><?php echo _("Indiquez ici le prix pour une personne"); ?></p>
					</div>
				</fieldset>
				<div class="modal-footer">
					<button class="ink-button caution ink-dismiss"><?php echo _("Annuler"); ?></button>
					<input type="submit" name="sub" value="<?php echo _("Ajouter l'événement"); ?>" class="ink-button success green" />
				</div>
			</form>
			</div><!--/.modal-body -->
		</form>
	</div><!--/.ink-modal -->
</div><!--/.ink-shade -->
<?php $content = ob_get_clean() ?>
<?php include 'layout.php' ?>
