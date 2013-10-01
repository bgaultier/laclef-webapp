<?php
  /* MySQL functions */
  function open_database_connection() {
    include "settings.php";
    $link = mysqli_connect($host, $username, $password, $database);
    
    if (!$link)
      die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
    
    mysqli_query($link, "SET NAMES 'UTF8'");
    
    return $link;
  }

  function close_database_connection($link) {
    mysqli_close($link);
  }
    
  /* User Model */
  function get_all_users()
  {
		$link = open_database_connection();
		
		$query = "SELECT * FROM users ORDER BY uid ASC";
		
		$users = array();
		if ($result = mysqli_query($link, $query)) {
			// fetch associative array
			while ($row = mysqli_fetch_assoc($result)) {
				$row['tags'] = get_user_tags($row['uid']);
				$users[] = $row;
			}
				
			// free result set
			mysqli_free_result($result);
		}
		
		// close connection
    mysqli_close($link);
    
    return $users;
  }
  
  function get_all_uids()
  {
		$link = open_database_connection();
		
		$query = "SELECT uid FROM users ORDER BY uid ASC";
		
		$uids = array();
		if ($result = mysqli_query($link, $query)) {
			// fetch associative array
			while ($row = mysqli_fetch_assoc($result))
				$uids[] = $row['uid'];
				
			// free result set
			mysqli_free_result($result);
		}
		
		// close connection
    mysqli_close($link);
    
    return $uids;
  }
  
  function get_user_by_uid($uid)
  {
		$link = open_database_connection();
		
		$query = "SELECT * FROM users WHERE uid = '" . mysqli_real_escape_string($link, $uid) . "' LIMIT 1";
		
		if ($result = mysqli_query($link, $query))
			$user = mysqli_fetch_assoc($result);
		
		// free result set
		mysqli_free_result($result);
		
		// close connection
    mysqli_close($link);
    
    return $user;
  }
  
  function user_is_admin($uid) {
  		$link = open_database_connection();
  		
  		$query = "SELECT * FROM users WHERE uid = '" . mysqli_real_escape_string($link, $uid) . "' AND admin = 1 LIMIT 1";
  		
  		if ($result = mysqli_query($link, $query))
  			$user = mysqli_fetch_assoc($result);
  		
  		// free result set
  		mysqli_free_result($result);
  		
  		// close connection
    mysqli_close($link);
    
    return $user;
  }
  
  function user_is_admin_and_password_match($uid, $password) {
		$link = open_database_connection();
		
		$query = "SELECT * FROM users WHERE uid = '" . mysqli_real_escape_string($link, $uid) . "' AND password = SHA1('" . mysqli_real_escape_string($link, $password) . "') AND admin = 1";
		
		if ($result = mysqli_query($link, $query))
			$user = mysqli_fetch_assoc($result);
		
		// free result set
		mysqli_free_result($result);
		
		// close connection
    mysqli_close($link);
    
    return $user;
  }
  
  function update_user($values)
  {
		$link = open_database_connection();
		
		if(!isset($values['admin']))
		  $values['admin'] = "off";
		
		$query = "UPDATE users SET firstname = '" . mysqli_real_escape_string($link, $values['firstname']) . "', lastname = '" . mysqli_real_escape_string($link, $values['lastname']) . "', email = '" . mysqli_real_escape_string($link, $values['email']) . "', password = SHA1('" . mysqli_real_escape_string($link, $values['password']) . "'), admin = '" . filter_var($values['admin'], FILTER_VALIDATE_BOOLEAN) . "', locale = '" . mysqli_real_escape_string($link, $values['locale']) . "', balance = '" . mysqli_real_escape_string($link, $values['balance']) . "' WHERE uid = '" . mysqli_real_escape_string($link, $values['uid']) . "' LIMIT 1";
		
		$result = mysqli_query($link, $query);
		
		// free result set
		mysqli_free_result($result);
		
		// close connection
    mysqli_close($link);
    
    return $result;
  }
  
  function add_user($values)
  {
		$link = open_database_connection();
		
		$query = "INSERT INTO users (uid, firstname, lastname, email, password, admin, locale, balance) VALUES ('" . mysqli_real_escape_string($link, $values['uid']) . "', '" . mysqli_real_escape_string($link, $values['firstname']) . "', '" . mysqli_real_escape_string($link, $values['lastname']) . "', '" . mysqli_real_escape_string($link, $values['email']) . "', SHA1('" . mysqli_real_escape_string($link, $values['password']) . "'), '" . filter_var($values['admin'], FILTER_VALIDATE_BOOLEAN) . "', '" . mysqli_real_escape_string($link, $values['locale']) . "', '0,00')";
		
		$result = mysqli_query($link, $query);
		
		// free result set
		mysqli_free_result($result);
		
		// close connection
    mysqli_close($link);
    
    return $result;
  }
  
  function delete_user($uid)
  {
		$link = open_database_connection();
		
		$query = "DELETE FROM users WHERE uid = '" . mysqli_real_escape_string($link, $uid) . "' LIMIT 1";
		
		$result = mysqli_query($link, $query);
		
		// free result set
		mysqli_free_result($result);
		
		// close connection
    mysqli_close($link);
    
    return $result;
  }
  
  function get_user_balance_status($uid) {
    $user = get_user_by_uid($uid);
    $balance = $user['balance'];
    
    // status 1 : ok, status 2 : warning
    if(balance < 0)
      return 2;
    else
      return 1;
  }
  
  /* Tag Model */
  function get_all_tags() {
  		$link = open_database_connection();
  		
  		$query = "SELECT * FROM tags ORDER BY owner ASC";
  		
  		$tags = array();
  		if ($result = mysqli_query($link, $query)) {
  			// fetch associative array
  			while ($row = mysqli_fetch_assoc($result))
  				$tags[] = $row;
  				
  			// free result set
  			mysqli_free_result($result);
  		}
  		
  		// close connection
    mysqli_close($link);
    
    return $tags;
  }
  
  function get_user_tags($uid) {
  		$link = open_database_connection();
  		
  		$query = "SELECT uid, type FROM tags WHERE owner = '" . mysqli_real_escape_string($link, $uid) . "'";
  		
  		$tags = array();
  		if ($result = mysqli_query($link, $query)) {
  			// fetch associative array
  			while ($row = mysqli_fetch_assoc($result))
  				$tags[] = $row;
  				
  			// free result set
  			mysqli_free_result($result);
  		}
  		
  		// close connection
    mysqli_close($link);
    
    return $tags;
  }
  
  function get_tag_icon_html($type) {
  		switch ($type) {
  			case 0:
  				return '<i class="icon-credit-card"></i>';
      case 1:
  				return '<i class="icon-ticket"></i>';
      case 2:
  				return '<i class="icon-barcode"></i>';
      case 3:
  				return '<i class="icon-qrcode"></i>';
    }
  }
  
  function get_tag_type($type) {
  		switch ($type) {
  			case 0:
  				return _('Mifare Classic');
      case 1:
  				return _('Mifare UltraLight');
      case 2:
  				return _('Code-barres');
      case 3:
  				return _('QR code');
    }
  }
  
  function get_tag_types() {
  		return [ _('Mifare Classic'), _('Mifare UltraLight'), _('Code-barres'), _('QR code')];
  }
  
  
  function get_tag_by_uid($uid) {
		$link = open_database_connection();
		
		$query = "SELECT * FROM tags WHERE uid = '" . mysqli_real_escape_string($link, $uid) . "' LIMIT 1";
		
		if ($result = mysqli_query($link, $query))
			$tag = mysqli_fetch_assoc($result);
		
		// free result set
		mysqli_free_result($result);
		
		// close connection
    mysqli_close($link);
    
    return $tag;
  }
  
  function get_tag_owner($uid) {
		$link = open_database_connection();
		
		$query = "SELECT owner FROM tags WHERE uid = '" . mysqli_real_escape_string($link, $uid) . "' LIMIT 1";
		
		if ($result = mysqli_query($link, $query))
			$owner = mysqli_fetch_assoc($result);
		
		// free result set
		mysqli_free_result($result);
		
		// close connection
    mysqli_close($link);
    
    return $owner['owner'];
  }
  
  function update_tag($uid, $values)
  {
  		$link = open_database_connection();
  		
  		$query = "UPDATE tags SET owner = '" . mysqli_real_escape_string($link, $values['owner']) . "', keya = '" . mysqli_real_escape_string($link, $values['keya']) . "', type = '" . intval($values['type']) . "' WHERE uid = '$uid' LIMIT 1";
  		
  		$result = mysqli_query($link, $query);
  		
  		// free result set
  		mysqli_free_result($result);
  		
  		// close connection
    mysqli_close($link);
    
    return $result;
  }
  
  function add_tag($values)
  {
  		$link = open_database_connection();
  		
  		if(isset($values['type0']))
  			$type = 0;
  		elseif(isset($values['type1']))
  			$type = 1;
  		elseif(isset($values['type2']))
  			$type = 2;
  		elseif(isset($values['type3']))
  			$type = 3;
  		elseif(isset($values['type4']))
  			$type = 4;
  		
  		$query = "INSERT INTO tags (uid, owner, keya, type) VALUES ('" . mysqli_real_escape_string($link, $values['uid']) . "', '" . mysqli_real_escape_string($link, $values['owner']) . "', '" . mysqli_real_escape_string($link, $values['keya']) . "', '$type')";
  		
  		$result = mysqli_query($link, $query);
  		
  		// free result set
  		mysqli_free_result($result);
  		
  		// close connection
    mysqli_close($link);
    
    return $result;
  }
  
  function delete_tag($uid)
  {
  		$link = open_database_connection();
  		
  		$query = "DELETE FROM tags WHERE uid = '" . mysqli_real_escape_string($link, $uid) . "' LIMIT 1";
  		
  		$result = mysqli_query($link, $query);
  		
  		// free result set
  		mysqli_free_result($result);
  		
  		// close connection
    mysqli_close($link);
    
    return $result;
  }
  
  /* Reader Model */
  function get_all_readers() {
  		$link = open_database_connection();
  		
  		$query = "SELECT * FROM readers ORDER BY id ASC";
  		
  		$readers = array();
  		if ($result = mysqli_query($link, $query)) {
  			// fetch associative array
  			while ($row = mysqli_fetch_assoc($result)) {
  			  $row['permissions'] = get_reader_permissions($row['id']);
  				$readers[] = $row;
  			}
  				
  			// free result set
  			mysqli_free_result($result);
  		}
  		
  		// close connection
    mysqli_close($link);
    
    return $readers;
  }
  
  function get_all_ids() {
  		$link = open_database_connection();
  		
  		$query = "SELECT id FROM readers ORDER BY id ASC";
  		
  		$ids = array();
  		if ($result = mysqli_query($link, $query)) {
  			// fetch associative array
  			while ($row = mysqli_fetch_assoc($result))
  				$ids[] = $row['id'];
  				
  			// free result set
  			mysqli_free_result($result);
  		}
  		
  		// close connection
    mysqli_close($link);
    
    return $ids;
  }
  
  function get_reader_permissions($id) {
  		$link = open_database_connection();
  		
  		$query = "SELECT uid, end FROM permissions WHERE id = '" . mysqli_real_escape_string($link, $id) . "'";
  		
  		$permissions = array();
  		if ($result = mysqli_query($link, $query)) {
  			// fetch associative array
  			while ($row = mysqli_fetch_assoc($result))
  				$permissions[] = $row;
  				
  			// free result set
  			mysqli_free_result($result);
  		}
  		
  		// close connection
    mysqli_close($link);
    
    return $permissions;
  }
  
  function get_permission($uid, $id) {
  		$link = open_database_connection();
  		
  		$query = "SELECT * FROM permissions WHERE uid = '" . mysqli_real_escape_string($link, $uid) . "' AND id = '" . mysqli_real_escape_string($link, $id) . "'";
  		
  		if ($result = mysqli_query($link, $query))
  			$permission = mysqli_fetch_assoc($result);
  		
  		// free result set
  		mysqli_free_result($result);
  		
  		// close connection
    mysqli_close($link);
    
    return $permission;
  }
  
  function get_service_icon_html($service) {
    switch ($service) {
      case 0:
        return '<span class="tooltip" data-tip-text="' .  get_reader_service($service) . '"data-tip-where="up" data-tip-color="black"><span class="icon-stack"><i class="icon-check-empty icon-stack-base"></i><i class="icon-unlock"></i></span></span>';
      case 1:
        return '<span class="tooltip" data-tip-text="' .  get_reader_service($service) . '"data-tip-where="up" data-tip-color="black"><span class="icon-stack"><i class="icon-check-empty icon-stack-base"></i><i class="icon-shopping-cart"></i></span></span>';
  		case 2:
  		  return '<span class="tooltip" data-tip-text="' .  get_reader_service($service) . '"data-tip-where="up" data-tip-color="black"><span class="icon-stack"><i class="icon-check-empty icon-stack-base"></i><i class="icon-tablet"></i></span></span>';
    }
  }
  
  function get_reader_service($service) {
    switch ($service) {
			case 0:
			  return _('Déverouillage de porte');
      case 1:
  				return _('Paiement');
      case 2:
  				return _('Location de matériel');
    }
  }
  
  function get_reader_services() {
  		return [ _('Ouverture de porte'), _('Paiement'), _('Location de matériel')];
  }
  
  
  function get_reader_by_id($id) {
		$link = open_database_connection();
		
		$query = "SELECT * FROM readers WHERE id = '" . mysqli_real_escape_string($link, $id) . "' LIMIT 1";
		
		if ($result = mysqli_query($link, $query)) {
			$reader = mysqli_fetch_assoc($result);
			$reader['permissions'] = get_reader_permissions($reader['id']);
		}
		
		// free result set
		mysqli_free_result($result);
		
		// close connection
    mysqli_close($link);
    
    return $reader;
  }
  
  function is_payment_reader($id) {
		$services = get_reader_services_by_id($id);
		if(in_array(1, $services))
		  return true;
		else
		  return false;
	}
  
  function get_reader_services_by_id($id) {
		$link = open_database_connection();
		
		$query = "SELECT services FROM readers WHERE id = '" . mysqli_real_escape_string($link, $id) . "' LIMIT 1";
		
		if ($result = mysqli_query($link, $query))
		  $services = mysqli_fetch_assoc($result);
		
		// free result set
		mysqli_free_result($result);
		
		// close connection
    mysqli_close($link);
    
    return explode(',', $services['services']);
  }
  
  
  
  function get_reader_location_by_id($id) {
		$link = open_database_connection();
		
		$query = "SELECT location FROM readers WHERE id = '" . mysqli_real_escape_string($link, $id) . "' LIMIT 1";
		
		if ($result = mysqli_query($link, $query)) {
			$reader = mysqli_fetch_assoc($result);
		}
		
		// free result set
		mysqli_free_result($result);
		
		// close connection
    mysqli_close($link);
    
    return $reader['location'];
  }
  
  function update_reader($id, $values)
  {
		$link = open_database_connection();
		
		$query = "UPDATE tags SET owner = '" . mysqli_real_escape_string($link, $values['owner']) . "', keya = '" . mysqli_real_escape_string($link, $values['keya']) . "', type = '" . intval($values['type']) . "' WHERE uid = '$uid' LIMIT 1";
		
		$result = mysqli_query($link, $query);
		
		// free result set
		mysqli_free_result($result);
		
		// close connection
    mysqli_close($link);
    
    return $result;
  }
  
  function add_reader($values)
  {
		$link = open_database_connection();
		
		if(isset($values['type0']))
			$type = 0;
		elseif(isset($values['type1']))
			$type = 1;
		elseif(isset($values['type2']))
			$type = 2;
		elseif(isset($values['type3']))
			$type = 3;
		elseif(isset($values['type4']))
			$type = 4;
		
		$query = "INSERT INTO tags (uid, owner, keya, type) VALUES ('" . mysqli_real_escape_string($link, $values['uid']) . "', '" . mysqli_real_escape_string($link, $values['owner']) . "', '" . mysqli_real_escape_string($link, $values['keya']) . "', '$type')";
		
		$result = mysqli_query($link, $query);
		
		// free result set
		mysqli_free_result($result);
		
		// close connection
    mysqli_close($link);
    
    return $result;
  }
  
  function delete_reader($id)
  {
		$link = open_database_connection();
		
		$query = "DELETE FROM readers WHERE id = '" . mysqli_real_escape_string($link, $id) . "' LIMIT 1";
		
		$result = mysqli_query($link, $query);
		
		// free result set
		mysqli_free_result($result);
		
		// close connection
    mysqli_close($link);
    
    return $result;
  }
  
  function add_all_user_to_a_reader($id)
  {		
		$uids = get_all_uids();
		foreach ($uids as $uid) {
		  add_permission($uid, $id, null);
		}
  }
  
  function add_permission($uid, $id, $end)
  {
    $link = open_database_connection();
    
    if($end)
      $end_str = "'" . mysqli_real_escape_string($link, $end) . "'";
    else
      $end_str = "NULL";
    
    $query = "INSERT INTO permissions (uid, id, end) VALUES ('" . mysqli_real_escape_string($link, $uid) . "', '" . mysqli_real_escape_string($link, $id) . "', $end_str)";
    
    $result = mysqli_query($link, $query);
    
    // free result set
		mysqli_free_result($result);
		
		// close connection
    mysqli_close($link);
    
    return $result;
  }
  
  
  
  function delete_permission($uid, $id)
  {
		$link = open_database_connection();
		
		$query = "DELETE FROM permissions WHERE uid = '" . mysqli_real_escape_string($link, $uid) . "' AND id = '" . mysqli_real_escape_string($link, $id) . "' LIMIT 1";
		
		$result = mysqli_query($link, $query);
		
		// free result set
		mysqli_free_result($result);
		
		// close connection
    mysqli_close($link);
    
    return $result;
  }
  
  function update_permission($uid, $id, $end)
  {
    $link = open_database_connection();
    
    if($end)
      $end_str = "'" . mysqli_real_escape_string($link, $end) . "'";
    else
      $end_str = "NULL";
		
		$query = "UPDATE permissions SET end = $end_str WHERE uid = '" . mysqli_real_escape_string($link, $uid) . "' AND id = '" . mysqli_real_escape_string($link, $id) . "' LIMIT 1";
		
		$result = mysqli_query($link, $query);
		
		// free result set
		mysqli_free_result($result);
		
		// close connection
    mysqli_close($link);
    
    return $result;
  }
  
  /* Swipe Model */
  function get_all_swipes()
  {
    $link = open_database_connection();
    
    $query = "SELECT * FROM swipes ORDER BY timestamp DESC LIMIT 0,200";
    
    $swipes = array();
		if ($result = mysqli_query($link, $query)) {
			// fetch associative array
			while ($row = mysqli_fetch_assoc($result)) {
			  $row['location'] = get_reader_location_by_id($row['id']);
				$swipes[] = $row;
			}
				
			// free result set
			mysqli_free_result($result);
		}
		
		// close connection
    mysqli_close($link);
    
    return $swipes;
  }
  
  function add_swipe($timestamp, $id, $uid, $service, $status)
  {
    $link = open_database_connection();
		
		$query = "INSERT INTO swipes (timestamp, id, uid, service, status) VALUES ('" . mysqli_real_escape_string($link, $timestamp) . "', '" . mysqli_real_escape_string($link, $id) . "', '" . mysqli_real_escape_string($link, $uid) . "', '" . mysqli_real_escape_string($link, $service) . "', '" . mysqli_real_escape_string($link, $status) . "')";
		
		$result = mysqli_query($link, $query);
		
		// free result set
		mysqli_free_result($result);
		
		// close connection
    mysqli_close($link);
    
    return $result;		
  }
  
  function datetime_to_string($datetime) {
    if(!isset($datetime))
      return _("Aucune date de fin");
  
    $today = date('Y-m-d');
    $yesterday = date('Y-m-d', strtotime('-1 day'));
    
    if(date('Y-m-d', strtotime($datetime)) == $today)
      return _("Aujourd'hui à ") . substr($datetime, -8, 5);
    elseif(date('Y-m-d', strtotime($datetime)) == $yesterday)
      return _("Hier à ") . substr($datetime, -8, 5);
    else {
      if(getenv('LANG') == 'fr_FR')
        return date('\L\e d/m/Y \à h:i', strtotime($datetime));
      else
        return $datetime;
    }
  }
  
  /* Payment Model */
  function get_all_payments()
  {
    $link = open_database_connection();
    
    $query = "SELECT * FROM payments ORDER BY timestamp DESC LIMIT 0,200";
    
    $payments = array();
		if ($result = mysqli_query($link, $query)) {
			// fetch associative array
			while ($row = mysqli_fetch_assoc($result)) {
				$user = get_user_by_uid($row['uid']);
				$row['firstname'] = $user['firstname'];
				$row['lastname'] = $user['lastname'];
				$payments[] = $row;
			}
				
			// free result set
			mysqli_free_result($result);
		}
		
		// close connection
    mysqli_close($link);
    
    return $payments;
  }
  
  function add_payment($uid, $amount)
  {
  		//TODO Store the IP client address, can be useful if you wanna blacklist hackers
  		if(floatval($amount) > 0) {
		  $link = open_database_connection();
		
			$query = "INSERT INTO payments (uid, amount, timestamp) VALUES ('" . mysqli_real_escape_string($link, $uid) . "', '" . floatval($amount) . "', '" . date('Y-m-d H:i:s') . "')";
		
			$result = mysqli_query($link, $query);
		
			// free result set
			mysqli_free_result($result);
		
			// close connection
		  mysqli_close($link);
		  
		  // credit user account
		  credit_account($uid, $amount);
		  
		  return false;
		}
		else
			return true;
  }
  
  function credit_account($uid, $amount)
  {
  		$user = get_user_by_uid($uid);
  		$current_balance = $user['balance'];
  		$new_balance = $current_balance + floatval($amount);
  		
  		$link = open_database_connection();
  		
  		$query = "UPDATE users SET balance = '$new_balance' WHERE uid = '" . mysqli_real_escape_string($link, $uid) . "' LIMIT 1";
  		
  		$result = mysqli_query($link, $query);
  		
  		// free result set
  		mysqli_free_result($result);
  		
  		// close connection
    mysqli_close($link);
    
    return $result;
  }
  
  /* Snack Model */
  function get_all_snacks() {
    $link = open_database_connection();
		
		$query = "SELECT * FROM snacks";
		
		$snacks = array();
		if ($result = mysqli_query($link, $query)) {
			// fetch associative array
			while ($row = mysqli_fetch_assoc($result))
				$snacks[] = $row;
				
			// free result set
			mysqli_free_result($result);
		}
		
		// close connection
    mysqli_close($link);
    
    return $snacks;
  }
  
  function add_snack($description_fr_FR, $description_en_US, $price, $visible)
  {
  		$link = open_database_connection();
  		
  		$query = "INSERT INTO snacks (id, description_fr_FR, description_en_US, price, visible) VALUES ('', '" . mysqli_real_escape_string($link, $description_fr_FR) . "', '" . mysqli_real_escape_string($link, $description_en_US) . "', '" . floatval($price) . "', '" . filter_var($visible, FILTER_VALIDATE_BOOLEAN) . "')";
		
		$result = mysqli_query($link, $query);
		
		// free result set
		mysqli_free_result($result);
		
		// close connection
    mysqli_close($link);
    
    return $result;
  }
  
  function get_snack_by_id($id) {
  		$link = open_database_connection();
		
		$query = "SELECT * FROM snacks WHERE id = '" . mysqli_real_escape_string($link, $id) . "' LIMIT 1";
		
		if ($result = mysqli_query($link, $query))
			$snack = mysqli_fetch_assoc($result);
		
		// free result set
		mysqli_free_result($result);
		
		// close connection
    mysqli_close($link);
    
    return $snack;
  }
  
  function delete_snack($id)
  {
		$link = open_database_connection();
		
		$query = "DELETE FROM snacks WHERE id = '" . mysqli_real_escape_string($link, $id) . "' LIMIT 1";
		
		$result = mysqli_query($link, $query);
		
		// free result set
		mysqli_free_result($result);
		
		// close connection
    mysqli_close($link);
    
    return $result;
  }
  
  function update_snack($id, $description_fr_FR, $description_en_US, $price, $visible)
  {
    $link = open_database_connection();
    
    if(!isset($visible))
      $visible = "off";
    
    $query = "UPDATE snacks SET description_fr_FR = '" . mysqli_real_escape_string($link, $description_fr_FR) . "', description_en_US = '" . mysqli_real_escape_string($link, $description_en_US) . "', price = '" . mysqli_real_escape_string($link, $price) . "', visible = '" . filter_var($visible, FILTER_VALIDATE_BOOLEAN) . "' WHERE id = '" . mysqli_real_escape_string($link, $id) . "' LIMIT 1";
  		
		$result = mysqli_query($link, $query);
		
		// free result set
		mysqli_free_result($result);
		
		// close connection
    mysqli_close($link);
    
    return $result;
  }
  
  function update_user_locale($uid, $locale)
  {
		$link = open_database_connection();
		
		$query = "UPDATE users SET locale = '" . mysqli_real_escape_string($link, $locale) . "' WHERE uid = '" . mysqli_real_escape_string($link, $uid) . "' LIMIT 1";
		
		$result = mysqli_query($link, $query);
		
		// free result set
		mysqli_free_result($result);
		
		// close connection
    mysqli_close($link);
    
    return $result;
  }
	
?>
