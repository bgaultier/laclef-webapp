<?php
  function home_action() {
    // needed to set the tab active
    $home_active = true;
  	
    require 'templates/home.php';
  }
  
  function help_action() {
    // needed to set the tab active
    $help_active = true;
  	
    require 'templates/help.php';
  }
  
  function about_action() {
    // needed to set the tab active
    $about_active = true;
  	
    require 'templates/about.php';
  }
  
  function dashboards_action() {
    // needed to set the tab active
    $dashboards_active = true;
  	
    require 'templates/dashboards.php';
  }
  
  function dashboard_action() {
    // needed to hide the menu
    $dashboard_active = true;
    
		// dealing with order form
			if(isset($_POST['client']))
				new_order($_POST);
			// dealing with message form
			if(isset($_POST['message']))
				add_message($_POST['uid'], $_POST['message']);
			// if order form is needed
			if(isset($_GET['uid'])) {
				// get all the snacks
				$snacks = get_visible_snacks();
				
				$client = get_user_by_uid($_GET['uid']);
				$client['lastorder'] = get_last_order_timestamp_by_uid($client['uid']);
				$client['lastpayment'] = get_last_payment_by_uid($client['uid']);
				$client['tags'] = get_user_tags($client['uid']);
				$client['equipments'] = get_user_equipments($client['uid']);
			}
			else {
				$messages = get_all_messages();
				$events = get_google_calendar_events();
			}
		
			// get all the users
			$users = get_all_users_sorted_by_balance_descending();
		
			require 'templates/dashboard.php';
	}
  
  function login_action() {
    // check if the admin exists
    $user = user_is_admin_and_password_match($_POST['uid'], $_POST['password']);
    if($user && !empty($_POST['uid'])) {
      $_SESSION['uid'] = $user['uid'];
      $_SESSION['email'] = $user['email'];
      $_SESSION['locale'] = $user['locale'];
      
      // Redirect browser
			header("Location: http://" . $_SERVER['SERVER_NAME'] . "/users");
			// Make sure that code below does not get executed when we redirect
			exit;
    }
    else {
    		// needed to set the tab active
    		$home_active = true;
      require 'templates/login.php';
    }
  }
  
  function logout_action() {
    require 'templates/logout.php';
  }
  
  function account_action($session_uid) {
    // needed to set the tab active
    $account_active = true;
    
    //check if the user is admin
    if(user_is_admin($session_uid)) {
      $user = get_user_by_uid($session_uid);
      if(!empty($_POST['locale'])) {
        update_user_locale($user['uid'], $_POST['locale']);
        $_SESSION['locale'] = $_POST['locale'];
      }      
      
      require 'templates/account.php';
    }
    else
      require 'templates/login.php';
  }
  
  function modify_user_action($session_uid, $uid) {
  		// needed to set the tab active
  		$users_active = true;
  		
  		//check if the user is admin
  		if(user_is_admin($session_uid)) {
  			$user = get_user_by_uid($uid);
  			
  			require 'templates/user.php';
  		}
  		else
  		  require 'templates/login.php';
  }
  
  function list_users_action($uid) {
  		// needed to set the tab active
  		$users_active = true;
  		
  		//check if the user is admin
  		if(user_is_admin($uid)) {
  			// dealing with user add form
  			if(isset($_POST['lastname'])) {
  				$user_added = get_user_by_uid($_POST['uid']);
  				// user exists
		      if($user_added)
		        update_user($_POST);
		      else
		        add_user($_POST);
		  }
  			// list all the users
  			$users = get_all_users();
  			require 'templates/users.php';
  		}
		else
			require 'templates/login.php';
  }
  
  function delete_user_action($session_uid, $uid) {
  		//check if the user is admin
  		if(user_is_admin($session_uid)) {
  			delete_user($uid);
  			// Redirect browser
  			header("Location: http://" . $_SERVER['SERVER_NAME'] . "/users");
  			// Make sure that code below does not get executed when we redirect
  			exit;
  		}
  		else
  			require 'templates/login.php';
  }
  
  function modify_tag_action($session_uid, $uid) {
  		// needed to set the tab active
  		$tags_active = true;
  		
  		//check if the user is admin
  		if(user_is_admin($session_uid)) {
  			$tag = get_tag_by_uid($uid);
  			$types = get_tag_types();
  			$uids = get_all_uids();
  			
  			require 'templates/tag.php';
  		}
  		else
  		  require 'templates/login.php';
  }
  
  function list_tags_action($uid) {
  		// needed to set the tab active
  		$tags_active = true;
  		
  		//check if the user is admin
  		if(user_is_admin($uid)) {
  			// dealing with tag add form
  			if(isset($_POST['owner'])) {
  				$tag_added = get_tag_by_uid($_POST['uid']);
  				// tag exists
		    if($tag_added) {
		    		update_tag($_POST['uid'], $_POST);
		    }
		    else
		    		add_tag($_POST);
		  }
  			
  			// list all the users
  			$tags = get_all_tags();
  			$types = get_tag_types();
  			$uids = get_all_uids();
  			require 'templates/tags.php';
  		}
		else
			require 'templates/login.php';
  }
  
  function delete_tag_action($session_uid, $uid) {
	  //check if the user is admin
	  if(user_is_admin($session_uid)) {
		  delete_tag($uid);
		  // Redirect browser
		  header("Location: http://" . $_SERVER['SERVER_NAME'] . "/tags");
		  // Make sure that code below does not get executed when we redirect
		  exit;
	  }
	  else
		  require 'templates/login.php';
  }
  
  function list_readers_action($uid) {
  		// needed to set the tab active
  		$readers_active = true;
  		
  		if(user_is_admin($uid)) {
  		  // dealing with permission add form
  			if(isset($_POST['uid']) && isset($_POST['id'])) {
  				$permission_added = get_permission($_POST['uid'], $_POST['id']);
  				// permission exists
		      if($permission_added)
		        update_permission($_POST['uid'], $_POST['id'], $_POST['end']);
		      else
		        add_permission($_POST['uid'], $_POST['id'], $_POST['end']);
		    }
    		// list all the readers
    		$readers = get_all_readers();
    		// list all the swipe records
    		$swipes = get_all_swipes();
    		// Fetch all the users UIDs
    		$uids = get_all_uids();
    		require 'templates/readers.php';
  		}
		else
			require 'templates/login.php';
  }
  
  function list_swipes_action($uid) {
  		// needed to set the tab active
  		$swipes_active = true;
  		
  		if(user_is_admin($uid)) {
    		// list all the swipe records
    		$swipes = get_all_swipes();
    		require 'templates/swipes.php';
  		}
		else
			require 'templates/login.php';
  }
  
  function modify_reader_action($session_uid, $id) {
    // needed to set the tab active
		$readers_active = true;
		
		//check if the user is admin
		if(user_is_admin($session_uid)) {
			$reader = get_reader_by_id($id);
			
			require 'templates/reader.php';
		}
		else
		  require 'templates/login.php';
  }
  
  function delete_reader_action($session_uid, $id) {
	  //check if the user is admin
	  if(user_is_admin($session_uid)) {
		  delete_reader($id);
		  // Redirect browser
		  header("Location: http://" . $_SERVER['SERVER_NAME'] . "/readers");
		  // Make sure that code below does not get executed when we redirect
		  exit;
	  }
	  else
		  require 'templates/login.php';
  }
  
  function modify_permission_action($session_uid, $uid, $id) {
    // needed to set the tab active
		$readers_active = true;
		
		//check if the user is admin
		if(user_is_admin($session_uid)) {
			$permission = get_permission($uid, $id);
			// Fetch all the readers IDs
			$ids = get_all_ids();
			// Fetch all the users UIDs
			$uids = get_all_uids();
			
			require 'templates/permission.php';
		}
		else
		  require 'templates/login.php';
  }
  
  function add_all_user_to_a_reader_action($session_uid, $id) {
    //check if the user is admin
	  if(user_is_admin($session_uid)) {
		  add_all_user_to_a_reader($id);
		  // Redirect browser
		  header("Location: http://" . $_SERVER['SERVER_NAME'] . "/readers");
		  // Make sure that code below does not get executed when we redirect
		  exit;
	  }
	  else
		  require 'templates/login.php';
  }
  
  function coffee_order_action($uid) {
    $order = array();
    $order['client'] = $uid;
    $order['snack_2'] = 1;
    new_order($order);
    // Redirect browser
    header("Location: http://" . $_SERVER['SERVER_NAME'] . "/dashboard");
    // Make sure that code below does not get executed when we redirect
    exit;
  }
  
  function soda_order_action($uid) {
    $order = array();
    $order['client'] = $uid;
    $order['snack_9'] = 1;
    new_order($order);
    // Redirect browser
    header("Location: http://" . $_SERVER['SERVER_NAME'] . "/dashboard");
    // Make sure that code below does not get executed when we redirect
    exit;
  }
  
  function delete_permission_action($session_uid, $uid, $id) {
  		//check if the user is admin
  		if(user_is_admin($session_uid)) {
  			delete_permission($uid, $id);
  			// Redirect browser
  			header("Location: http://" . $_SERVER['SERVER_NAME'] . "/reader?id=$id");
  			// Make sure that code below does not get executed when we redirect
  			exit;
  		}
  		else
  			require 'templates/login.php';
  }
  
  function list_payments_action($uid) {
  		// needed to set the tab active
  		$extras_active = true;
  		$payments_active = true;
  		
  		if(user_is_admin($uid)) {
  		  // dealing with payment add form
  			if(isset($_POST['uid']) && isset($_POST['amount'])) {
  				$error_message_active = add_payment($_POST['uid'], $_POST['amount']);
  			}
  				
    		// list all the payments
    		$payments = get_all_payments();
    		// Fetch all the users UIDs
    		$uids = get_all_uids();
    		require 'templates/payments.php';
  		}
		else
			require 'templates/login.php';
  }
  
  function list_orders_action($uid) {
  		// needed to set the tab active
  		$extras_active = true;
  		$orders_active = true;
  		
  		if(user_is_admin($uid)) {
    		// list all the orders
    		$orders = get_all_orders();
    		
    		require 'templates/orders.php';
  		}
		else
			require 'templates/login.php';
  }
  
  function list_equipments_action($uid) {
		// needed to set the tab active
		$extras_active = true;
		$equipments_active = true;
		
		if(user_is_admin($uid)) {
		  // dealing with equipment add form
			if(isset($_POST['description']) && isset($_POST['name'])) {
				$equipment_added = get_equipment_by_id($_POST['id']);
				// equipment exists
	      if($equipment_added)
	        update_equipment($_POST['id'], $_POST['uid'], $_POST['name'], $_POST['description'], $_POST['hirer'], $_POST['end']);
	      else
	        add_equipment($_POST['uid'], $_POST['name'], $_POST['description'], $_POST['hirer'], $_POST['end']);
	    }
  		// get all the equipments
  		$equipments = get_all_equipments();
  		$uids = get_all_uids();
  		
  		require 'templates/equipments.php';
		}
		else
		  require 'templates/login.php';
  }
  
  function equipment_available_action($session_uid, $id) {
	  //check if the user is admin
	  if(user_is_admin($session_uid)) {
		  set_equipment_available($id);
		  // Redirect browser
		  header("Location: http://" . $_SERVER['SERVER_NAME'] . "/equipments");
		  // Make sure that code below does not get executed when we redirect
		  exit;
	  }
	  else
		  require 'templates/login.php';
  }
  
  
  function list_snacks_action($uid) {
		// needed to set the tab active
		$extras_active = true;
		$snacks_active = true;
		
		if(user_is_admin($uid)) {
		  // dealing with permission add form
			if(isset($_POST['description_en_US']) && isset($_POST['price'])) {
				$snack_added = get_snack_by_id($_POST['id']);
				// snack exists
	      if($snack_added)
	        update_snack($_POST['id'], $_POST['description_fr_FR'], $_POST['description_en_US'], $_POST['price'], $_POST['visible']);
	      else
	        add_snack($_POST['description_fr_FR'], $_POST['description_en_US'], $_POST['price'], $_POST['visible']);
	    }
  		// get all the snacks
  		$snacks = get_all_snacks();
  		require 'templates/snacks.php';
		}
		else
		  require 'templates/login.php';
  }
  
  function dashboard_json_action() {
    header('Content-type: application/json; charset=utf-8');
	  header("Cache-Control: no-cache, must-revalidate");
	  
    $coffees_today = get_coffees_today();
    $coffees_month = get_coffees_this_month();
    $money_today = get_money_spent_today();
    $money_month = get_money_spent_this_month();
    
    $json = array("coffees_today" => $coffees_today,
                  "coffees_month" => $coffees_month,
                  "money_today" => $money_today,
                  "money_month" => $money_month
                 );
                    
    echo json_encode($json);      
  }
  
  function stats_json_action($uid) {
    header('Content-type: application/json; charset=utf-8');
	  header("Cache-Control: no-cache, must-revalidate");
	  
    $user = get_user_by_uid($uid);
    $coffees_user_today = get_coffees_today_by_uid($user['uid']);
    $coffees_user_month = get_coffees_this_month_by_uid($user['uid']);
    $money_user_today = get_money_spent_today_by_uid($user['uid']);
    $money_user_month = get_money_spent_this_month_by_uid($user['uid']);
    
    $json = array("coffees_user_today" => $coffees_user_today,
                  "coffees_user_month" => $coffees_user_month,
                  "money_user_today" => $money_user_today,
                  "money_user_month" => $money_user_month
                 );
                    
    echo json_encode($json);      
  }
  
  function stats_tsv_action($uid) {
  	header('Content-type: application/json; charset=utf-8');
  	header("Cache-Control: no-cache, must-revalidate");
  	
  	$user = get_user_by_uid($uid);
	  $user_orders = array();
	  $total = 0;
	  $snacks = get_visible_snacks();
	  
    echo "label\torders\n";
	  foreach ($snacks as $snack)
	  	$user_orders[$snack['description_' . getenv('LANG')]] = intval(get_user_orders_by_snack($user['uid'], $snack['id']));
	  	
	 	foreach ($user_orders as $label => $orders)
	 		echo "$label\t$orders\n";
  }
  
  function events_json_action() {
    header('Content-type: application/json; charset=utf-8');
	  header("Cache-Control: no-cache, must-revalidate");
	  
    $events = get_google_calendar_events();
                    
    echo json_encode($events);      
  }
  
  function coffees_tsv_action() {
    header('Content-type: text/tab-separated-values; charset=utf-8');
	  header("Cache-Control: no-cache, must-revalidate");
	  
	  $tsv = array();
	  
	  for ($i = 5; $i >= 0; $i--)
	  {
	    $month = date("m", strtotime("-$i month", time()));
	    $tsv[$month] = get_coffees_by_month($month, date("Y", strtotime("-$i month", time())));
	  }
                    
    echo "month\tcoffees\n";
    foreach ($tsv as $month => $coffees)
    	echo "$month\t$coffees\n";
  }
  
  function modify_snack_action($session_uid, $id) {
    // needed to set the tab active
		$extras_active = true;
		$snacks_active = true;
		
		//check if the user is admin
		if(user_is_admin($session_uid)) {
			$snack = get_snack_by_id($id);
			
			require 'templates/snack.php';
		}
		else
		  require 'templates/login.php';
  }
  
  function delete_snack_action($session_uid, $id) {
	  //check if the user is admin
	  if(user_is_admin($session_uid)) {
		  delete_snack($id);
		  // Redirect browser
		  header("Location: http://" . $_SERVER['SERVER_NAME'] . "/snacks");
		  // Make sure that code below does not get executed when we redirect
		  exit;
	  }
	  else
		  require 'templates/login.php';
  }
  
  function modify_equipment_action($session_uid, $id) {
    // needed to set the tab active
		$extras_active = true;
		$equipments_active = true;
		
		//check if the user is admin
		if(user_is_admin($session_uid)) {
			$equipment = get_equipment_by_id($id);
			// get all users uids
  		$uids = get_all_uids();
			
			require 'templates/equipment.php';
		}
		else
		  require 'templates/login.php';
  }
  
  function delete_equipment_action($session_uid, $id) {
	  //check if the user is admin
	  if(user_is_admin($session_uid)) {
		  delete_equipment($id);
		  // Redirect browser
		  header("Location: http://" . $_SERVER['SERVER_NAME'] . "/equipments");
		  // Make sure that code below does not get executed when we redirect
		  exit;
	  }
	  else
		  require 'templates/login.php';
  }
  
  function signup_action() {
    $signup_active = true;
    
    // get LDAP users
    $users = get_ldap_users();
    
    // if user creation is needed
    if(isset($_GET['uid'])) {
      $user = get_ldap_user_by_uid($_GET['uid']);
      $values = array("uid" => $user['uid'],
                      "firstname" => $user['firstname'],
                      "lastname" => $user['lastname'],
                      "email" => $user['email'],
                      "password" => null,
                      "admin" => false,
                      "locale" => "en_US"
                     );
      add_user(values);
    }
    
    require 'templates/signup.php';
  }
  
  function kfet_action() {
    require 'templates/kfet.php';
  }
  
?>
