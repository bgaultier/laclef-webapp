<?php $title = _('Inscription - laboîte.cc'); ?>

<?php ob_start() ?>
  <?php
    if(user_exists($_POST['email']) && !empty($_POST['password']))
      echo '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>' . _('Attention ! ') . '</strong> ' . _('L\'utilisateur existe déjà') . '</div>';
    elseif(!empty($_POST['email']))
      insert_new_user($_POST['email'], $_POST['password']);
  ?>
  <div class="container">
    <form class="form-signin" action="signup" method="post" accept-charset="utf-8">
      <h2 class="form-signin-heading"><?php echo _('Créer un compte'); ?></h2>
      <input type="text" name="email" class="input-block-level" placeholder="<?php echo _('Adresse e-mail'); ?>">
      <input type="password" name="password" class="input-block-level" placeholder="<?php echo _('Mot de passe'); ?>">
      <input id="locale" type="hidden" name="locale" value="<?php echo getenv('LANG');?>">
      <button class="btn btn-large btn-inverse btn-block" type="submit"><i class=" icon-ok-circle icon-white"></i> <?php echo _('Inscription'); ?></button>
    </form>
  </div> <!-- /container -->
<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>
