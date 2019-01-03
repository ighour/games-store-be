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
   * SQL query
   */
  protected $query;

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
  protected function prepare(){
    $this->statement = $this->connection->prepare($this->query);

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
   * Set query
   */
  protected function withQuery($query){
    $this->query = $query;

    return $this;
  }

  /**
   * Set query params
   */
  protected function withParams(array $params){
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
    return $this->connect()
                ->withQuery("SELECT * FROM {$this->table}")
                ->prepare()
                ->execute()
                ->fetchRows();
  }

  /**
   * Fetch element from table by id
   */
  public function fetchById($id){
    return $this->connect()
                ->withQuery("SELECT * FROM {$this->table} WHERE id = :id")
                ->prepare()
                ->withParams([':id' => $id])
                ->execute()
                ->fetchRow();
  }

  /**
   * Insert element in table
   */
  protected function insert(array $params){
    if(is_null($this->query))
      throw new Exception("Query is required when using insert.");

    return $this->connect()->prepare()->withParams($params)->execute()->connection->lastInsertId();

  }
}