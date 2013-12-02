<?php $title = _('Commandes - laclef.cc'); ?>

<?php ob_start() ?>
<section>
  <div class="box">
    <table class="ink-table alternating hover" data-page-size="10">
      <thead>
        <tr>
          <th class="content-left"><?php echo _('Date'); ?></th>
          <th class="content-left"><?php echo _('UID'); ?></th>
          <th class="content-left"><?php echo _('Lecteur'); ?></th>
          <th class="content-left"><?php echo _('Produit'); ?></th>
          <th class="content-left"><?php echo _('Quantité'); ?></th>
	    	</tr>
	    </thead>
			<tbody>
			  <?php foreach ($orders as $order): ?>
			    <tr>
			      <td class ="small"><?php echo datetime_to_string($order['timestamp']); ?></td>
			      <td><?php echo $order['uid']; ?></td>
			      <td><span class="tooltip" data-tip-text="<?php echo $order['reader']; ?>" data-tip-where="up" data-tip-color="black"><?php if($order['reader'] == 0) echo _('Interface web'); else echo $order['location']; ?></span></td>
						<td><?php $snack = get_snack_by_id($order['snack']); echo $snack['description_' . getenv('LANG')]; ?></td>
						<td><?php echo $order['quantity']; ?></td>
			    </tr>
			  <?php endforeach; ?>
			</tbody>
    </table>
    <nav class="ink-navigation"><ul class="pagination rounded shadowed grey"></ul></nav>
  </div>
</section>
<?php $content = ob_get_clean() ?>
<?php include 'layout.php' ?>
