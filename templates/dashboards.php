<?php $title = _('Tableaux de bord - laclef.cc'); ?>

<?php ob_start() ?>
<section>
  <div class="box">
    <table class="ink-table alternating hover">
			<thead>
	    <tr>
	      <th class="content-left"><?php echo _('Chemin'); ?> <i class="icon-sort-by-alphabet"></i></th>
	      <th class="content-left"><?php echo _('Description'); ?></th>
	      <th class="content-left"><?php echo _('Actions'); ?></th>
	    	</tr>
			</thead>
			<tbody>
			  <tr>
			    <td><a href="dashboard">/dashboard</a></td>
			    <td>Tableau de bord de la cafétéria RSM</td>
			    <td>
			      <a href="dashboard"><button class="ink-button"><i class="icon-external-link"></i></button></a>
			    </td>
			  </tr>
			  <tr>
			    <td><a href="grid">/grid</a></td>
			    <td>Lagrille de la cafétéria RSM</td>
			    <td>
			      <a href="grid"><button class="ink-button"><i class="icon-external-link"></i></button></a>
			    </td>
			  </tr>
			</tbody>
		</table>
  </div>
</section>
<?php $content = ob_get_clean() ?>
<?php include 'layout.php' ?>
