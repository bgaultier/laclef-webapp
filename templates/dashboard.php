<?php $title = _('Kfet - laclef.cc'); ?>

<?php ob_start() ?>
  <header class="vertical-space">
    <h1 class="pull-left medium-100 small-100"><i class="icon-coffee"></i> Kfet <small style="font-family: 'Kreon', serif;">laclef.cc</small></h1>
    <nav class="ink-navigation pull-right hide-medium hide-small">
      <ul class="menu horizontal grey rounded shadowed">
        <li><a href="users"><?php echo _('Administration'); ?></a></li>
        <li><a href="signup"><?php echo _('Inscription'); ?></a></li>
        <li><a href="kfet"><?php echo _('Aide'); ?></a></li>
        <li><a href="http://api.laclef.cc/bomberman"><i class="fa fa-bomb"></i></a></li>
        <li><a href="grid"><i class="icon-th"></i></a></li>
      </ul>
    </nav>
  </header>
  <div class="column-group gutters">
    <div class="large-25 medium-25 <?php if(isset($_GET['uid'])) echo " hide-small"; else echo " small-100"; ?>">
      <nav class="ink-navigation vertical-space">
        <ul class="menu vertical rounded black">
          <?php
            foreach ($users as $user): ?>
            <li><a href="dashboard?uid=<?php echo $user['uid']; ?>"><?php echo money_format('%!n&euro;', $user['balance']) .' ' . $user['firstname'] . ' ' . $user['lastname']; ?></a></li>
          <?php endforeach; ?>
        </ul>
      </nav>
    </div>
    <div class="large-75 medium-75 small-100 content vertical-space">
      <?php
        if(isset($_GET['uid']))
          require 'order.php';
        else
          require 'widgets.php';
       ?>
    </div>
<?php $content = ob_get_clean() ?>
<?php include 'layout.php' ?>  
