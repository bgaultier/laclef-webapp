<?php $title = _('Tags - laclef.cc'); ?>

<?php ob_start() ?>
<section>
  <div class="box">
  		<table class="ink-table alternating hover" data-page-size="10">
  			<thead>
		    <tr>
		    		<th class="content-left"><?php echo _('UID'); ?></th>
		    		<th class="content-left"><?php echo _('Type'); ?></th>
		    		<th class="content-left"><?php echo _('Propriétaire'); ?> <i class="icon-sort-by-alphabet"></i></th>
		    		<th class="content-left"><?php echo _('Actions'); ?></th>
		    	</tr>
  			</thead>
  			<tbody>
  				<?php foreach ($tags as $tag): ?>
  					<tr>
  						<td><?php echo $tag['uid']; ?></td>
  						<td><?php echo get_tag_icon_html($tag['type']) . ' ' . get_tag_type($tag['type']); ?></td>
  						<td><?php echo $tag['owner']; ?></td>
  						<td>
  							<a href="tag?uid=<?php echo $tag['uid']; ?>"><button class="ink-button"><i class="icon-pencil"></i></button></a>
  							<a href="tag/delete?uid=<?php echo $tag['uid']; ?>"><button class="ink-button red"><i class="icon-trash"></i></button></a>
  						</td>
  					</tr>
        <?php endforeach; ?>
      </tbody>
		</table>
		<nav class="ink-navigation"><ul class="pagination rounded shadowed grey"></ul></nav>
  </div>
</section>
<div>
	<button id="tagModal" class="ink-button blue"><i class="icon-plus-sign"></i> <?php echo _('Ajouter'); ?></button>
</div>
<div class="ink-shade">
	<div id="tagModal" class="ink-modal" data-trigger="#tagModal">
		<div class="modal-header">
			<button class="modal-close ink-dismiss"></button>
			<h3><?php echo _('Ajouter un tag'); ?></h3>
		</div>
		<div class="modal-body" id="modalContent">
			<form id="tagForm" class="ink-form" method="post" action="tags" onsubmit="return Ink.UI.FormValidator.validate(this);">
				<fieldset>
					<div class="control-group required">
						<label for="uid"><?php echo _('UID : '); ?></label>
						<div class="control">
							<input type="text" name="uid" id="uid" class="ink-fv-required" />
						</div>
						<p class="tip"><?php echo _("Indiquez ici l'identifiant unique du tag"); ?></p>
					</div>
					<div class="control-group">
						<p class="label"><?php echo _('Type du tag : '); ?></p>
						<ul class="control unstyled">
							<?php $i = 0; foreach ($types as $type): ?>
								<li><input name="type<?php echo $i; ?>" type="radio"><label for="<?php echo $i; ?>"> <?php echo get_tag_icon_html($i); ?> <?php echo $type;  $i++;?></label></li>
							<?php endforeach; ?>
						</ul>
					</div>
					<div class="control-group">
						<p class="label"><?php echo _('Propriétaire : '); ?></p>
						<select name="owner" class="control unstyled">
							<?php foreach ($uids as $uid): ?>
								<option value="<?php echo $uid; ?>"><?php echo $uid; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</fieldset>
				<div class="modal-footer">
					<button class="ink-button caution ink-dismiss"><?php echo _("Annuler"); ?></button>
					<input type="submit" name="sub" value="<?php echo _("Ajouter le tag"); ?>" class="ink-button success green" />
				</div>
			</div><!--/.modal-body -->
		</form>
	</div><!--/.ink-modal -->
</div><!--/.ink-shade -->
<?php $content = ob_get_clean() ?>
<?php include 'layout.php' ?>
