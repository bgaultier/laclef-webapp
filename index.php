<?php
  /*
    laclef-webapp v0.2 is a PHP+MySQL web application that allows the
    management of users,  users, devices, door locks, payments, RFID tags
    and readers.
    
    Copyright (C) 2013  Baptiste Gaultier

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as
    published by the Free Software Foundation, either version 3 of the
    License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU Affero General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
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
    home_action($_SESSION['uid']);
  elseif ('/login' == $uri)
    login_action();
  elseif ('/logout' == $uri)
    logout_action();
  elseif ('/signup' == $uri)
    signup_action();
  elseif ('/account' == $uri && isset($_SESSION['uid']))
    account_action($_SESSION['uid']);
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
  elseif ('/equipments/available' == substr($uri, 0, 21) && isset($_GET['id']))
    equipment_available_action($_SESSION['uid'], $_GET['id']);
  elseif ('/equipments/delete' == substr($uri, 0, 18) && isset($_GET['id']))
  		delete_equipment_action($_SESSION['uid'], $_GET['id']);
  elseif ('/equipment' == substr($uri, 0, 10) && isset($_GET['id']))
    modify_equipment_action($_SESSION['uid'], $_GET['id']);
  elseif ('/equipments' == $uri && isset($_SESSION['uid']))
    list_equipments_action($_SESSION['uid']);
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
  elseif ('/dashboards' == $uri)
    dashboards_action();
  elseif ('/dashboard.json' == substr($uri, 0, 15))
    dashboard_json_action();
  elseif ('/stats.json' == substr($uri, 0, 11) && isset($_GET['uid']))
    stats_json_action($_GET['uid']);
  elseif ('/coffees.tsv' == substr($uri, 0, 12))
    coffees_tsv_action();
  elseif ('/dashboard' == substr($uri, 0, 10))
    dashboard_action();
  else
    login_action();

?>
