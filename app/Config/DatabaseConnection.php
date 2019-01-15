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
    $host = getenv('DATABASE_HOST');
    $db_name = getenv('DATABASE_NAME');
    $db_user = getenv('DATABASE_USER');
    $db_password = getenv('DATABASE_PASSWORD');

    $this->connection = null;

    $db = 'mysql:host=' . $host . ';dbname=' . $db_name;

    try {
      $this->connection = new PDO($db, $db_user, $db_password);
    }
    catch(Exception $exception){
      throw $exception;
      die();
    }

    return $this->connection;
  }
}