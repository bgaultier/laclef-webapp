<?php

  // load and initialize any global libraries
  require_once '../models.php';
  
  // API version number
  $version = "0.2";
  
  // fetch json post request 
  $input = json_decode(file_get_contents("php://input"), true, 3);
  
  if(isset($_GET['uri'])) {
    if ('users' == $_GET['uri'] && isset($_GET['id'])) {
      send_headers();
      
      $user = get_user_by_uid($_GET['id']);
      unset($user['password']);
      unset($user['locale']);
	    
	    $response = array("version" => $version,
	                      "response" => $user
	                     );
	    echo json_encode($response);
	  }
    elseif ('users' == $_GET['uri']) {
      send_headers();
      
      $users = get_all_users();
	    
	    $response = array("version" => $version,
	                      "response" => $users
	                     );
	    echo json_encode($response);
	  }
	  elseif('tags' == $_GET['uri'] && isset($_GET['id'])) {
      send_headers();
      
      $tag = get_tag_by_uid($_GET['id']);
      $tag['type'] = get_tag_type($tag['type']);
      unset($tag['keya']);
      
	    $response = array("version" => $version,
	                      "response" => $tag
	                     );
	    echo json_encode($response);
	  }
    elseif ('tags' == $_GET['uri']) {
      send_headers();
      
      $tags = get_all_tags();
	    
	    $response = array("version" => $version,
	                      "response" => $tags
	                     );
	    echo json_encode($response);
	  }
	  elseif('readers' == $_GET['uri'] && isset($_GET['id'])) {
      send_headers();
      
      $reader = get_reader_by_id($_GET['id']);
      $reader['services'] = get_reader_services_by_id($reader['id']);
      $services = [];
      foreach (get_reader_services_by_id($reader['id']) as $service_id)
        $services[] = get_reader_service($service_id);
      $reader['services'] = $services;
	    
	    $response = array("version" => $version,
	                      "response" => $reader
	                     );
	    echo json_encode($response);
	  }
    elseif ('readers' == $_GET['uri']) {
      send_headers();
      
      $readers = get_all_readers();
      
	    $response = array("version" => $version,
	                      "response" => $readers
	                     );
	    echo json_encode($response);
	  }
	  elseif('payments' == $_GET['uri'] && isset($_GET['id'])) {
      send_headers();
      
      $payment = get_all_payments_by_uid($_GET['id']);
      
	    $response = array("version" => $version,
	                      "response" => $payment
	                     );
	    echo json_encode($response);
	  }
    elseif ('payments' == $_GET['uri']) {
      send_headers();
      
      $payments = get_all_payments();
      
	    $response = array("version" => $version,
	                      "response" => $payments
	                     );
	    echo json_encode($response);
	  }
	  elseif('snacks' == $_GET['uri'] && isset($_GET['id'])) {
      send_headers();
      
      $snack = get_snack_by_id($_GET['id']);
      
	    $response = array("version" => $version,
	                      "response" => $snack
	                     );
	    echo json_encode($response);
	  }
    elseif ('snacks' == $_GET['uri']) {
      send_headers();
      
      $snacks = get_all_snacks();
	    
	    $response = array("version" => $version,
	                      "response" => $snacks
	                     );
	    echo json_encode($response);
	  }
	  elseif('equipments' == $_GET['uri'] && isset($_GET['id'])) {
      send_headers();
      
      $equipment = get_equipment_by_id($_GET['id']);
      
	    $response = array("version" => $version,
	                      "response" => $equipment
	                     );
	    echo json_encode($response);
	  }
    elseif ('equipments' == $_GET['uri']) {
      send_headers();
      
      $equipments = get_all_equipments();
      
	    echo json_encode($equipments);
	  }
	  elseif ('coffees' == $_GET['uri'] && isset($_GET['id'])) {
	  	// This is a payment request
	  	$user = get_user_by_uid($_GET['id']);
	  	if($user && $_SERVER['REQUEST_METHOD'] == 'GET') {
	  		$coffees_user_today = get_coffees_today_by_uid($user['uid']);
	  		$coffees_user_month = get_coffees_this_month_by_uid($user['uid']);
	  		
	  		$coffees = array("today" => $coffees_user_today,
		                	 "this_month" => $coffees_user_month
		               		);
	  		send_headers();
		  	
		  	$response = array("version" => $version,
	                          "response" => "OK",
	                          "uid" => $user['uid'],
	                          "balance" => $user['balance'],
	                          "coffees" => $coffees
	                         );
		  	echo json_encode($response);
	  	}
	  	else {
	  		if($user) {
		  		$order = array();
			  	$order['client'] = $user['uid'];
			  	$order['snack_2'] = 1;
			  	new_order($order);
			  	
			  	// get the new user balance
			  	$user = get_user_by_uid($user['uid']);
			  	
			  	send_headers();
			  	
			  	$response = array("version" => $version,
			                    "response" => "OK",
			                    "uid" => $user['uid'],
			                    "balance" => $user['balance']
			                   );
			  	echo json_encode($response);
		  	}
		  	else
		  		forbidden();
	  	}
	  }
	  elseif ('stats' == $_GET['uri'] && isset($_GET['id'])) {
	  	$user = get_user_by_uid($_GET['id']);
	  	
	  	if($user) {
	  		$user_orders = array();
	  		$snacks = get_visible_snacks();
	  		
	  		foreach ($snacks as $snack)
	  			$user_orders[$snack['description_fr_FR']] = intval(get_user_orders_by_snack($user['uid'], $snack['id']));
	  		
	  		send_headers();
		  	
		  	$response = array("version" => $version,
		  										"response" => "OK",
		  										"uid" => $user['uid'],
                          "stats" => $user_orders
                         );
                         
		  	echo json_encode($response);
	  	}
	  	else {
	  		if($user) {
		  		$order = array();
			  	$order['client'] = $user['uid'];
			  	$order['snack_2'] = 1;
			  	new_order($order);
			  	
			  	// get the new user balance
			  	$user = get_user_by_uid($user['uid']);
			  	
			  	send_headers();
			  	
			  	$response = array("version" => $version,
			                    "response" => "OK",
			                    "uid" => $user['uid'],
			                    "balance" => $user['balance']
			                   );
			  	echo json_encode($response);
		  	}
		  	else
		  		forbidden();
	  	}
	  }
	  elseif ('coffees' == $_GET['uri']) {
      send_headers();
      
      $today = get_coffees_today();
      $month = get_coffees_this_month();
      $all = get_coffees();
      
      $coffees = array("today" => $today,
	                     "month" => $month,
	                     "all" => $all
	                    );
      
      $response = array("version" => $version,
	                      "response" => $coffees
	                     );
	    echo json_encode($response);
	  }
	  elseif('permissions' == $_GET['uri'] && isset($_GET['uid']) && isset($_GET['id'])) {
      send_headers();
      
      $permission = get_permission($_GET['uid'], $_GET['id']);
	    echo json_encode($permission);
	  }
    elseif ('permissions' == $_GET['uri'] && isset($_GET['id'])) {
      send_headers();
      
      $permissions = get_reader_permissions($_GET['id']);
	    echo json_encode($permissions);
	  }
	  elseif('orders' == $_GET['uri'] && isset($_GET['uid'])) {
      send_headers();
      
      $orders = get_all_orders_by_uid($_GET['uid']);
      
	    echo json_encode($orders);
	  }
    elseif ('orders' == $_GET['uri']) {
      send_headers();
      
      $orders = get_all_orders();
      
	    echo json_encode($orders);
	  }
	  elseif ('swipes' == $_GET['uri'] && isset($input['uid']) && isset($input['service']) && isset($_GET['id'])) {
	    if($input['service'] == 1 && is_payment_reader($_GET['id'])) {
	       // This is a payment request
	       $owner = get_tag_owner($input['uid']);
	       
	       if($owner && $input['order']) {
	        $user = get_user_by_uid($owner);
	        $input['order']['client'] = $user['uid'];
	        $input['order']['reader'] = $_GET['id'];
	        new_order($input['order']);
	        
	        // get the new user balance
	        $user = get_user_by_uid($user['uid']);
	        
	        send_headers();
	        
	        $response = array("version" => $version,
	                          "response" => "OK",
	                          "uid" => $user['uid'],
	                          "balance" => $user['balance']
	                         );
	        echo json_encode($response);
	       }
	       else
	        forbidden();
	    }
	    elseif($input['service'] == 0) {
	      $owner = get_tag_owner($input['uid']);
	      $permission = get_permission($owner, $_GET['id']);
	      
	      $end_date_reached = false;
	      if($permission['end'])
	        $end_date_reached = (time() > strtotime($permission['end']));
	      
	      if($permission && !$end_date_reached) {
	        // user is allowed
	        // TODO check the end value
	        // log the request if it is a swipe
	        add_swipe(date('Y-m-d H:i:s'), $_GET['id'], $owner, 0, 1);
	        send_headers();
	        
	        $response = array("version" => $version,
	                          "response" => "OK",
	                          "uid" => $owner
	                         );
	        echo json_encode($response);
	      }
	      else {
	        // user is not allowed
	        add_swipe(date('Y-m-d H:i:s'), $_GET['id'], $owner, 0, 0);
	        forbidden();
	      } 
      }
      else
        bad_request();
	  }
	  else
	    bad_request();
	}
	
	function bad_request() {
	  header(':', true, 400);
	  send_headers();
	  
	  $response = array("version" => "0.1",
	                    "response" => "Bad Request",
	                   );
	  echo json_encode($response);
	}
	
	function forbidden() {
	  header(':', true, 403);
	  send_headers();
	  
	  $response = array("version" => "0.1",
	                    "response" => "Forbidden",
	                   );
	  echo json_encode($response);
	}
	
	function send_headers() {
	  header("Content-type: application/json; charset=utf-8");
	  header("Cache-Control: no-cache, must-revalidate");
	}
	
?>
