<?php $title = _('Accueil - laclef.cc'); ?>

<?php ob_start() ?>
<div class="whatIs">
	<h1><?php echo _('Accueil'); ?></h1>
	<p><?php echo _('À remplir'); ?></p>
</div>
<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>
