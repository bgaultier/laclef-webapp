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
			// dealing with transfers
			if(intval($_POST['transfers']) > 0)
				new_transfer($_POST['recipient'], $_POST['transfers'], $_POST);
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
				$client['jobs'] = get_jobs_by_uid($client['uid']);
				$bitcoin = get_current_bitcoin_value();
			}
			else {
				$messages = get_all_messages();
				$events = get_google_calendar_events();
				$first_coffee = get_first_coffee();
				$jobs = get_last_jobs();
				$helpdesk_operator = get_current_helpdesk_operator();
			}

			// get all the users
			$users = get_all_users_sorted_by_balance_descending();

			require 'templates/dashboard.php';
	}

	function meetings_json_action() {
		header('Content-type: application/json; charset=utf-8');
		header("Cache-Control: no-cache, must-revalidate");

		$meetings = get_all_meetings();

		echo json_encode($meetings);
	}

	function meetings_action($session_uid) {
		// needed to set the tab active
		$meetings_active = true;

		//check if the user is admin
		if(user_is_admin($session_uid)) {
			// get all the events
			$meetings = get_all_meetings();

			require 'templates/meetings.php';
		}
		else
			require 'templates/login.php';
	}

	function accept_meeting_action($id) {
		// needed to set the tab active
		$meetings_active = true;

		$meeting = get_meeting_by_id($_GET['id']);

		if($meeting) {
			accept_meeting($meeting['id'], 1);
			$message_active = true;
			send_meeting_accepted_mail($meeting);
		}

		// get all the events
		$meetings = get_all_meetings();

		require 'templates/meetings.php';
	}

	function grid_action() {
		// needed to hide the menu
		$dashboard_active = true;

		$messages = get_all_messages();

		require 'templates/grid.php';
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
		$order['snack_10'] = 1;
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

				// get all the users
				$users = get_all_users_sorted_by_lastname_ascending();

				require 'templates/payments.php';
			}
		else
			require 'templates/login.php';
	}

	function coworking_action($uid) {
		// needed to set the tab active
		$extras_active = true;
		$coworking_active = true;

		if(user_is_admin($uid)) {
			// dealing with coworking add form
			if(isset($_POST['uid']) && isset($_POST['halfdays'])) {
				if(isset($_POST['debit']))
					add_coworking($_POST['uid'], -$_POST['halfdays']);
				else
					add_coworking($_POST['uid'], $_POST['halfdays']);
				// log swipe
				add_swipe(0, $_POST['uid'], 5, 1);
			}
			// list all the coworkings
			$coworkings = get_coworking_history();

			// get all the users
			$users = get_all_users_sorted_by_balance_descending();

			require 'templates/coworking.php';
		}
		else
			require 'templates/login.php';
	}

	function booking_action() {
		// needed to set the tab active
		$extras_active = true;

		// dealing with coworking add form
		if(isset($_POST['uid']) && isset($_POST['start']) && isset($_POST['duration'])) {
			add_meeting($_POST['uid'], $_POST['start'], $_POST['duration'], 0);
			$booking_message = true;
		}

		// get all the users
		$users = get_all_users_sorted_by_balance_descending();

		require 'templates/booking.php';

	function paypal_action() {
		send_paypal_email($_POST['email'], $_POST['amount']);
		// Redirect browser
		header("Location: http://" . $_SERVER['SERVER_NAME'] . "/dashboard");
		// Make sure that code below does not get executed when we redirect
		exit;
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

	function list_jobs_action($uid) {
		// needed to set the tab active
		$extras_active = true;
		$jobs_active = true;

		if(user_is_admin($uid)) {
			if(isset($_POST['price'])) {
				$job_added = get_job_by_id($_POST['id']);
				// job exists
				if($job_added)
					update_job($_POST['id'], $_POST['delivery'], $_POST['price']);
				else
					add_job($_POST['uid'], $_POST['timestamp'], $_POST['file'], $_POST['duration'], $_POST['filament'], $_POST['delivery'], $_POST['price']);
			}
			// get all the users
			$users = get_all_users_sorted_by_lastname_ascending();

			// get all the printig jobs
			$jobs = get_all_jobs();
			require 'templates/jobs.php';
		}
		else
			require 'templates/login.php';
	}

	function delete_job_action($session_uid, $id) {
		//check if the user is admin
		if(user_is_admin($session_uid)) {
			delete_job($id);
			// Redirect browser
			header("Location: http://" . $_SERVER['SERVER_NAME'] . "/jobs");
			// Make sure that code below does not get executed when we redirect
			exit;
		}
		else
			require 'templates/login.php';
	}

	function modify_job_action($session_uid, $id) {
		// needed to set the tab active
		$extras_active = true;
		$jobs_active = true;

		//check if the user is admin
		if(user_is_admin($session_uid)) {
			$job = get_job_by_id($id);

			require 'templates/job.php';
		}
		else
			require 'templates/login.php';
	}

	function checkout_job_action($session_uid, $id) {
		// needed to set the tab active
		$extras_active = true;
		$jobs_active = true;

		//check if the user is admin
		if(user_is_admin($session_uid)) {
			$job = get_job_by_id($id);

			checkout_job($job['uid'], $job);

			// Redirect browser
			header("Location: http://" . $_SERVER['SERVER_NAME'] . "/jobs");
			// Make sure that code below does not get executed when we redirect
			exit;
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

	function grid_json_action() {
		header('Content-type: application/json; charset=utf-8');
		header("Cache-Control: no-cache, must-revalidate");

		$coffees_today = get_coffees_today();
		$money_today = get_money_spent_today();
		$filename = "laboite.json";
		if (!file_exists($filename) || (time() - filemtime($filename)) > 60 ) {
			copy("http://api.laboite.cc/c859fd5a.json", $filename);
		}

		$json_string = file_get_contents($filename);

		$parsed_json = json_decode($json_string);
		$bus = $parsed_json->{'bus'};
		$bikes = $parsed_json->{'bikes'};
		$temperature = $parsed_json->{'weather'}->{'today'}->{'temperature'};
		$icon = $parsed_json->{'weather'}->{'today'}->{'icon'};
		$message = get_last_message();
		$people = get_people_today();

		$json = array("coffees" => $coffees_today,
									"money" => $money_today,
									"message" => $message,
									"bus" => $bus,
									"bikes" => $bikes,
									"people" => $people,
									"icon" => $icon,
									"temperature" => $temperature
								 );

		echo json_encode($json);
	}

	function energy_json_action($power_feedid²energy_feedid) {
			header('Content-type: application/json; charset=utf-8');
		header("Cache-Control: no-cache, must-revalidate");

			$filename = "power_feed.json";
		if (!file_exists($filename) || (time() - filemtime($filename)) > 20 ) {
			copy("http://smartb.labo4g.enstb.fr/feed/get.json?id=$power_feedid", $filename);
		}

		$json_string = file_get_contents($filename);
		$parsed_json = json_decode($json_string);
		$power = $parsed_json->{'value'};


		$filename = "energy_feed.json";
		if (!file_exists($filename) || (time() - filemtime($filename)) > 20 ) {
			copy("http://smartb.labo4g.enstb.fr/feed/get.json?id=$energy_feedid", $filename);
		}

		$json_string = file_get_contents($filename);
		$parsed_json = json_decode($json_string);
		$energy = $parsed_json->{'value'};

		$json = array("power" => $power,
									"energy" => $energy
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

	function checkin_action() {
		// needed to set the tab active
		$stocks_active = true;

		$items = get_all_items();

		require 'templates/checkin.php';
	}

	function checkout_action() {
		// needed to set the tab active
		$stocks_active = true;

		$items = get_all_items();
		$customers = get_all_customers();

		require 'templates/checkout.php';
	}

	function delete_checkout_action($id) {
		//check if the user is admin
		delete_checkout($id);

		// Redirect browser
		header("Location: http://" . $_SERVER['SERVER_NAME'] . "/stocks");
		// Make sure that code below does not get executed when we redirect
		exit;
	}

	function list_stocks_action($uid) {
		// needed to set the tab active
		$stocks_active = true;

		// dealing with itemForm
		if(isset($_POST['unit']))
			add_item($_POST['name'], $_POST['unit'], $_POST['alert_on']);

		// dealing with checkoutForm
		if(isset($_POST['quantity']))
			add_checkout($_POST['checkin'], $_POST['item'], $_POST['customer'], $_POST['quantity']);

		// dealing with checkoutForm
		if(isset($_POST['customer_name']))
			add_customer($_POST['customer_name']);

		$items = get_all_stocks();

		$checkouts = get_all_checkouts();
		require 'templates/stocks.php';
	}

	function events_json_action() {
		header('Content-type: application/json; charset=utf-8');
		header("Cache-Control: no-cache, must-revalidate");

		$events = get_google_calendar_events();

		echo json_encode($events);
	}

	function coffees_tsv_action($months) {
		header('Content-type: text/tab-separated-values; charset=utf-8');
		header("Cache-Control: no-cache, must-revalidate");

		$tsv = array();

		for ($i = $months; $i >= 0; $i--)
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

	function list_events_action($uid) {
		// needed to set the tab active
		$extras_active = true;
		$events_active = true;

		if(user_is_admin($uid)) {
			// dealing with event add form
			if(isset($_POST['description']) && isset($_POST['title'])) {

				$event_added = get_event_by_id($_POST['id']);

				// event exists
				if($event_added)
					update_event($_POST['id'], $_POST['title'], $_POST['description'], $_POST['date'], $_POST['max'], $_POST['registrationfee']);
				else
					add_event($_POST['title'], $_POST['description'], $_POST['date'], $_POST['max'], $_POST['registrationfee']);
			}
			// get all the events
			$events = get_all_events();
			$uids = get_all_uids();

			require 'templates/events.php';
		}
		else
			require 'templates/login.php';
	}

	function modify_event_action($session_uid, $id) {
		// needed to set the tab active
		$extras_active = true;
		$events_active = true;

		//check if the user is admin
		if(user_is_admin($session_uid)) {
			$event = get_event_by_id($id);
			// get all users uids
			$uids = get_all_uids();

			require 'templates/event.php';
		}
		else
			require 'templates/login.php';
	}

	function kfet_action() {
			// needed to hide the menu
		$dashboard_active = true;

		require 'templates/kfet.php';
	}

?>
