<?php $title = _('Lecteurs - laclef.cc'); ?>

<?php ob_start() ?>
<div class="box hide-large">
  <table class="ink-table alternating">
    <thead>
      <tr>
        <th class="content-left"><?php echo _('ID'); ?> <i class="icon-sort-by-order"></i></th>
    		<th class="content-left"><?php echo _('Emplacement'); ?></th>
    		<th class="content-left"><?php echo _('Actions'); ?></th>
    	</tr>
    </thead>
    <tbody>
      <?php foreach ($readers as $reader): ?>
        <tr>
          <td><?php echo $reader['id']; ?></td>
		      <td><?php echo $reader['location']; ?></td>
		      <td>
			      <a href="reader?id=<?php echo $reader['id']; ?>"><button class="ink-button"><i class="icon-pencil"></i></button></a>
			      <a href="reader/delete?id=<?php echo $reader['id']; ?>"><button class="ink-button red"><i class="icon-remove"></i></button></a>
		      </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<div class="column-group gutters hide-small hide-medium">
  <div class="large-60">
    <section>
      <div class="box">
        <table class="ink-table alternating" data-page-size="10">
          <thead>
            <tr>
              <th class="content-left"><?php echo _('ID'); ?> <i class="icon-sort-by-order"></i></th>
          		<th class="content-left"><?php echo _('Emplacement'); ?></th>
          		<th class="content-left"><?php echo _('Services'); ?></th>
          		<th class="content-left"><?php echo _('Actions'); ?></th>
          	</tr>
          </thead>
		      <tbody>
		        <?php foreach ($readers as $reader): ?>
		          <tr>
		            <td><?php echo $reader['id']; ?></td>
					      <td><?php echo $reader['location']; ?></td>
					      <td>
					        <?php
					          $services = explode(',', $reader['services']);
					          foreach ($services as $service):
					            if(isset($service))
					              echo get_service_icon_html($service);						            
					          endforeach;
					        ?>
					      </td>
					      <td>
						      <a href="reader?id=<?php echo $reader['id']; ?>"><button class="ink-button"><i class="icon-pencil"></i></button></a>
						      <a href="reader/delete?id=<?php echo $reader['id']; ?>"><button class="ink-button red"><i class="icon-remove"></i></button></a>
						      <?php
					            if(count($reader['permissions']) > 0) {
					              echo '<div class="ink-dropdown">';
					              echo '<button class="ink-button toggle" data-target="#dropdown-' . $reader['id'] . '"><i class="icon-group"></i> <i class="icon-caret-down"></i></button>';
					              echo '<ul id="dropdown-' . $reader['id'] . '" class="dropdown-menu">';
					              foreach ($reader['permissions'] as $permission):
					                echo '<li><a href="permission?uid=' . $permission['uid'] . '&id=' . $reader['id'] . '"><i class="icon-user"></i> ' . $permission['uid'] . '</a></li>';
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
  </div>
  <div class="large-40">
    <section>
      <div class="box">
        <table class="ink-table" data-page-size="10">
          <thead>
            <tr>
              <th class="content-left"><?php echo _('Date'); ?></th>
          		<th class="content-left"><?php echo _('Lecteur'); ?></th>
          		<th class="content-left"><?php echo _('Utilisateur'); ?></th>
          		<th class="content-left"><?php echo _('Service'); ?></th>
          	</tr>
          </thead>
		      <tbody>
		        <?php foreach ($swipes as $swipe): ?>
		          <tr<?php
		              if($swipe['status'] == 0)
		                echo ' class="ink-label error"';
		              elseif($swipe['status'] == 2)
		                echo ' class="ink-label warning"';
		              elseif($swipe['status'] == 3)
		                echo ' class="ink-label info"';
		              ?>>
		            <td class="small"><?php echo datetime_to_string($swipe['timestamp']); ?></td>
					      <td><span class="tooltip" data-tip-text="<?php if($swipe['reader'] == 0) echo _('Interface web'); else echo $swipe['location']; ?>" data-tip-where="up" data-tip-color="black"><?php echo $swipe['reader']; ?></span></td>
					      <td><?php echo $swipe['uid']; ?></td>
					      <td><?php echo get_service_icon_html($swipe['service']); ?></td>
		          </tr>
		        <?php endforeach; ?>
		      </tbody>
        </table>
        <nav class="ink-navigation"><ul class="pagination rounded shadowed grey"></ul></nav>
      </div>
    </section>
  </div>
</div>
<div>
  <button id="permissionModal" class="ink-button blue"><i class="icon-plus-sign"></i> <?php echo _('Ajouter une permission'); ?></button>
</div>
<div class="ink-shade">
	<div id="permissionModal" class="ink-modal" data-trigger="#permissionModal">
		<div class="modal-header">
			<button class="modal-close ink-dismiss"></button>
			<h3><?php echo _('Ajouter manuellement une permission'); ?></h3>
		</div>
		<div class="modal-body" id="modalContent">
			<form id="permissionForm" class="ink-form" method="post" action="readers" onsubmit="return Ink.UI.FormValidator.validate(this);">
				<fieldset>
					<div class="control-group required">
					  <label for="id"><?php echo _('ID : '); ?></label>
					  <select name="id" class="control unstyled">
					    <?php foreach ($readers as $reader): ?>
						    <option value="<?php echo $reader['id']; ?>"><?php echo $reader['id']; ?></option>
						  <?php endforeach; ?>
					  </select>
					  <p class="tip"><?php echo _("Indiquez ici l'identifiant unique du lecteur auquel l'utilisateur ci-dessous pourra accéder"); ?></p>
					</div>
					<div class="control-group required">
				    <p class="label"><?php echo _('Utilisateur : '); ?></p>
				    <select name="uid" class="control unstyled">
					    <?php foreach ($uids as $uid): ?>
						    <option value="<?php echo $uid; ?>"><?php echo $uid; ?></option>
					    <?php endforeach; ?>
				    </select>
			    </div>
			    <div class="control-group">
			      <label for="end"><?php echo _('Date de fin : '); ?></label>
			      <div class="control">
			        <input id="end" name="end" type="text" placeholder="<?php echo date('Y-m-d H:i:s'); ?>"></input>
			      </div>
			    </div>
			    <p class="tip"><?php echo _("Indiquez ici la date à laquelle l'utilisateur ne pourra plus accéder au lecteur décrits ci-dessus"); ?></p>
				</fieldset>
				<div class="modal-footer">
					<button class="ink-button caution ink-dismiss"><?php echo _("Annuler"); ?></button>
					<input type="submit" name="sub" value="<?php echo _("Ajouter la permission"); ?>" class="ink-button success green" />
				</div>
			</div><!--/.modal-body -->
		</form>
	</div><!--/.ink-modal -->
</div><!--/.ink-shade -->
<?php $content = ob_get_clean() ?>
<?php include 'layout.php' ?>
