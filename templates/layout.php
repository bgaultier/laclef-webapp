<!DOCTYPE html>
<html>
  <head>
    <title><?php echo $title ?></title>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
      <meta name="author" content="Baptiste Gaultier">
      <meta name="HandheldFriendly" content="True">
      <meta name="MobileOptimized" content="320">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
      <link rel="shortcut icon" href="templates/images/favicon.png">
      <link rel="apple-touch-icon-precomposed" sizes="144x144" href="templates/images/apple-touch-icon-144-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="114x114" href="templates/images/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="templates/images/apple-touch-icon-72-precomposed.png">
      <link rel="apple-touch-startup-image" href="../img/splash.320x460.png"
      media="screen and (min-device-width: 200px) and (max-device-width: 320px) and (orientation:portrait)">
      <link rel="apple-touch-startup-image" href="../img/splash.768x1004.png"
      media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)">
      <link rel="apple-touch-startup-image" href="../img/splash.1024x748.png"
      media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)">
      <link rel="stylesheet" type="text/css" href="templates/ink/css/ink.css">
      <link href="templates/ink/css/font-awesome/css/font-awesome.css" rel="stylesheet">
      <link href='http://fonts.googleapis.com/css?family=Kreon:700,400' rel='stylesheet' type='text/css'>

      <!--[if IE 7 ]>
          <link rel="stylesheet" href="../css/ink-ie7.css" type="text/css" media="screen" title="no title" charset="utf-8">
      <![endif]-->

      <style type="text/css">
		    body {
		    		background: #f7f7f7;
				}
				.whatIs {
					margin: 3.6em 0 2em;
					font-size: 1.25em;
				}
				.whatIs p {
					margin-top: .5em;
				}
				.box {
					border-radius: 4px;
					-webkit-box-shadow: 0 2px 3px 0 #dddddd;
					-moz-box-shadow: 0 2px 3px 0 #dddddd;
					box-shadow: 0 2px 3px 0 #dddddd;
					border: 1px solid #BBB;
					background-color: #FFF;
					padding: 1em;
					margin-top: 1em;
				}
			</style>
      <script type="text/javascript" src="templates/ink/js/ink-all.js"></script>
      <script type="text/javascript" src="templates/ink/js/autoload.js"></script>
  </head>
  <body>
  		<header<?php if(isset($dashboard_active) || isset($signup_active)) echo ' class="hide-all"'; ?>>
  			<nav class="ink-navigation ink-grid hide-small hide-medium top-space">
  				<ul class="menu horizontal rounded shadowed grey">
  					<li>
		        <a class="logoPlaceholder" href="/" title="laclef" style="font-family: 'Kreon', serif;"><i class="icon-key"></i> MDA</a>
		      </li>
		      <?php
		      		// if user is not connected
		      		if(!isset($_SESSION['uid'])) {
		      			echo "<li";
		      			if(isset($home_active)) echo ' class="active"';
		      			echo '><a href="/">' . _('Accueil') .'</a></li>';
		      		}
		      	?>
		      	<?php
		      		// if user is connected and admin
		      		if(isset($_SESSION['uid'])) {
		      			echo "<li";
		      			if(isset($users_active)) echo ' class="active"';
		      			echo '><a href="users">' . _('Utilisateurs') . '</a></li>';
		      		}
		      	?>
		      	<?php
		      		// if user is connected and admin
		      		if(isset($_SESSION['uid'])) {
		      			echo "<li";
		      			if(isset($tags_active)) echo ' class="active"';
		      			echo '><a href="tags">' . _('Tags') . '</a></li>';
		      		}
		      	?>
		      	<?php
		      		// if user is connected and admin
		      		if(isset($_SESSION['uid'])) {
		      			echo "<li";
		      			if(isset($readers_active)) echo ' class="active"';
		      			echo '><a href="readers">' . _('Lecteurs') . '</a></li>';
		      		}
		      	?>
		      	<?php
		      		// if user is connected and admin
		      		if(isset($_SESSION['uid'])) {
		      			echo '<li';
		      			if(isset($extras_active)) echo ' class="active"';
		      			echo '><a href="#">' . _('Extras') . ' <i class="icon-caret-down"></i></a>';
		      			echo '<ul class="submenu">';
		      			echo '<li';
		      			if(isset($payments_active)) echo ' class="active"';
		      			echo '><a href="payments">' . _('Paiements') . '</a></li>';
                echo '<li';
                if(isset($coworking_active)) echo ' class="active"';
                echo '><a href="coworking">' . _('Cotravail') . '</a></li>';
		      			echo '<li';
		      			if(isset($snacks_active)) echo ' class="active"';
		      			echo '><a href="snacks">' . _('Produits') . '</a></li>';
                echo '<li';
                if(isset($jobs_active)) echo ' class="active"';
                echo '><a href="jobs">' . _('Impressions 3D') . '</a></li>';
		      			echo '<li';
		      			if(isset($equipments_active)) echo ' class="active"';
		      			echo '><a href="equipments">' . _('Équipements') . '</a></li>';
		      			echo '<li';
		      			if(isset($events_active)) echo ' class="active"';
		      			echo '><a href="events">' . _('Événements') . '</a></li>';
                echo '<li';
                if(isset($meetings_active)) echo ' class="active"';
                echo '><a href="meetings">' . _('Réunions') . '</a></li>';
		      			echo '<li';
		      			if(isset($orders_active)) echo ' class="active"';
		      			echo '><a href="orders">' . _('Commandes') . '</a></li>';
		      			echo '<li><a href="swipes">' . _('Logs') . '</a></li>';
		      			echo '<li><a href="dashboards">' . _('Tableaux de bord') . '</a></li>';
		      			echo '</ul></li>';
		      		}
		      	?>
		      <li<?php if(isset($help_active)) echo ' class="active"' ?>>
		        <a href="help"><?php echo _('Aide'); ?></a>
		      </li>
		      <li<?php if(isset($about_active)) echo ' class="active"' ?>>
		        <a href="about"><?php echo _('À propos'); ?></a>
		      </li>
		      <li class="push-right<?php if(isset($account_active)) echo ' active'; ?>" >
		      		<?php
		      			// if user is not connected
		      			if(!isset($_SESSION['email']))
		      				echo '<a href="login"><span class="icon-signin"></span> ' . _('Connexion') . '</a>';
		      			else
		      				echo '<a href="account"><span class="icon-user"></span> ' . $_SESSION['email'] . '</a>';
		      		?>
		      </li>
				</ul>
			</nav>
			<nav class="ink-navigation ink-grid hide-all show-medium show-small top-space">
			  <ul class="menu horizontal rounded shadowed grey">
			    <li>
			    		<a class="logoPlaceholder" href="/" title="laclef" style="font-family: 'Kreon', serif;"><i class="icon-key"></i> laclef <i class="icon-caret-down"></i></a>
			        <ul class="submenu">
			          <?php
						  		// if user is not connected
						  		if(!isset($_SESSION['uid'])) {
						  			echo "<li";
						  			if(isset($home_active)) echo ' class="active"';
						  			echo '><a href="/">' . _('Accueil') .'</a></li>';
						  		}
						  	?>
						  	<?php
						  		// if user is connected and admin
						  		if(isset($_SESSION['uid'])) {
						  			echo "<li";
						  			if(isset($users_active)) echo ' class="active"';
						  			echo '><a href="users">' . _('Utilisateurs') . '</a></li>';
						  		}
						  	?>
						  	<?php
						  		// if user is connected and admin
						  		if(isset($_SESSION['uid'])) {
						  			echo "<li";
						  			if(isset($tags_active)) echo ' class="active"';
						  			echo '><a href="tags">' . _('Tags') . '</a></li>';
						  		}
						  	?>
						  	<?php
		          		// if user is connected and admin
		          		if(isset($_SESSION['uid'])) {
		          			echo "<li";
		          			if(isset($readers_active)) echo ' class="active"';
		          			echo '><a href="readers">' . _('Lecteurs') . '</a></li>';
		          		}
		          	?>
		          	<?php
		          		// if user is connected and admin
		          		if(isset($_SESSION['uid'])) {
		          			echo '<li';
		          			if(isset($payments_active)) echo ' class="active"';
		          			echo '><a href="payments">' . _('Paiements') . '</a></li>';
                    echo '<li';
                    if(isset($coworking_active)) echo ' class="active"';
                    echo '><a href="coworking">' . _('Cotravail') . '</a></li>';
		          			echo '<li';
		          			if(isset($snacks_active)) echo ' class="active"';
		          			echo '><a href="snacks">' . _('Produits') . '</a></li>';
                    echo '<li';
                    if(isset($jobs_active)) echo ' class="active"';
                    echo '><a href="jobs">' . _('Impressions 3D') . '</a></li>';
		          			echo '<li';
		          			if(isset($equipments_active)) echo ' class="active"';
		          			echo '><a href="equipments">' . _('Équipements') . '</a></li>';
		          			echo '<li';
		          			if(isset($events_active)) echo ' class="active"';
		          			echo '><a href="events">' . _('Événements') . '</a></li>';
                    if(isset($meetings_active)) echo ' class="active"';
                    echo '><a href="meetings">' . _('Réunions') . '</a></li>';
		          			echo '<li';
		          			if(isset($orders_active)) echo ' class="active"';
		      			    echo '><a href="orders">' . _('Commandes') . '</a></li>';
		      			    echo '<li';
		          			if(isset($swipes_active)) echo ' class="active"';
		          			echo '><a href="swipes">' . _('Logs') . '</a></li>';
		          			echo '<li';
		          			if(isset($dashboards_active)) echo ' class="active"';
		          			echo '><a href="dashboards">' . _('Tableaux de bord') . '</a></li>';
		          		}
		          	?>
						  <li<?php if(isset($help_active)) echo ' class="active"' ?>>
						    <a href="help"><?php echo _('Aide'); ?></a>
						  </li>
						  <li<?php if(isset($about_active)) echo ' class="active"' ?>>
						    <a href="about"><?php echo _('À propos'); ?></a>
						  </li>
						  <li>
						  		<?php
						  			// if user is not connected
						  			if(!isset($_SESSION['email']))
						  				echo '<a href="login"><span class="icon-signin"></span> ' . _('Connexion') . '</a>';
						  			else
						  				echo '<a href="account"><span class="icon-user"></span> ' .  $_SESSION['uid'] . '</a>';
						  		?>
						  	</li>
		      		</ul>
		      	</li>
  				</ul>
			</nav>
		</header>
		<div class="ink-grid">
			<?php echo $content; ?>
		</div><!--/.ink-grid -->
	</body>
</html>
