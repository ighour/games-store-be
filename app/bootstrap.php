<?php

//Base confs
define('__BASE_PATH__', dirname(__FILE__));

define('__SQL_CREDS__', [
  'host' => '192.168.1.18',
  'db_name' => 'saw',
  'db_user' => 'saw',
  'db_password' => 'saw'
]);

//Php confs
ini_set('display_errors', true);
error_reporting(E_ALL);
date_default_timezone_set('Europe/Lisbon');

//Autoloader
require_once(__BASE_PATH__ . '/../vendor/autoload.php');