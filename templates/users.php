<?php $title = _('Utilisateurs - laclef.cc'); ?>

<?php ob_start() ?>
<section>
  <div class="box">
    <table class="ink-table alternating hover" data-page-size="10">
      <thead>
        <tr>
          <th class="content-left"><?php echo _('UID'); ?> <i class="icon-sort-by-alphabet"></i></th>
	    		<th class="content-left hide-small hide-medium"><?php echo _('Prénom'); ?></th>
	    		<th class="content-left hide-small hide-medium"><?php echo _('Nom'); ?></th>
	    		<th class="content-left hide-small hide-medium"><?php echo _('Email'); ?></th>
	    		<th class="content-left"><?php echo _('Admin'); ?></th>
          <th class="content-left hide-small hide-medium"><?php echo _('Cotravail'); ?></th>
	    		<th class="content-left hide-small hide-medium"><?php echo _('Solde'); ?></th>
	    		<th class="content-left"><?php echo _('Actions'); ?></th>
	    	</tr>
	    </thead>
			<tbody>
			  <?php foreach ($users as $user): ?>
			    <tr>
			      <td><?php echo $user['uid']; ?></td>
						<td class="hide-small hide-medium"><?php echo $user['firstname']; ?></td>
						<td class="hide-small hide-medium"><?php echo $user['lastname']; ?></td>
						<td class="hide-small hide-medium"><a href="mailto:<?php echo $user['email']; ?>"><?php echo $user['email']; ?></a></td>
						<td><?php if($user['admin'] == 1) echo '<i class="icon-ok" style="margin-left:12px;"></i>'; ?></td>
            <td class="content-right hide-small hide-medium"><?php echo str_replace('.', ',', (string) $user['coworking']) . ' ' . _('jours'); ?></td>
						<td class="content-right hide-small hide-medium"><?php echo money_format('%!n&euro;', $user['balance']); ?></td>
						<td>
							<a href="user?uid=<?php echo $user['uid']; ?>"><button class="ink-button"><i class="icon-pencil"></i></button></a>
							<a href="user/delete?uid=<?php echo $user['uid']; ?>"><button class="ink-button red"><i class="icon-trash"></i></button></a>
							<?php
						      if(count($user['tags']) > 0) {
						        echo '<div class="ink-dropdown">';
						        echo '<button class="ink-button toggle" data-target="#dropdown-' . $user['uid'] . '">' . get_tag_icon_html(0) . ' ' . '<i class="icon-caret-down"></i></button>';
						        echo '<ul id="dropdown-' .$user['uid'] . '" class="dropdown-menu">';
						        foreach ($user['tags'] as $tag):
						          echo '<li style="font-weight : normal;"><a href="tag?uid=' . $tag['uid'] . '">' . get_tag_icon_html($tag['type']) . ' ' . $tag['uid'] . '</a></li>';
						        endforeach;
						        echo '</ul></div>';
						      }
						    ?>
						    <?php
						      if(count($user['equipments']) > 0) {
						        echo '<div class="ink-dropdown">';
						        echo '<button class="ink-button toggle" data-target="#dropdown-equipments' . $user['uid'] . '">' . '<i class="icon-tablet"></i>' . ' ' . '<i class="icon-caret-down"></i></button>';
						        echo '<ul id="dropdown-equipments' . $user['uid'] . '" class="dropdown-menu">';
						        foreach ($user['equipments'] as $equipment):
						          echo '<li style="font-weight : normal;"><a href="equipment?id=' . $equipment['id'] . '"> ' . $equipment['name'] . '</a>'  . ' ' . _("jusqu'au") . ' ' . date_to_string($equipment['end']) .'</li>';
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
  <button id="userModal" class="ink-button blue push-left"><i class="icon-plus-sign"></i> <?php echo _('Ajouter'); ?></button>
</div>
<div class="ink-shade">
	<div id="userModal" class="ink-modal" data-trigger="#userModal">
		<div class="modal-header">
			<button class="modal-close ink-dismiss"></button>
			<h3><?php echo _('Ajouter manuellement un utilisateur'); ?></h3>
		</div>
		<div class="modal-body" id="modalContent">
			<form id="userForm" class="ink-form" method="post" action="useradded" onsubmit="return Ink.UI.FormValidator.validate(this);">
				<fieldset>
					<div class="control-group required">
						<label for="firstname"><?php echo _('Prénom : '); ?></label>
						<div class="control">
							<input type="text" name="firstname" id="firstname" class="ink-fv-required" />
						</div>
					</div>
					<div class="control-group required">
						<label for="lastname"><?php echo _('Nom : '); ?></label>
						<div class="control">
							<input type="text" name="lastname" id="lastname" class="ink-fv-required" />
						</div>
					</div>
					<div class="control-group required">
						<label for="email"><?php echo _('Email : '); ?></label>
						<div class="control">
							<input type="text" name="email" id="email" class="ink-fv-required ink-fv-email" />
						</div>
					</div>
					<div class="control-group">
						<label for="pass"><?php echo _('Mot de passe : '); ?></label>
						<div class="control">
							<input type="password" name="password" id="password" />
						</div>
						<p class="tip"><?php echo _('Le mot de passe est obligatoire pour les administrateurs'); ?></p>
					</div>
					<div class="control-group">
						<input type="checkbox" name="admin" id="admin">
						<label for="admin"><?php echo _('Administrateur'); ?></label>
					</div>
				</fieldset>
				<div class="modal-footer">
					<button class="ink-button caution ink-dismiss"><?php echo _("Annuler"); ?></button>
					<input type="submit" name="sub" value="<?php echo _("Ajouter l'utilisateur"); ?>" class="ink-button success green" />
				</div>
			</div><!--/.modal-body -->
		</form>
	</div><!--/.ink-modal -->
</div><!--/.ink-shade -->
<?php $content = ob_get_clean() ?>
<?php include 'layout.php' ?>
