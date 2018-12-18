<?php

namespace App\Config;

use PDO;
use PDOException;
use Exception;

class DatabaseConnection {
  //Connection
  public $connection;

  //Make connection
  public function connect(){
    $host = __SQL_CREDS__['host'];
    $db_name = __SQL_CREDS__['db_name'];
    $db_user = __SQL_CREDS__['db_user'];
    $db_password = __SQL_CREDS__['db_password'];

    $this->connection = null;

    $db = 'mysql:host=' . $host . ';dbname=' . $db_name;

    try {
      $this->connection = new PDO($db, $db_user, $db_password);
    }
    catch(PDOException $exception){
      echo "Connection error: " . $exception->getMessage() . PHP_EOL;
      throw $exception;
    }
    catch(Exception $exception){
      echo "Server error: " . $exception->getMessage() . PHP_EOL;
      throw $exception;
    }

    return $this->connection;
  }
}