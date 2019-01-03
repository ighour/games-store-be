<?php

namespace App\DAO;

use Exception;
use App\Config\DatabaseConnection;
use PDO;

abstract class DAO {
  protected $connection;
  protected $statement;
  
  protected function connect(){
    try{
      $DB = new DatabaseConnection();
      $this->connection = $DB->connect();
      
      return $this;
    }
    catch(Exception $exception){
      die();
    }
  }

  protected function prepare($statement){
    $this->statement = $this->connection->prepare($statement);

    return $this;
  }

  protected function execute($params=[]){
    $this->statement->execute($params);

    return $this;
  }

  protected function baseFetchAll($Model){
    return $this->statement->fetchAll(PDO::FETCH_CLASS, $Model);
  }

  abstract public function fetchAll();
}