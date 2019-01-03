<?php

namespace App\DAO;

use Exception;
use App\Config\DatabaseConnection;
use PDO;

abstract class DAO {
  /**
   * DB connection
   */
  protected $connection;

  /**
   * DB table
   */
  protected $table;

  /**
   * Related model
   */
  protected $model;

  /**
   * SQL Statement
   */
  protected $statement;

  /**
   * Parameters
   */
  protected $params;
  
  /**
   * Connect to DB
   */
  protected function connect(){
    try{
      $DB = new DatabaseConnection();
      $this->connection = $DB->connect();
      
      return $this;
    }
    catch(Exception $exception){
      throw new Exception("Could not connect to DB.");
      die();
    }
  }

  /**
   * Prepare a statement
   */
  protected function prepare($statement){
    $this->statement = $this->connection->prepare($statement);

    return $this;
  }

  /**
   * Execute a statement
   */
  protected function execute(){
    $this->statement->execute($this->params);

    return $this;
  }

  /**
   * Set query params
   */
  protected function setParams(array $params){
    $parsedParams = [];

    foreach($params as $key => $value){
      $parsedParams[":{$key}"] = $value;
    }

    $this->params = $parsedParams;

    return $this;
  }

  /**
   * PDO fetch all rows
   */
  protected function fetchRows(){
    return $this->statement->fetchAll(PDO::FETCH_CLASS, $this->model);
  }

  /**
   * PDO fetch one row
   */
  protected function fetchRow(){
    $this->statement->setFetchMode(PDO::FETCH_CLASS, $this->model);

    return $this->statement->fetch();
  }

  /**
   * Fetch all elements from table
   */
  public function fetchAll(){
    $query = "SELECT * FROM {$this->table}";

    return $this->connect()
                ->prepare($query)
                ->execute()
                ->fetchRows();
  }

  /**
   * Fetch element from table by id
   */
  public function fetchById($id){
    $query = "SELECT * FROM {$this->table} WHERE id = :id";

    $this->params = [':id' => $id];

    return $this->connect()
                ->prepare($query)
                ->execute()
                ->fetchRow();
  }
}