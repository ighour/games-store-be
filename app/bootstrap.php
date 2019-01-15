<?php

//Base confs
define('__BASE_PATH__', dirname(__FILE__));
define('__PUBLIC_PATH__', __BASE_PATH__ . '/../public');
define('__STORAGE_PATH__', __BASE_PATH__ . '/../../storage');

//Autoloader
require_once(__BASE_PATH__ . '/../vendor/autoload.php');

//Load env
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(dirname(__BASE_PATH__) . '/.env');

//Php confs
ini_set("display_errors", false); 
error_reporting(E_ALL);
date_default_timezone_set('Europe/Lisbon');

//Server Info
define('__SERVER_NAME__', isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME']);
define('__SERVER_PROTOCOL__', isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] === 'on' || $_SERVER['HTTPS'] === 1)
    || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https' ? 'https' : 'http');
define('__SERVER__', __SERVER_PROTOCOL__ . '://' . __SERVER_NAME__);