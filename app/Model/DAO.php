<?php

namespace App\Model;

use Exception;
use App\Config\DatabaseConnection;

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

  protected function baseFetchAll(){
    return $this->statement->fetchAll();
  }

  abstract public function fetchAll();
}