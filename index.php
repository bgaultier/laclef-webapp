<?php
  /*
    laclef-webapp v0.1 is a PHP+MySQL web application that allows the
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
    home_action($_SESSION['id']);
  elseif ('/login' == $uri)
    login_action();
  elseif ('/logout' == $uri)
    logout_action();
  elseif ('/signup' == $uri)
    signup_action();
  elseif ('/account' == $uri)
    account_action($_SESSION['email']);
  elseif ('/users' == $uri)
    list_users_action($_SESSION['id']);
  elseif ('/tags' == $uri)
    list_tags_action($_SESSION['id']);
  elseif ('/help' == $uri)
    help_action();
  elseif ('/about' == $uri)
    about_action();
  else
    login_action();

?>
