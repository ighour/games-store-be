<?php

//Base confs
define('__BASE_PATH__', dirname(__FILE__));

//Autoloader
require_once(__BASE_PATH__ . '/../vendor/autoload.php');

//Load env
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(dirname(__BASE_PATH__) . '/.env');

//Php confs
ini_set('display_errors', true);
error_reporting(E_ALL);
date_default_timezone_set('Europe/Lisbon');