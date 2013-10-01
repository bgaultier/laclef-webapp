<?php
  // load and initialize any global libraries
  require_once '../models.php';
  
  // API version number
  $version = "0.1";
  
  // fetch json post request 
  $input = json_decode(file_get_contents("php://input"), true, 2);
  
  if(isset($_GET['uri'])) {
    if ('permissions' == $_GET['uri'] && isset($_GET['uid']) && isset($_GET['id'])) {
      header('Content-type: application/json; charset=utf-8');
      header("Cache-Control: no-cache, must-revalidate");
      
      $permission = get_permission($_GET['uid'], $_GET['id']);
	    echo json_encode($permission);
	  }
	  elseif ('swipes' == $_GET['uri'] && isset($input['uid']) && isset($input['service']) && isset($_GET['id'])) {
	    if($input['service'] == 1 && is_payment_reader($_GET['id'])) {
	       // This is a payment request
	       $owner = get_tag_owner($input['uid']);
	       
	       if($owner) {
	        // check user balance
	        $status = get_user_balance_status($owner);
	        // log the request if it is a swipe
	        add_swipe(date('Y-m-d H:i:s'), $_GET['id'], $owner, 1, $status);
	        header('Content-type: application/json; charset=utf-8');
	        header("Cache-Control: no-cache, must-revalidate");
	        
	        $user = get_user_by_uid($owner);
	        $response = array("version" => $version,
	                          "response" => "OK",
	                          "uid" => $user['uid'],
	                          "balance" => $user['balance']
	                         );
	        echo json_encode($response);
	       }
	       else
	        bad_request();
	        
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
	        header('Content-type: application/json; charset=utf-8');
	        header("Cache-Control: no-cache, must-revalidate");
	        
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
	}
	
	function bad_request() {
	  header(':', true, 400);
	  header('Content-type: application/json; charset=utf-8');
	  header("Cache-Control: no-cache, must-revalidate");
	  
	  $response = array("version" => "0.1",
	                    "response" => "Bad Request",
	                   );
	  echo json_encode($response);
	}
	
	function forbidden() {
	  header(':', true, 403);
	  header('Content-type: application/json; charset=utf-8');
	  header("Cache-Control: no-cache, must-revalidate");
	  
	  $response = array("version" => "0.1",
	                    "response" => "Forbidden",
	                   );
	  echo json_encode($response);
	}
	
?>
