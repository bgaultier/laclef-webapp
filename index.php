<?php
	/*
		laclef-webapp v0.2 is a PHP+MySQL web application that allows the
		management of users, devices, door locks, payments, RFID tags
		and readers.

		Copyright (C) 2013	Baptiste Gaultier

		This program is free software: you can redistribute it and/or modify
		it under the terms of the GNU Affero General Public License as
		published by the Free Software Foundation, either version 3 of the
		License, or (at your option) any later version.

		This program is distributed in the hope that it will be useful,
		but WITHOUT ANY WARRANTY; without even the implied warranty of
		MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.	See the
		GNU Affero General Public License for more details.

		You should have received a copy of the GNU Affero General Public License
		along with this program.	If not, see <http://www.gnu.org/licenses/>.
	*/

	// start new or resume existing session
	session_start();

	// load and initialize any global libraries
	require_once 'models.php';
	require_once 'controllers.php';

	// internationalization
	if(isset($_SESSION['locale']))
		$language = $_SESSION['locale'];
	else {
		$language = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
		if($language == "fr")
			$language = "fr_FR";
		else
			$language = "en_US";
	}
	putenv("LANG=$language");
	setlocale(LC_ALL, $language);
	$domain = 'messages';
	bindtextdomain($domain, "./templates/locale");
	textdomain($domain);

	// route the request internally
	$uri = $_SERVER['REQUEST_URI'];

	if ('/' == $uri)
		home_action();
	elseif ('/login' == $uri)
		login_action();
	elseif ('/logout' == $uri)
		logout_action();
	elseif ('/signup' == $uri)
		signup_action();
	elseif ('/account' == $uri && isset($_SESSION['uid']))
		account_action($_SESSION['uid']);
	elseif ('/useradded' == $uri && isset($_SESSION['uid']))
		list_users_action($_SESSION['uid']);
	elseif ('/users' == substr($uri, 0, 6) && isset($_SESSION['uid']))
		list_users_action($_SESSION['uid']);
	elseif ('/user/delete' == substr($uri, 0, 12) && isset($_GET['uid']))
			delete_user_action($_SESSION['uid'], $_GET['uid']);
	elseif ('/user' == substr($uri, 0, 5) && isset($_GET['uid']))
			modify_user_action($_SESSION['uid'], $_GET['uid']);
	elseif ('/tags' == $uri && isset($_SESSION['uid']))
		list_tags_action($_SESSION['uid']);
	elseif ('/tag/delete' == substr($uri, 0, 11) && isset($_GET['uid']))
			delete_tag_action($_SESSION['uid'], $_GET['uid']);
	elseif ('/tag' == substr($uri, 0, 4) && isset($_GET['uid']))
			modify_tag_action($_SESSION['uid'], $_GET['uid']);
	elseif ('/readers' == $uri && isset($_SESSION['uid']))
		list_readers_action($_SESSION['uid']);
	elseif ('/reader/delete' == substr($uri, 0, 14) && isset($_GET['id']))
			delete_reader_action($_SESSION['uid'], $_GET['id']);
	elseif ('/reader/all' == substr($uri, 0, 11) && isset($_GET['id']))
		add_all_user_to_a_reader_action($_SESSION['uid'], $_GET['id']);
	elseif ('/reader' == substr($uri, 0, 7) && isset($_GET['id']))
			modify_reader_action($_SESSION['uid'], $_GET['id']);
	elseif ('/permission/delete' == substr($uri, 0, 18) && isset($_GET['uid']) && isset($_GET['id']))
			delete_permission_action($_SESSION['uid'], $_GET['uid'], $_GET['id']);
	elseif ('/permission' == substr($uri, 0, 11) && isset($_GET['uid']) && isset($_GET['id']))
		modify_permission_action($_SESSION['uid'], $_GET['uid'], $_GET['id']);
	elseif ('/payments' == $uri && isset($_SESSION['uid']))
		list_payments_action($_SESSION['uid']);
	elseif ('/paypal' == $uri)
		paypal_action();
	elseif ('/swipes' == $uri && isset($_SESSION['uid']))
		list_swipes_action($_SESSION['uid']);
	elseif ('/orders' == $uri && isset($_SESSION['uid']))
		list_orders_action($_SESSION['uid']);
	elseif ('/snack/delete' == substr($uri, 0, 13) && isset($_GET['id']))
			delete_snack_action($_SESSION['uid'], $_GET['id']);
	elseif ('/snack' == substr($uri, 0, 6) && isset($_GET['id']))
		modify_snack_action($_SESSION['uid'], $_GET['id']);
	elseif ('/snacks' == $uri && isset($_SESSION['uid']))
		list_snacks_action($_SESSION['uid']);
	elseif ('/job/checkout' == substr($uri, 0, 13) && isset($_GET['id']))
		checkout_job_action($_SESSION['uid'], $_GET['id']);
	elseif ('/job/delete' == substr($uri, 0, 11) && isset($_GET['id']))
		delete_job_action($_SESSION['uid'], $_GET['id']);
	elseif ('/job' == substr($uri, 0, 4) && isset($_GET['id']))
		modify_job_action($_SESSION['uid'], $_GET['id']);
	elseif ('/jobs' == $uri && isset($_SESSION['uid']))
		list_jobs_action($_SESSION['uid']);
	elseif ('/equipments/available' == substr($uri, 0, 21) && isset($_GET['id']))
		equipment_available_action($_SESSION['uid'], $_GET['id']);
	elseif ('/equipment/delete' == substr($uri, 0, 17) && isset($_GET['id']))
		delete_equipment_action($_SESSION['uid'], $_GET['id']);
	elseif ('/equipment' == substr($uri, 0, 10) && isset($_GET['id']))
		modify_equipment_action($_SESSION['uid'], $_GET['id']);
	elseif ('/equipments' == $uri && isset($_SESSION['uid']))
		list_equipments_action($_SESSION['uid']);
	elseif ('/event/delete' == substr($uri, 0, 13) && isset($_GET['id']))
		delete_event_action($_SESSION['uid'], $_GET['id']);
	elseif ('/event' == substr($uri, 0, 6) && isset($_GET['id']))
		modify_event_action($_SESSION['uid'], $_GET['id']);
	elseif ('/events' == $uri && isset($_SESSION['uid']))
		list_events_action($_SESSION['uid']);
	elseif ('/checkin' == $uri)
		checkin_action();
	elseif ('/checkout/delete' == substr($uri, 0, 16) && isset($_GET['id']))
		delete_checkout_action($_GET['id']);
	elseif ('/checkout' == $uri)
		checkout_action();
	elseif ('/stocks' == $uri)
		list_stocks_action();
	elseif ('/tag/delete' == substr($uri, 0, 11) && isset($_GET['uid']))
		delete_tag_action($_SESSION['uid'], $_GET['uid']);
	elseif ('/tag' == substr($uri, 0, 4) && isset($_GET['uid']))
		modify_tag_action($_SESSION['uid'], $_GET['uid']);
	elseif ('/coffee' == substr($uri, 0, 7) && isset($_GET['uid']))
		coffee_order_action($_GET['uid']);
	elseif ('/soda' == substr($uri, 0, 5) && isset($_GET['uid']))
		soda_order_action($_GET['uid']);
	elseif ('/help' == $uri)
		help_action();
	elseif ('/kfet' == $uri)
		kfet_action();
	elseif ('/about' == $uri)
		about_action();
	elseif ('/booking' == $uri)
		booking_action();
	elseif ('/meetings.json' == substr($uri, 0, 14))
		meetings_json_action();
	elseif ('/meetings' == $uri)
		meetings_action($_SESSION['uid']);
	elseif ('/meeting' == substr($uri, 0, 8) && isset($_GET['id']))
		accept_meeting_action($_GET['id']);
	elseif ('/coworking' == $uri)
		coworking_action($_SESSION['uid']);
	elseif ('/dashboards' == $uri)
		dashboards_action();
	elseif ('/dashboard.json' == $uri)
		dashboard_json_action();
	elseif ('/stats.json' == substr($uri, 0, 11) && isset($_GET['uid']))
		stats_json_action($_GET['uid']);
	elseif ('/stats.tsv' == substr($uri, 0, 10) && isset($_GET['uid']))
		stats_tsv_action($_GET['uid']);
	elseif ('/coffees.tsv' == substr($uri, 0, 12) && isset($_GET['months']))
		coffees_tsv_action($_GET['months']);
	elseif ('/dashboard' == substr($uri, 0, 10))
		dashboard_action();
	elseif ('/energy.json' == substr($uri, 0, 12) && isset($_GET['power']) && isset($_GET['energy']))
		energy_json_action($_GET['power'], $_GET['energy']);
	elseif ('/grid.json' == $uri)
		grid_json_action();
	elseif ('/grid' == $uri)
		grid_action();
	else
		login_action();
?>
