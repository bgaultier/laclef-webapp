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
				$row['equipments'] = get_user_equipments($row['uid']);
				$users[] = $row;
			}

			// free result set
			mysqli_free_result($result);
		}

		// close connection
		mysqli_close($link);

		return $users;
	}

	function get_all_users_sorted_by_lastname_ascending()
	{
		$link = open_database_connection();

		$query = "SELECT * FROM users ORDER BY lastname ASC";

		$users = array();
		if ($result = mysqli_query($link, $query)) {
			// fetch associative array
			while ($row = mysqli_fetch_assoc($result)) {
				$row['tags'] = get_user_tags($row['uid']);
				$row['equipments'] = get_user_equipments($row['uid']);
				$users[] = $row;
			}

			// free result set
			mysqli_free_result($result);
		}

		// close connection
		mysqli_close($link);

		return $users;
	}

	function search_users($pattern) {
			$link = open_database_connection();

		$query = "SELECT * FROM users WHERE firstname LIKE '%" . mysqli_real_escape_string($link, $pattern) . "%' OR lastname LIKE '%" . mysqli_real_escape_string($link, $pattern) . "%'";

		$users = array();
		if ($result = mysqli_query($link, $query)) {
			// fetch associative array
			while ($row = mysqli_fetch_assoc($result))
				$users[] = $row;

			// free result set
			mysqli_free_result($result);
		}

		// close connection
		mysqli_close($link);

		return $users;
	}

	function send_paypal_email($email, $amount)
	{
		$receiver = "b.gaultier@gmail.com";
		$headers = "From: kfet@laclef.cc";
		$subject = "Demande de crédit kfet par Paypal";
		$message =	"Email : $email\nMontant : $amount €";

		return mail($receiver, $subject, $message, $headers);
	}

	function get_all_users_sorted_by_balance_descending()
	{
		$link = open_database_connection();

		$query = "SELECT * FROM users ORDER BY balance DESC";

		$users = array();
		if ($result = mysqli_query($link, $query)) {
			// fetch associative array
			while ($row = mysqli_fetch_assoc($result)) {
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

	function get_admin_email()
	{
		$link = open_database_connection();

		$query = "SELECT * FROM users WHERE admin = '1' LIMIT 1";

		if ($result = mysqli_query($link, $query))
			$admin = mysqli_fetch_assoc($result);

		// free result set
		mysqli_free_result($result);

		// close connection
		mysqli_close($link);

		return $admin['email'];
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

		$query = "UPDATE users SET firstname = '" . mysqli_real_escape_string($link, $values['firstname']) . "', lastname = '" . mysqli_real_escape_string($link, $values['lastname']) . "', email = '" . mysqli_real_escape_string($link, $values['email']) . "', password = SHA1('" . mysqli_real_escape_string($link, $values['password']) . "'), admin = '" . filter_var($values['admin'], FILTER_VALIDATE_BOOLEAN) . "', locale = '" . mysqli_real_escape_string($link, $values['locale']) . "' WHERE uid = '" . mysqli_real_escape_string($link, $values['uid']) . "' LIMIT 1";

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

		$uid = strtolower(str_replace(' ', '', $values['firstname'][0] . substr($values['lastname'], 0, 7)));

		$query = "INSERT INTO users (uid, firstname, lastname, email, password, admin, locale, balance) VALUES ('" .
							$uid . "', '" .
							mysqli_real_escape_string($link, $values['firstname']) . "', '" .
							mysqli_real_escape_string($link, $values['lastname']) . "', '" .
							mysqli_real_escape_string($link, $values['email']) . "', SHA1('" .
							mysqli_real_escape_string($link, $values['password']) . "'), '" .
							filter_var($values['admin'], FILTER_VALIDATE_BOOLEAN) . "', '" .
							mysqli_real_escape_string($link, $values['locale']) . "', '0,00')";

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
			case 4:
					return '<i class="fa fa-cube"></i>';
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
			return array(_('Mifare Classic'), _('Mifare UltraLight'), _('Code-barres'), _('QR code'));
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
				return '<span class="tooltip" data-tip-text="' .	get_reader_service($service) . '"data-tip-where="up" data-tip-color="black"><span class="icon-stack"><i class="icon-check-empty icon-stack-base"></i><i class="icon-unlock"></i></span></span>';
			case 1:
				return '<span class="tooltip" data-tip-text="' .	get_reader_service($service) . '"data-tip-where="up" data-tip-color="black"><span class="icon-stack"><i class="icon-check-empty icon-stack-base"></i><i class="icon-shopping-cart"></i></span></span>';
			case 2:
				return '<span class="tooltip" data-tip-text="' .	get_reader_service($service) . '"data-tip-where="up" data-tip-color="black"><span class="icon-stack"><i class="icon-check-empty icon-stack-base"></i><i class="icon-tablet"></i></span></span>';
			case 3:
				return '<span class="tooltip" data-tip-text="' .	get_reader_service($service) . '"data-tip-where="up" data-tip-color="black"><span class="icon-stack"><i class="icon-check-empty icon-stack-base"></i><i class="icon-money"></i></span></span>';
			case 4:
				return '<span class="tooltip" data-tip-text="' .	get_reader_service($service) . '"data-tip-where="up" data-tip-color="black"><span class="fa-stack"><i class="fa fa-square-o fa-stack-2x"></i><i class="fa fa-cube fa-stack-1x"></i></span></span>';
			case 5:
				return '<span class="tooltip" data-tip-text="' .	get_reader_service($service) . '"data-tip-where="up" data-tip-color="black"><span class="icon-stack"><i class="icon-check-empty icon-stack-base"></i><i class="icon-briefcase"></i></span></span>';
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
			case 3:
				return _('Virement');
			case 4:
				return _('Impression 3D');
			case 5:
				return _('Cotravail');
		}
	}

	function get_reader_services() {
			return array(_('Ouverture de porte'), _('Paiement'), _('Location de matériel'), _('Virement'), _('Impression 3D'), _('Cotravail'));
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
		if(in_array(1, $services) || $id == 0)
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
				$row['location'] = get_reader_location_by_id($row['reader']);
				$swipes[] = $row;
			}

			// free result set
			mysqli_free_result($result);
		}

		// close connection
		mysqli_close($link);

		return $swipes;
	}

	function get_all_swipes_by_reader($id)
	{
		$link = open_database_connection();

		$query = "SELECT * FROM swipes WHERE reader = '" . mysqli_real_escape_string($link, $id) . "' ORDER BY timestamp DESC";

		$swipes = array();
		if ($result = mysqli_query($link, $query)) {
			// fetch associative array
			while ($row = mysqli_fetch_assoc($result)) {
				$swipes[] = $row;
			}

			// free result set
			mysqli_free_result($result);
		}

		// close connection
		mysqli_close($link);

		return $swipes;
	}


	function get_all_swipes_today()
	{
		$link = open_database_connection();

		$query = "SELECT * FROM swipes WHERE DAY(timestamp) = DAY(NOW()) AND MONTH(timestamp) = MONTH(NOW()) AND YEAR(timestamp) = YEAR(NOW())";

		$swipes = array();
		if ($result = mysqli_query($link, $query)) {
			// fetch associative array
			while ($row = mysqli_fetch_assoc($result)) {
				$swipes[] = $row;
			}

			// free result set
			mysqli_free_result($result);
		}

		// close connection
		mysqli_close($link);

		return $swipes;
	}

	function get_all_swipes_this_month()
	{
		$link = open_database_connection();

		$query = "SELECT * FROM swipes WHERE MONTH(timestamp) = MONTH(NOW()) AND YEAR(timestamp) = YEAR(NOW())";

		$swipes = array();
		if ($result = mysqli_query($link, $query)) {
			// fetch associative array
			while ($row = mysqli_fetch_assoc($result)) {
				$swipes[] = $row;
			}

			// free result set
			mysqli_free_result($result);
		}

		// close connection
		mysqli_close($link);

		return $swipes;
	}

	function get_all_swipes_by_month($month, $year)
	{
		$link = open_database_connection();

		$query = "SELECT * FROM swipes WHERE MONTH(timestamp) = '" . mysqli_real_escape_string($link, $month) . "' AND YEAR(timestamp) = '" . mysqli_real_escape_string($link, $year) . "'";

		$swipes = array();
		if ($result = mysqli_query($link, $query)) {
			// fetch associative array
			while ($row = mysqli_fetch_assoc($result)) {
				$swipes[] = $row;
			}

			// free result set
			mysqli_free_result($result);
		}

		// close connection
		mysqli_close($link);

		return $swipes;
	}

	function get_swipe_by_id($id)
	{
		$link = open_database_connection();

		$query = "SELECT * FROM swipes WHERE id = '" . mysqli_real_escape_string($link, $id) . "' LIMIT 1";

		if ($result = mysqli_query($link, $query)) {
			$swipe = mysqli_fetch_assoc($result);

			// free result set
			mysqli_free_result($result);
		}

		// close connection
		mysqli_close($link);

		return $swipe;
	}

	function add_swipe($reader, $uid, $service, $status)
	{
		$link = open_database_connection();

		$query = "INSERT INTO swipes (id, timestamp, reader, uid, service, status) VALUES ('', NOW(), '" . mysqli_real_escape_string($link, $reader) . "', '" . mysqli_real_escape_string($link, $uid) . "', '" . mysqli_real_escape_string($link, $service) . "', '" . mysqli_real_escape_string($link, $status) . "')";

		$result = mysqli_query($link, $query);

		$id = mysqli_insert_id($link);

		// free result set
		mysqli_free_result($result);

		// close connection
		mysqli_close($link);

		return $id;
	}

	function add_swipe_timestamped($id, $timestamp, $uid, $service, $status)
	{
		$link = open_database_connection();

		$query = "INSERT INTO swipes (id, timestamp, reader, uid, service, status) VALUES ('', '" . mysqli_real_escape_string($link, $timestamp) . "', '" . mysqli_real_escape_string($link, $id) . "', '" . mysqli_real_escape_string($link, $uid) . "', '" . mysqli_real_escape_string($link, $service) . "', '" . mysqli_real_escape_string($link, $status) . "')";

		$result = mysqli_query($link, $query);

		$id = mysqli_insert_id($link);

		// free result set
		mysqli_free_result($result);

		// close connection
		mysqli_close($link);

		return $id;
	}

	/* Order Model */
	function get_all_orders()
	{
		$link = open_database_connection();

		$query = "SELECT * FROM orders ORDER BY id DESC LIMIT 0,200";

		$orders = array();
		if ($result = mysqli_query($link, $query)) {
			// fetch associative array
			while ($row = mysqli_fetch_assoc($result)) {
				$swipe = get_swipe_by_id($row['swipe']);
				$row['timestamp'] = $swipe['timestamp'];
				$row['uid'] = $swipe['uid'];
				$row['reader'] = $swipe['reader'];
				$row['location'] = get_reader_location_by_id($swipe['reader']);
				$orders[] = $row;
			}

			// free result set
			mysqli_free_result($result);
		}

		// close connection
		mysqli_close($link);

		return $orders;
	}

	function get_last_order_timestamp_by_uid($uid)
	{
		$link = open_database_connection();

		$query = "SELECT * FROM swipes WHERE uid = '" . mysqli_real_escape_string($link, $uid) . "' AND service = 1 OR service = 4 ORDER BY timestamp DESC LIMIT 0,1";

		if ($result = mysqli_query($link, $query)) {
			$swipe = mysqli_fetch_assoc($result);
			$swipe['location'] = get_reader_location_by_id($swipe['reader']);
		}

		// free result set
		mysqli_free_result($result);

		// close connection
		mysqli_close($link);

		return $swipe['timestamp'];
	}

	function add_order($swipe, $snack, $quantity)
	{
		$link = open_database_connection();

		$snack = get_snack_by_id($snack);

		if($snack)
			$query = "INSERT INTO orders (id, swipe, snack, quantity) VALUES ('', '" . mysqli_real_escape_string($link, $swipe) . "', '" . mysqli_real_escape_string($link, $snack['id']) . "', '" . mysqli_real_escape_string($link, $quantity) . "')";

		$result = mysqli_query($link, $query);

		// free result set
		mysqli_free_result($result);

		// close connection
		mysqli_close($link);

		return $result;
	}

	function get_all_orders_by_uid($uid)
	{
		$link = open_database_connection();

		$query = "SELECT * FROM orders WHERE swipe IN (
							SELECT id FROM swipes WHERE uid = '" . mysqli_real_escape_string($link, $uid) . "') ORDER BY id DESC LIMIT 0,200";

		$orders = array();
		if ($result = mysqli_query($link, $query)) {
			// fetch associative array
			while ($row = mysqli_fetch_assoc($result)) {
				$swipe = get_swipe_by_id($row['swipe']);
				$row['timestamp'] = $swipe['timestamp'];
				$row['uid'] = $swipe['uid'];
				$row['reader'] = $swipe['reader'];
				$row['location'] = get_reader_location_by_id($swipe['reader']);
				$orders[] = $row;
			}

			// free result set
			mysqli_free_result($result);
		}

		// close connection
		mysqli_close($link);

		return $orders;
	}

	function get_all_orders_by_swipe($swipe)
	{
		$link = open_database_connection();

		$query = "SELECT * FROM orders WHERE swipe = '" . mysqli_real_escape_string($link, $swipe) . "'";

		$orders = array();
		if ($result = mysqli_query($link, $query)) {
			// fetch associative array
			while ($row = mysqli_fetch_assoc($result)) {
				$orders[] = $row;
			}

			// free result set
			mysqli_free_result($result);
		}

		// close connection
		mysqli_close($link);

		return $orders;
	}

	function get_first_coffee()
	{
		$link = open_database_connection();

		$query = "SELECT * FROM orders WHERE (snack =2 OR snack =1) AND swipe IN (SELECT id FROM swipes WHERE DAY(timestamp) = DAY(NOW()) AND MONTH(timestamp) = MONTH(NOW()) AND YEAR(timestamp) = YEAR(NOW()) ORDER BY timestamp DESC) LIMIT 1 ";

		if ($result = mysqli_query($link, $query))
			$order = mysqli_fetch_assoc($result);

		// free result set
		mysqli_free_result($result);

		// close connection
		mysqli_close($link);

		if($order) {
			$swipe = get_swipe_by_id($order['swipe']);
			$user = get_user_by_uid($swipe['uid']);
			$swipe['firstname'] = $user['firstname'];
		}

		return $swipe;
	}

	function get_coffees()
	{
		$link = open_database_connection();

		$query = "SELECT SUM(quantity) AS coffees FROM orders WHERE snack = 1 OR snack = 2";

		if ($result = mysqli_query($link, $query))
			$coffees = mysqli_fetch_assoc($result);

		// free result set
		mysqli_free_result($result);

		// close connection
		mysqli_close($link);

		if(!$coffees['coffees'])
			$coffees['coffees'] = 0;

		return $coffees['coffees'];
	}

	function get_coffees_this_month()
	{
		$link = open_database_connection();

		$query = "SELECT SUM(quantity) AS coffees FROM orders WHERE (snack = 2 OR snack = 1) AND swipe IN (
							SELECT id FROM swipes WHERE MONTH(timestamp) = MONTH(NOW()) AND YEAR(timestamp) = YEAR(NOW()))";

		if ($result = mysqli_query($link, $query))
			$coffees = mysqli_fetch_assoc($result);

		// free result set
		mysqli_free_result($result);

		// close connection
		mysqli_close($link);

		if($coffees['coffees'])
			return $coffees['coffees'];
		else
			return 0;
	}

	function get_user_orders_by_snack($uid, $id)
	{
		$link = open_database_connection();

		$query = "SELECT SUM(quantity) AS total FROM orders WHERE snack = " . mysqli_real_escape_string($link, $id) . " AND swipe IN (SELECT id FROM swipes WHERE uid = '" . mysqli_real_escape_string($link, $uid) . "')";

		if ($result = mysqli_query($link, $query))
			$orders = mysqli_fetch_assoc($result);

		// free result set
		mysqli_free_result($result);

		// close connection
		mysqli_close($link);

		if($orders['total'])
			return $orders['total'];
		else
			return 0;
	}

	function get_coffees_by_month($month, $year)
	{
		$link = open_database_connection();

		$query = "SELECT SUM(quantity) AS coffees FROM orders WHERE (snack = 2 OR snack = 1) AND swipe IN (
							SELECT id FROM swipes WHERE MONTH(timestamp) = '" . mysqli_real_escape_string($link, $month) . "' AND YEAR(timestamp) = '" . mysqli_real_escape_string($link, $year) . "')";

		if ($result = mysqli_query($link, $query)) {
			$coffees = mysqli_fetch_assoc($result);

			// free result set
			mysqli_free_result($result);
		}

		// close connection
		mysqli_close($link);

		if($coffees['coffees'])
			return $coffees['coffees'];
		else
			return 0;
	}

	function get_coffees_this_month_by_uid($uid)
	{
		$link = open_database_connection();

		$query = "SELECT SUM(quantity) AS coffees FROM orders WHERE (snack = 2 OR snack = 1) AND swipe IN (
							SELECT id FROM swipes WHERE uid = '" . mysqli_real_escape_string($link, $uid) . "' AND MONTH(timestamp) = MONTH(NOW()) AND YEAR(timestamp) = YEAR(NOW()))";

		if ($result = mysqli_query($link, $query)) {
			$coffees = mysqli_fetch_assoc($result);

			// free result set
			mysqli_free_result($result);
		}

		// close connection
		mysqli_close($link);

		if($coffees['coffees'])
			return $coffees['coffees'];
		else
			return 0;
	}

	function new_order($values)
	{
		$user = get_user_by_uid($values['client']);

		unset($values['transfers']);
		unset($values['recipient']);

		unset($values['client']);
		unset($values['sub']);
		$values['reader'] = intval($values['reader']);

		$debit = 0.0;
		if($user) {
			$swipe = add_swipe($values['reader'], $user['uid'], 1, 1);
			foreach ($values as $snack_id => $quantity)
			{
				if($quantity > 0)
				{
					$snack = get_snack_by_id(intval(str_replace('snack_', '', $snack_id)));
					add_order($swipe, $snack['id'], $quantity);
					$debit += $quantity * floatval($snack['price']);
				}
			}
			if($debit > 0)
				debit_account($user['uid'], $debit);
		}
	}

	function new_transfer($receiver, $transfers, $values)
	{
		$user = get_user_by_uid($values['client']);

		$values['reader'] = intval($values['reader']);

		$amount = 0.0;
		$amount = intval($transfers) * 0.5;
		if($user) {
			$swipe = add_swipe(0, $user['uid'], 3, 1);
			debit_account($user['uid'], $amount);
			add_payment($receiver, $amount);
			new_order($values);
		}
	}

	function get_all_orders_today()
	{
		$link = open_database_connection();

		$query = "SELECT * FROM orders WHERE swipe IN (
							SELECT id FROM swipes WHERE DAY(timestamp) = DAY(NOW()) AND MONTH(timestamp) = MONTH(NOW()) AND YEAR(timestamp) = YEAR(NOW()))";

		$orders = array();
		if ($result = mysqli_query($link, $query)) {
			// fetch associative array
			while ($row = mysqli_fetch_assoc($result))
				$orders[] = $row;

			// free result set
			mysqli_free_result($result);
		}

		// close connection
		mysqli_close($link);

		return $orders;
	}

	function get_all_orders_this_month()
	{
		$link = open_database_connection();

		$query = "SELECT * FROM orders WHERE swipe IN (SELECT id FROM swipes WHERE MONTH(timestamp) = MONTH(NOW()) AND YEAR(timestamp) = YEAR(NOW()))";

		$orders = array();
		if ($result = mysqli_query($link, $query)) {
			// fetch associative array
			while ($row = mysqli_fetch_assoc($result))
				$orders[] = $row;

			// free result set
			mysqli_free_result($result);
		}

		// close connection
		mysqli_close($link);

		return $orders;
	}

	function get_all_orders_this_month_by_uid($uid)
	{
		$link = open_database_connection();

		$query = "SELECT * FROM orders WHERE swipe IN (
							SELECT id FROM swipes WHERE uid = '" . mysqli_real_escape_string($link, $uid) . "' AND MONTH(timestamp) = MONTH(NOW()) AND YEAR(timestamp) = YEAR(NOW()))";

		/*$sql = 'SELECT *'
				. ' FROM swipes'
				. ' INNER JOIN orders ON swipes.id = orders.swipe'
				. ' WHERE uid = \'bgault02\' AND MONTH(timestamp) = MONTH(NOW()) AND YEAR(timestamp) = YEAR(NOW()) LIMIT 0, 30 '; */

		$orders = array();
		if ($result = mysqli_query($link, $query)) {
			// fetch associative array
			while ($row = mysqli_fetch_assoc($result))
				$orders[] = $row;

			// free result set
			mysqli_free_result($result);
		}

		// close connection
		mysqli_close($link);

		return $orders;
	}

	function get_all_orders_today_by_uid($uid)
	{
		$link = open_database_connection();

		$query = "SELECT * FROM orders WHERE swipe IN (
							SELECT id FROM swipes WHERE uid = '" . mysqli_real_escape_string($link, $uid) . "' AND DAY(timestamp) = DAY(NOW()) AND MONTH(timestamp) = MONTH(NOW()) AND YEAR(timestamp) = YEAR(NOW()))";

		$orders = array();
		if ($result = mysqli_query($link, $query)) {
			// fetch associative array
			while ($row = mysqli_fetch_assoc($result))
				$orders[] = $row;

			// free result set
			mysqli_free_result($result);
		}

		// close connection
		mysqli_close($link);

		return $orders;
	}

	function get_coffees_today()
	{
		$link = open_database_connection();

		$query = "SELECT SUM(quantity) AS coffees FROM orders WHERE (snack = 2 OR snack = 1) AND swipe IN (
							SELECT id FROM swipes WHERE DAY(timestamp) = DAY(NOW()) AND MONTH(timestamp) = MONTH(NOW()) AND YEAR(timestamp) = YEAR(NOW()))";

		if ($result = mysqli_query($link, $query))
			$coffees = mysqli_fetch_assoc($result);

		// free result set
		mysqli_free_result($result);

		// close connection
		mysqli_close($link);

		if($coffees['coffees'])
			return $coffees['coffees'];
		else
			return 0;
	}

	function get_coffees_today_by_uid($uid)
	{
		$link = open_database_connection();

		$query = "SELECT SUM(quantity) AS coffees FROM orders WHERE (snack = 2 OR snack = 1) AND swipe IN (
							SELECT id FROM swipes WHERE uid = '" . mysqli_real_escape_string($link, $uid) . "' AND DAY(timestamp) = DAY(NOW()) AND MONTH(timestamp) = MONTH(NOW()) AND YEAR(timestamp) = YEAR(NOW()))";

		if ($result = mysqli_query($link, $query))
			$coffees = mysqli_fetch_assoc($result);

		// free result set
		mysqli_free_result($result);

		// close connection
		mysqli_close($link);

		if($coffees['coffees'])
			return $coffees['coffees'];
		else
			return 0;
	}

	function get_money_spent_today()
	{
		$orders = array();
		$orders = get_all_orders_today();
		$money_spent_today = 0.0;

		foreach ($orders as $order) {
			$snack = get_snack_by_id($order['snack']);
			$money_spent_today += (intval($order['quantity']) * floatval($snack['price']));
		}
		return $money_spent_today;
	}

	function get_money_spent_today_by_uid($uid)
	{
		$orders = array();
		$orders = get_all_orders_today_by_uid($uid);

		$money_spent_today = 0.0;

		foreach ($orders as $order) {
			$snack = get_snack_by_id($order['snack']);
			$money_spent_today += (intval($order['quantity']) * floatval($snack['price']));
		}
		return $money_spent_today;
	}

	function get_money_spent_this_month()
	{
		$orders = array();
		$orders = get_all_orders_this_month();

		$money_spent_this_month = 0.0;

		foreach ($orders as $order) {
			$snack = get_snack_by_id($order['snack']);
			$money_spent_this_month += (intval($order['quantity']) * floatval($snack['price']));
		}

		return $money_spent_this_month;
	}

	function get_money_spent_this_month_by_uid($uid)
	{
		$orders = array();
		$orders = get_all_orders_this_month_by_uid($uid);
		$money_spent_this_month = 0.0;

		foreach ($orders as $order) {
			$snack = get_snack_by_id($order['snack']);
			$money_spent_this_month += (intval($order['quantity']) * floatval($snack['price']));
		}

		return $money_spent_this_month;
	}

	function get_people_today()
	{
		$link = open_database_connection();

		$query = "SELECT COUNT(DISTINCT(uid)) AS people FROM swipes WHERE DAY(timestamp) = DAY(NOW()) AND MONTH(timestamp) = MONTH(NOW()) AND YEAR(timestamp) = YEAR(NOW())";

		if ($result = mysqli_query($link, $query)) {
			$people = mysqli_fetch_assoc($result);

			// free result set
			mysqli_free_result($result);
		}

		// close connection
		mysqli_close($link);

		if($people['people'])
			return $people['people'];
		else
			return 0;
	}

	function datetime_to_string($datetime) {
		if(!isset($datetime))
			return _("Aucune date de fin");

		$today = date('Y-m-d');
		$yesterday = date('Y-m-d', strtotime('-1 day'));

		if(date('Y-m-d', strtotime($datetime)) == $today)
			return _("Aujourd'hui &agrave; ") . substr($datetime, -8, 5);
		elseif(date('Y-m-d', strtotime($datetime)) == $yesterday)
			return _("Hier &agrave; ") . substr($datetime, -8, 5);
		else {
			if(getenv('LANG') == 'fr_FR')
				return date('\L\e d/m/Y \&\a\g\r\a\v\e\; H:i', strtotime($datetime));
			else
				return $datetime;
		}
	}

	function date_to_string($date) {
		if(!isset($date))
			return _("Aucune date de fin");

		$today = date('Y-m-d');

		if(date('Y-m-d', strtotime($date)) == $today)
			return _("aujourd'hui");
		else {
			if(getenv('LANG') == 'fr_FR')
				return date('d/m/Y', strtotime($date));
			else
				return $date;
		}
	}

	/* Meeting Model */
	function get_all_meetings()
	{
		$link = open_database_connection();

		$query = "SELECT * FROM meetings ORDER BY start DESC";

		$meetings = array();
		if ($result = mysqli_query($link, $query)) {
			// fetch associative array
			while ($row = mysqli_fetch_assoc($result)) {
				$user = get_user_by_uid($row['uid']);
				$row['title'] = $user['firstname'] . ' ' . $user['lastname'];
				$row['color'] = ($row['status'] == "1" ? "#4a9b17" : "#c91111");
				$meetings[] = $row;
			}

			// free result set
			mysqli_free_result($result);
		}

		// close connection
		mysqli_close($link);

		return $meetings;
	}

	function get_meeting_by_id($id) {
		$link = open_database_connection();

		$query = "SELECT * FROM meetings WHERE id = '" . mysqli_real_escape_string($link, $id) . "' LIMIT 1";

		if ($result = mysqli_query($link, $query))
			$meeting = mysqli_fetch_assoc($result);

		// free result set
		mysqli_free_result($result);

		// close connection
		mysqli_close($link);

		return $meeting;
	}

	function add_meeting($uid, $start, $duration)
	{
		$link = open_database_connection();

		$timestamp = strtotime($start) + intval($duration) * 3600;
		$end = date('Y-m-d H:i:s', $timestamp);

		$query = "INSERT INTO meetings (id, start, end, uid, status) VALUES (NULL, '" .
					mysqli_real_escape_string($link, $start) . "', '" .
					mysqli_real_escape_string($link, $end) . "', '" .
					mysqli_real_escape_string($link, $uid) . "', 0)";

		$result = mysqli_query($link, $query);

		// free result set
		mysqli_free_result($result);

		// close connection
		mysqli_close($link);

		return $result;
	}

	function accept_meeting($id) {
		$link = open_database_connection();

		$query = "UPDATE meetings SET status = '1' WHERE id = '" . mysqli_real_escape_string($link, $id) . "' LIMIT 1";

		$result = mysqli_query($link, $query);

		// free result set
		mysqli_free_result($result);

		// close connection
		mysqli_close($link);

		return $result;
	}

	function send_meeting_accepted_mail($meeting) {
		$user = get_user_by_uid($meeting['uid']);
		$admin = get_admin_email();

		$receiver = $user['email'];
		$headers = "From: " . $admin;
		$subject = "Votre demande de réunion a été acceptée !";
		$message =	"Bonjour " . $user['firstname'] .",\nVotre demande pour la réunion du " . $meeting['start'] . " a été acceptée.\nBonne réunion !";

		$status = mail($receivers, $subject, $message, $headers);

		return $status;
	}

	/* Message Model */
	function get_all_messages()
	{
		$link = open_database_connection();

		$query = "SELECT * FROM messages ORDER BY timestamp DESC LIMIT 0,200";

		$messages = array();
		if ($result = mysqli_query($link, $query)) {
			// fetch associative array
			while ($row = mysqli_fetch_assoc($result)) {
				$user = get_user_by_uid($row['uid']);
				$row['firstname'] = $user['firstname'];
				$row['lastname'] = $user['lastname'];
				$messages[] = $row;
			}

			// free result set
			mysqli_free_result($result);
		}

		// close connection
		mysqli_close($link);

		return $messages;
	}

	function get_last_message()
	{
		$link = open_database_connection();

		$query = "SELECT * FROM messages ORDER BY timestamp DESC LIMIT 1";

		if ($result = mysqli_query($link, $query)) {
			// fetch associative array
			$message = mysqli_fetch_assoc($result);
			$user = get_user_by_uid($message['uid']);
			$message['firstname'] = $user['firstname'];
			$message['lastname'] = $user['lastname'];
			$message['published'] = datetime_to_string($message['timestamp']);
			unset($message['timestamp']);
			unset($message['id']);

			// free result set
			mysqli_free_result($result);
		}

		// close connection
		mysqli_close($link);

		return $message;
	}

	function add_message($uid, $message)
	{
		$link = open_database_connection();

		$user = get_user_by_uid($uid);

		if($user)
			$query = "INSERT INTO messages (id, uid, timestamp, message) VALUES ('', '" . mysqli_real_escape_string($link, $uid) . "', NOW(), '" . mysqli_real_escape_string($link, $message) . "')";

		$result = mysqli_query($link, $query);

		// free result set
		mysqli_free_result($result);

		// close connection
		mysqli_close($link);

		send_message_to_laboite($message);

		return $result;
	}

	function send_message_to_laboite($message) {
		/* Send a message to laboite */

		//set POST variables
		$url = 'http://api.laboite.cc/c859fd5a/message';
		$optional_headers = 'Content-Type: application/json';

		$params = array('http' => array(
										'method' => 'POST',
										'content' => json_encode(array('message' => $message)))
									 );

		if ($optional_headers !== null) {
				$params['http']['header'] = $optional_headers;
		}

		$ctx = stream_context_create($params);
		$fp = fopen($url, 'rb', false, $ctx);
	}

	/* Coworking Model */
	function get_coworking_history()
	{
		$link = open_database_connection();

		$query = "SELECT * FROM coworking ORDER BY timestamp DESC LIMIT 0,200";

		$coworkings = array();
		if ($result = mysqli_query($link, $query)) {
			// fetch associative array
			while ($row = mysqli_fetch_assoc($result)) {
				$user = get_user_by_uid($row['uid']);
				$row['firstname'] = $user['firstname'];
				$row['lastname'] = $user['lastname'];
				$coworkings[] = $row;
			}

			// free result set
			mysqli_free_result($result);
		}

		// close connection
		mysqli_close($link);

		return $coworkings;
	}

	function get_coworking_history_by_uid()
	{
		$link = open_database_connection();

		$query = "SELECT * FROM coworking ORDER BY timestamp DESC LIMIT 0,200";

		$coworkings = array();
		if ($result = mysqli_query($link, $query)) {
			// fetch associative array
			while ($row = mysqli_fetch_assoc($result)) {
				unset($row['uid']);
				$row['halfdays'] = intval($row['halfdays']);
				$coworkings[] = $row;
			}

			// free result set
			mysqli_free_result($result);
		}

		// close connection
		mysqli_close($link);

		return $coworkings;
	}

	function add_coworking($uid, $halfdays)
	{
		$halfdays = intval($halfdays);

		$link = open_database_connection();

		$query = "INSERT INTO coworking (uid, halfdays, timestamp) VALUES ('" . mysqli_real_escape_string($link, $uid) . "', '$halfdays', NOW())";

		$result = mysqli_query($link, $query);

		// free result set
		mysqli_free_result($result);

		// close connection
		mysqli_close($link);

		// credit user account
		credit_coworking_account($uid, $halfdays);
	}

	function add_coworking_with_swipe($uid, $halfdays, $swipe)
	{
		$halfdays = intval($halfdays);

		$link = open_database_connection();

		$query = "INSERT INTO coworking (uid, halfdays, timestamp, swipe) VALUES ('" . mysqli_real_escape_string($link, $uid) . "', '$halfdays', NOW(), '" . mysqli_real_escape_string($link, $swipe) . "')";

		$result = mysqli_query($link, $query);

		// free result set
		mysqli_free_result($result);

		// close connection
		mysqli_close($link);

		// credit user account
		credit_coworking_account($uid, $halfdays);
	}

	function credit_coworking_account($uid, $halfdays)
	{
		$user = get_user_by_uid($uid);
		$current_coworking_balance = floatval($user['coworking']);
		$new_coworking_balance = $current_coworking_balance + floatval($halfdays)/2;

		$new_coworking_balance = str_replace(',', '.', (string) $new_coworking_balance);

		$link = open_database_connection();

		$query = "UPDATE users SET coworking = '$new_coworking_balance' WHERE uid = '" . mysqli_real_escape_string($link, $uid) . "' LIMIT 1";

		$result = mysqli_query($link, $query);

		// free result set
		mysqli_free_result($result);

		// close connection
		mysqli_close($link);

		return $result;
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

	function get_all_payments_by_uid($uid)
	{
		$link = open_database_connection();

		$query = "SELECT * FROM payments WHERE uid = '" . mysqli_real_escape_string($link, $uid) . "' ORDER BY timestamp DESC";

		$payments = array();
		if ($result = mysqli_query($link, $query)) {
			// fetch associative array
			while ($row = mysqli_fetch_assoc($result)) {
				$payments[] = $row;
			}

			// free result set
			mysqli_free_result($result);
		}

		// close connection
		mysqli_close($link);

		return $payments;
	}

	function get_last_payment_by_uid($uid)
	{
		$link = open_database_connection();

		$query = "SELECT * FROM payments WHERE uid = '" . mysqli_real_escape_string($link, $uid) . "' ORDER BY timestamp DESC LIMIT 0,1";

		if ($result = mysqli_query($link, $query))
			$payment = mysqli_fetch_assoc($result);

		// free result set
		mysqli_free_result($result);

		// close connection
		mysqli_close($link);

		return $payment;
	}

	function add_payment($uid, $amount)
	{
		//TODO Store the IP client address, can be useful if you wanna blacklist hackers
		if(floatval($amount) > 0) {
			$link = open_database_connection();

			$amount = str_replace(',', '.', (string) floatval($amount));

			$query = "INSERT INTO payments (uid, amount, timestamp) VALUES ('" . mysqli_real_escape_string($link, $uid) . "', '$amount', NOW())";

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

	function add_payment_timestamped($uid, $amount, $timestamp)
	{
		//TODO Store the IP client address, can be useful if you wanna blacklist hackers
		if(floatval($amount) > 0) {
			$link = open_database_connection();

			$query = "INSERT INTO payments (uid, amount, timestamp) VALUES ('" . mysqli_real_escape_string($link, $uid) . "', '" . floatval($amount) . "', '" . mysqli_real_escape_string($link, $timestamp) . "')";

			$result = mysqli_query($link, $query);

			// free result set
			mysqli_free_result($result);

			// close connection
			mysqli_close($link);

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

		$new_balance = str_replace(',', '.', (string) $new_balance);

		$link = open_database_connection();

		$query = "UPDATE users SET balance = '$new_balance' WHERE uid = '" . mysqli_real_escape_string($link, $uid) . "' LIMIT 1";

		$result = mysqli_query($link, $query);

		// free result set
		mysqli_free_result($result);

		// close connection
		mysqli_close($link);

		return $result;
	}

	function debit_account($uid, $amount)
	{
		$user = get_user_by_uid($uid);
		$current_balance = floatval($user['balance']);
		$new_balance = $current_balance - floatval($amount);

		$new_balance = str_replace(',', '.', (string) $new_balance);

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

		$query = "SELECT * FROM snacks ORDER BY id DESC";

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

	function get_visible_snacks() {
		$link = open_database_connection();

		$query = "SELECT * FROM snacks WHERE visible = 1 ORDER BY id ASC";

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

	/* Equipment Model */
	function get_all_equipments() {
		$link = open_database_connection();

		$query = "SELECT * FROM equipments ORDER BY name ASC";

		$equipments = array();
		if ($result = mysqli_query($link, $query)) {
			// fetch associative array
			while ($row = mysqli_fetch_assoc($result))
				$equipments[] = $row;

			// free result set
			mysqli_free_result($result);
		}

		// close connection
		mysqli_close($link);

		return $equipments;
	}

	function get_user_equipments($uid) {
		$link = open_database_connection();

		$query = "SELECT * FROM equipments WHERE hirer = '" . mysqli_real_escape_string($link, $uid) . "'	ORDER BY name ASC";

		$equipments = array();
		if ($result = mysqli_query($link, $query)) {
			// fetch associative array
			while ($row = mysqli_fetch_assoc($result))
				$equipments[] = $row;

			// free result set
			mysqli_free_result($result);
		}

		// close connection
		mysqli_close($link);

		return $equipments;
	}

	function add_equipment($uid, $name, $description, $hirer, $end)
	{
			$link = open_database_connection();

			$query = "INSERT INTO equipments (id, uid, name, description, hirer, start, end) VALUES (NULL, '" . mysqli_real_escape_string($link, $uid) . "', '" . mysqli_real_escape_string($link, $name) . "', '" . mysqli_real_escape_string($link, $description) . "', '" . mysqli_real_escape_string($link, $hirer) . "', NOW(), '" . mysqli_real_escape_string($link, $end) . "')";

		$result = mysqli_query($link, $query);

		// free result set
		mysqli_free_result($result);

		// close connection
		mysqli_close($link);

		return $result;
	}

	function get_equipment_by_id($id) {
			$link = open_database_connection();

		$query = "SELECT * FROM equipments WHERE id = '" . mysqli_real_escape_string($link, $id) . "' LIMIT 1";

		if ($result = mysqli_query($link, $query))
			$equipment = mysqli_fetch_assoc($result);

		// free result set
		mysqli_free_result($result);

		// close connection
		mysqli_close($link);

		return $equipment;
	}

	function delete_equipment($id)
	{
		$link = open_database_connection();

		$query = "DELETE FROM equipments WHERE id = '" . mysqli_real_escape_string($link, $id) . "' LIMIT 1";

		$result = mysqli_query($link, $query);

		// free result set
		mysqli_free_result($result);

		// close connection
		mysqli_close($link);

		return $result;
	}

	function update_equipment($id, $uid, $name, $description, $hirer, $end)
	{
		$link = open_database_connection();

		$query = "UPDATE equipments SET uid = '" . mysqli_real_escape_string($link, $uid) . "', name = '" . mysqli_real_escape_string($link, $name) . "', description = '" . mysqli_real_escape_string($link, $description) . "', hirer = '" . mysqli_real_escape_string($link, $hirer) . "', start = NOW(), end = '" . mysqli_real_escape_string($link, $end) . "' WHERE id = '" . mysqli_real_escape_string($link, $id) . "' LIMIT 1";

		$result = mysqli_query($link, $query);

		// free result set
		mysqli_free_result($result);

		// close connection
		mysqli_close($link);

		return $result;
	}

	function set_equipment_available($id)
	{
		$link = open_database_connection();

		$query = "UPDATE equipments SET hirer = NULL, start = NULL, end = NULL WHERE id = '" . mysqli_real_escape_string($link, $id) . "' LIMIT 1";

		$result = mysqli_query($link, $query);

		// free result set
		mysqli_free_result($result);

		// close connection
		mysqli_close($link);

		return $result;
	}

	/* 3D printing jobs Model */
	function get_all_jobs() {
		$link = open_database_connection();

		$query = "SELECT * FROM jobs ORDER BY id DESC";

		$jobs = array();
		if ($result = mysqli_query($link, $query)) {
			while ($row = mysqli_fetch_assoc($result))
				$jobs[] = $row;

			// free result set
			mysqli_free_result($result);
		}

		// close connection
		mysqli_close($link);

		return $jobs;
	}

	function get_last_jobs() {
		$link = open_database_connection();

		$query = "SELECT * FROM jobs ORDER BY delivery DESC LIMIT 3";

		$jobs = array();
		if ($result = mysqli_query($link, $query)) {
			while ($row = mysqli_fetch_assoc($result)) {
				$user = get_user_by_uid($row['uid']);
				$row['firstname'] = $user['firstname'];
				$jobs[] = $row;
			}

			// free result set
			mysqli_free_result($result);
		}

		// close connection
		mysqli_close($link);

		return $jobs;
	}


	function get_job_by_id($id) {
		$link = open_database_connection();

		$query = "SELECT * FROM jobs WHERE id = '" . mysqli_real_escape_string($link, $id) . "' LIMIT 1";

		if ($result = mysqli_query($link, $query))
			$job = mysqli_fetch_assoc($result);

		// free result set
		mysqli_free_result($result);

		// close connection
		mysqli_close($link);

		return $job;
	}

	function get_jobs_by_uid($uid) {
		$link = open_database_connection();

		$query = "SELECT * FROM jobs WHERE uid = '" . mysqli_real_escape_string($link, $uid) . "'";

		$jobs = array();
		if ($result = mysqli_query($link, $query)) {
			while ($row = mysqli_fetch_assoc($result))
				$jobs[] = $row;

			// free result set
			mysqli_free_result($result);
		}

		// close connection
		mysqli_close($link);

		return $jobs;
	}

	function add_job($uid, $timestamp, $file, $duration, $filament, $delivery, $price) {
		$link = open_database_connection();

		$query = "INSERT INTO jobs (id, uid, timestamp, file, duration, filament, delivery, status, price) VALUES (NULL, '" . mysqli_real_escape_string($link, $uid) . "',	NOW(), '" . mysqli_real_escape_string($link, $file) . "', '" . mysqli_real_escape_string($link, $duration) . "', '" . mysqli_real_escape_string($link, $filament) . "', '" . mysqli_real_escape_string($link, $delivery) . "', '0', '" . mysqli_real_escape_string($link, $price) . "')";

		$result = mysqli_query($link, $query);

		// free result set
		mysqli_free_result($result);

		// close connection
		mysqli_close($link);

		return $result;
 }

	function update_job($id, $delivery, $price)	{
		$link = open_database_connection();

		$query = "UPDATE jobs SET delivery = '" . mysqli_real_escape_string($link, $delivery) . "',
															status = '1',
															price = '" . mysqli_real_escape_string($link, $price) . "' WHERE id = '" . mysqli_real_escape_string($link, $id) . "'";

		$result = mysqli_query($link, $query);

		// free result set
		mysqli_free_result($result);

		// close connection
		mysqli_close($link);

		return $result;
	}

	function delete_job($id)
	{
		$link = open_database_connection();

		$query = "DELETE FROM jobs WHERE id = '" . mysqli_real_escape_string($link, $id) . "' LIMIT 1";

		$result = mysqli_query($link, $query);

		// free result set
		mysqli_free_result($result);

		// close connection
		mysqli_close($link);

		return $result;
	}

	function add_swipe_to_job($id, $swipe) {
		$link = open_database_connection();

		$query = "UPDATE jobs SET swipe = '" . mysqli_real_escape_string($link, $swipe) . "' WHERE id = '" . mysqli_real_escape_string($link, $id) . "'";

		$result = mysqli_query($link, $query);

		// free result set
		mysqli_free_result($result);

		// close connection
		mysqli_close($link);

		return $result;
	}

	function checkout_job($uid, $job)
	{
		$user = get_user_by_uid($uid);

		if($user && $job['price'] > 0) {
			$swipe = add_swipe(0, $user['uid'], 4, 1);
			add_swipe_to_job($job['id'], $swipe);
			debit_account($user['uid'], $job['price']);

			$link = open_database_connection();

			$query = "UPDATE jobs SET status = '2' WHERE id = '" . mysqli_real_escape_string($link, $job['id']) . "'";

			$result = mysqli_query($link, $query);

			// free result set
			mysqli_free_result($result);

			// close connection
			mysqli_close($link);

			return $result;
		}
	}

	/* Item Model */
	function get_all_items() {
		$link = open_database_connection();

		$query = "SELECT * FROM items ORDER BY name ASC ";

		$items = array();
		if ($result = mysqli_query($link, $query)) {
			// fetch associative array
			while ($row = mysqli_fetch_assoc($result))
				$items[] = $row;

			// free result set
			mysqli_free_result($result);
		}

		// close connection
		mysqli_close($link);

		return $items;
	}

	function get_item_by_id($id) {
		$link = open_database_connection();

		$query = "SELECT * FROM items WHERE id = '" . mysqli_real_escape_string($link, $id) . "' LIMIT 1";

		if ($result = mysqli_query($link, $query))
			$item = mysqli_fetch_assoc($result);

		// free result set
		mysqli_free_result($result);

		// close connection
		mysqli_close($link);

		return $item;
	}

	function add_item($name, $unit, $alert_on) {
		$link = open_database_connection();

		$query = "INSERT INTO items (id, name, unit, alert_on) VALUES (
									NULL,
									'" . mysqli_real_escape_string($link, $name) . "',
									'" . mysqli_real_escape_string($link, $unit) . "',
									'" . mysqli_real_escape_string($link, $alert_on) . "'
								 )";
		$result = mysqli_query($link, $query);

		// free result set
		mysqli_free_result($result);

		// close connection
		mysqli_close($link);

		return $result;
	}

	function get_all_checkouts() {
		$link = open_database_connection();

		$query = "SELECT * FROM checkouts ORDER BY timestamp DESC";

		$checkouts = array();
		if ($result = mysqli_query($link, $query)) {
			// fetch associative array
			while ($row = mysqli_fetch_assoc($result))
				$checkouts[] = $row;

			// free result set
			mysqli_free_result($result);
		}

		// close connection
		mysqli_close($link);

		return $checkouts;
	}

	function add_checkout($checkin, $item, $customer, $quantity) {
		$link = open_database_connection();

		$query = "INSERT INTO checkouts (id, `checkin?`, `timestamp`, item, customer, quantity) VALUES (
									NULL,
									'" . mysqli_real_escape_string($link, $checkin) . "',
									NOW(), '" . mysqli_real_escape_string($link, $item) . "',
									'" . mysqli_real_escape_string($link, $customer) . "',
									'" . mysqli_real_escape_string($link, $quantity) . "'
								 )";
		$result = mysqli_query($link, $query);

		// free result set
		mysqli_free_result($result);

		// close connection
		mysqli_close($link);

		if(intval($checkin) == 0) {
			$item = get_item_by_id($item);
			$item['stock'] = get_stocks_by_id($item['id']);
			if($item['stock'] < $item['alert_on'])
				send_alert_email($item);
		}


		return $result;
	}

	function delete_checkout($id)
	{
		$link = open_database_connection();

		$query = "DELETE FROM checkouts WHERE id = '" . mysqli_real_escape_string($link, $id) . "' LIMIT 1";

		$result = mysqli_query($link, $query);

		// free result set
		mysqli_free_result($result);

		// close connection
		mysqli_close($link);

		return $result;
	}

	function get_all_stocks() {
		$link = open_database_connection();

		$query = "SELECT * FROM items ORDER BY name ASC ";

		$items = array();
		if ($result = mysqli_query($link, $query)) {
			// fetch associative array
			while ($row = mysqli_fetch_assoc($result)) {
				$row['stocks'] = get_stocks_by_id($row['id']);
				$items[] = $row;
			}

			// free result set
			mysqli_free_result($result);
		}

		// close connection
		mysqli_close($link);

		return $items;
	}

	function get_stocks_by_id($id) {
		$link = open_database_connection();

		$query = "SELECT SUM(quantity) AS checkins FROM checkouts WHERE `checkin?` = 1 AND item = '" . mysqli_real_escape_string($link, $id) . "'";
		$checkins = 0;

		if ($result = mysqli_query($link, $query))
			$checkins = mysqli_fetch_assoc($result);

		// free result set
		mysqli_free_result($result);

		$query = "SELECT SUM(quantity) AS checkouts FROM checkouts WHERE `checkin?` = 0 AND item = '" . mysqli_real_escape_string($link, $id) . "'";
		$checkouts = 0;

		if ($result = mysqli_query($link, $query))
			$checkouts = mysqli_fetch_assoc($result);

		// free result set
		mysqli_free_result($result);

		// close connection
		mysqli_close($link);

		return (intval($checkins['checkins']) - intval($checkouts['checkouts']));
	}

	/* Customer Model */
	function get_all_customers() {
		$link = open_database_connection();

		$query = "SELECT * FROM customers ORDER BY name ASC ";

		$customers = array();
		if ($result = mysqli_query($link, $query)) {
			// fetch associative array
			while ($row = mysqli_fetch_assoc($result))
				$customers[] = $row;

			// free result set
			mysqli_free_result($result);
		}

		// close connection
		mysqli_close($link);

		return $customers;
	}

	function add_customer($name) {
		$link = open_database_connection();

		$query = "INSERT INTO customers (id, name) VALUES (
									NULL,
									'" . mysqli_real_escape_string($link, $name) . "'
								 )";
		$result = mysqli_query($link, $query);

		// free result set
		mysqli_free_result($result);

		// close connection
		mysqli_close($link);

		return $result;
	}

	function send_alert_email($item)
	{
		$receiver = "b.gaultier@gmail.com";
		$headers = "From: kfet@laclef.cc";
		$subject = 'Alerte : stock "' . $item['name'] . '" bas !';
		$message = "Bonjour Sandra,\n\nLe stock pour : \"" . $item['name'] . "\" est de  " .
				   $item['stock'] . " " . $item['unit'];
		if (intval($item['stock']) > 1) $message .= 's';
		$message .= " !\n\nBonne journée :)";

		return mail($receiver, $subject, $message, $headers);
	}

	function get_customer_by_id($id) {
		$link = open_database_connection();

		$query = "SELECT * FROM customers WHERE id = '" . mysqli_real_escape_string($link, $id) . "' LIMIT 1";

		if ($result = mysqli_query($link, $query))
			$customer = mysqli_fetch_assoc($result);

		// free result set
		mysqli_free_result($result);

		// close connection
		mysqli_close($link);

		return $customer;
	}

	/* Event Model */
	function get_all_events() {
		$link = open_database_connection();

		$query = "SELECT * FROM events ORDER BY date DESC";

		$events = array();
		if ($result = mysqli_query($link, $query)) {
			// fetch associative array
			while ($row = mysqli_fetch_assoc($result)) {
				$row['registrations'] = get_registrations_by_event($row['id']);
				$events[] = $row;
			}

			// free result set
			mysqli_free_result($result);
		}

		// close connection
		mysqli_close($link);

		return $events;
	}

	function get_registrations_by_event($id) {
		$link = open_database_connection();

		$query = "SELECT * FROM attendees WHERE event = '" . mysqli_real_escape_string($link, $id) . "'";
		if ($result = mysqli_query($link, $query)) {
			// fetch associative array
			while ($row = mysqli_fetch_assoc($result)) {
				$user = get_user_by_uid($row['uid']);
				$row['firstname'] = $user['firstname'];
				$row['lastname'] = $user['lastname'];
				$registrations[] = $row;
			}

			// free result set
			mysqli_free_result($result);
		}

		// close connection
		mysqli_close($link);

		return $registrations;
	}

	function get_event_by_id($id) {
		$link = open_database_connection();

		$query = "SELECT * FROM events WHERE id = '" . mysqli_real_escape_string($link, $id) . "' LIMIT 1";

		if ($result = mysqli_query($link, $query))
			$event = mysqli_fetch_assoc($result);

		// free result set
		mysqli_free_result($result);

		// close connection
		mysqli_close($link);

		if($event)
			$event['registrations'] = get_registrations_by_event($event['id']);

		return $event;
	}

	function add_event($title, $description, $date, $max, $registrationfee)
	{
			$link = open_database_connection();

			$query = "INSERT INTO events (id, title, description, date, max, registrationfee) VALUES (
								NULL,
								'" . mysqli_real_escape_string($link, $title) . "',
								'" . mysqli_real_escape_string($link, $description) . "',
								'" . mysqli_real_escape_string($link, $date) . "',
								'" . mysqli_real_escape_string($link, $max) . "',
								'" . mysqli_real_escape_string($link, $registrationfee) . "'
							 )";

		$result = mysqli_query($link, $query);

		// free result set
		mysqli_free_result($result);

		// close connection
		mysqli_close($link);

		return $result;
	}

	function delete_event($id)
	{
		$link = open_database_connection();

		$query = "DELETE FROM events WHERE id = '" . mysqli_real_escape_string($link, $id) . "' LIMIT 1";

		$result = mysqli_query($link, $query);

		// free result set
		mysqli_free_result($result);

		// close connection
		mysqli_close($link);

		return $result;
	}

	function update_event($id, $title, $description, $date, $max, $registrationfee)
	{
		$link = open_database_connection();

		$query = "UPDATE events SET
							title = '" . mysqli_real_escape_string($link, $title) . "',
							description = '" . mysqli_real_escape_string($link, $description) . "',
							date = '" . mysqli_real_escape_string($link, $date) . "',
							max = '" . mysqli_real_escape_string($link, $max) . "',
							registrationfee = '" . mysqli_real_escape_string($link, $registrationfee) . "'

							WHERE id = '" . mysqli_real_escape_string($link, $id) . "' LIMIT 1";

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

	function get_ldap_users()
	{
		//TODO get the fucking LDAP server working first
		$users = get_all_users();
		return $users;
	}

	function get_current_bitcoin_value()
	{
		$url = 'https://api.coindesk.com/v1/bpi/currentprice/EUR.json';
		$json_string = file_get_contents($url);

		$parsed_json = json_decode($json_string);

		return $parsed_json->{'bpi'}->{'EUR'}->{'rate_float'};
	}

	function get_google_calendar_events()
	{
		require_once 'icalreader.php';

		$ical   = new ICal('basic.ics');
		$rangeStart = new DateTime();
		$rangeStart->setTimestamp(strtotime("first day of last month"));

		$events = $ical->eventsFromRange(date_format($rangeStart, 'Y-m-d'));
		$events = $ical->sortEventsWithOrder($events, SORT_DESC);

		return $events;
	}

	function get_current_helpdesk_operator()
	{
		if (date('H') > 7 && date('H') < 18) {
			require_once 'icalreader.php';

			$ical   = new ICal('helpdesk.ics');
			$rangeStart = new DateTime();

			$rangeStart = new DateTime();
			$rangeStart->setTimestamp(strtotime('today'));

			$rangeEnd = new DateTime;

			$events = $ical->eventsFromRange(date_format($rangeStart, 'Y-m-d'), date_format($rangeEnd, 'Y-m-d H:i'));
			$events = $ical->sortEventsWithOrder($events, SORT_DESC);

			if(isset($events[0])) {
				$last_event = $events[0];
				$current_helpdesk_operator = ucwords(str_replace('.', " ", str_replace('@telecom-bretagne.eu', "", str_replace('mailto:', "", $last_event ["ORGANIZER_array"][0] ["SENT-BY"]))));
				return $current_helpdesk_operator;
			}
			return NULL;
		}
		else return NULL;
	}

	function iCalDateToUnixTimestamp($icalDate)
	{
		$icalDate = str_replace('T', '', $icalDate);
		$icalDate = str_replace('Z', '', $icalDate);

		$pattern  = '/([0-9]{4})';   // 1: YYYY
		$pattern .= '([0-9]{2})';    // 2: MM
		$pattern .= '([0-9]{2})';    // 3: DD
		$pattern .= '([0-9]{0,2})';  // 4: HH
		$pattern .= '([0-9]{0,2})';  // 5: MM
		$pattern .= '([0-9]{0,2})/'; // 6: SS
		preg_match($pattern, $icalDate, $date);

		// Unix timestamp can't represent dates before 1970
		if ($date[1] <= 1970) {
			return false;
		}
		// Unix timestamps after 03:14:07 UTC 2038-01-19 might cause an overflow
		// if 32 bit integers are used.
		$timestamp = mktime((int)$date[4], (int)$date[5], (int)$date[6], (int)$date[2], (int)$date[3], (int)$date[1]);
		return $timestamp;
	}
?>
