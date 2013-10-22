<?php $title = _('Logs - laclef.cc'); ?>

<?php ob_start() ?>
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
				      <td><span class="tooltip" data-tip-text="<?php echo $swipe['location']; ?>" data-tip-where="up" data-tip-color="black"><?php echo $swipe['reader']; ?></span></td>
				      <td><?php echo $swipe['uid']; ?></td>
				      <td><?php echo get_service_icon_html($swipe['service']); ?></td>
	          </tr>
	        <?php endforeach; ?>
	      </tbody>
      </table>
      <nav class="ink-navigation"><ul class="pagination rounded shadowed grey"></ul></nav>
    </div>
  </section>
<?php $content = ob_get_clean() ?>
<?php include 'layout.php' ?>
