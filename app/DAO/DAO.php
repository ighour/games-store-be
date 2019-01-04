<?php

namespace App\DAO;

use Exception;
use App\Config\DatabaseConnection;
use PDO;

abstract class DAO {
  /**
   * DB connection
   */
  private $connection;

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
  private $statement;

  /**
   * SQL query
   */
  private $query;

  /**
   * Parameters
   */
  private $params;
  
  /**
   * Connect to DB
   */
  private function connect(){
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
  private function prepare(){
    $this->statement = $this->connection->prepare($this->query);

    return $this;
  }

  /**
   * Execute a statement
   */
  private function execute(){
    $this->statement->execute($this->params);

    return $this;
  }

  /**
   * Set query params
   */
  private function withParams(array $params){
    $parsedParams = [];

    foreach($params as $key => $value){
      $parsedParams[":{$key}"] = $value;
    }

    $this->params = $parsedParams;

    return $this;
  }

  /**
   * Parse parameters to query
   * ...[PARAMS] VALUES [VALUES]...
   */
  private function paramsToQuery(array $params)
  {
    foreach($params as $key => $value){
      $attributes[] = $key;
      $values[] = ":{$key}";
    }

    return [
      'params' => join(", ", $attributes),
      'values' => join(", ", $values)
    ];
  }

  /**
   * Parse parameters to query for insert
   * ...[PARAMS = VALUES]...
   */
  private function paramsToQueryInsert(array $params)
  {
    foreach($params as $key => $value){
      $finalParams[] = "{$key} = :{$key}";
    }

    return join(", ", $finalParams);
  }

  /**
   * Generate select query
   */
  private function generateSelectQuery(array $params){
    $parsedParams = $this->paramsToQuery($params);

    $this->query = "SELECT * FROM {$this->table} WHERE {$parsedParams['params']} = {$parsedParams['values']}";

    return $this->withParams($params);
  }

  /**
   * Generate insert query
   */
  private function generateInsertQuery(array $params){
    $parsedParams = $this->paramsToQuery($params);

    $this->query = "INSERT INTO {$this->table} ({$parsedParams['params']}) VALUES ({$parsedParams['values']})";

    return $this->withParams($params);
  }

  /**
   * Generate update query
   */
  private function generateUpdateQuery(array $params, $id){
    $parsedParams = $this->paramsToQueryInsert($params);

    $this->query = "UPDATE {$this->table} SET {$parsedParams} WHERE id = :id";

    return $this->withParams(array_merge($params, ['id' => $id]));
  }

  /**
   * Generate delete query
   */
  private function generateDeleteQuery($id){
    $this->query = "DELETE FROM {$this->table} WHERE id = :id";

    return $this->withParams(['id' => $id]);
  }

  /**
   * PDO fetch all rows
   */
  private function fetchRows(){
    return $this->statement->fetchAll(PDO::FETCH_CLASS, $this->model);
  }

  /**
   * PDO fetch one row
   */
  private function fetchRow(){
    $this->statement->setFetchMode(PDO::FETCH_CLASS, $this->model);

    return $this->statement->fetch();
  }

  /**
   * Fetch all elements from table
   */
  public function fetchAll(){
    $this->query = "SELECT * FROM {$this->table}";
    
    return $this->connect()
                ->prepare()
                ->execute()
                ->fetchRows();
  }

  /**
   * Fetch element from table by id
   */
  public function fetchById($id){
    return $this->connect()
                ->generateSelectQuery(['id' => $id])
                ->prepare()
                ->execute()
                ->fetchRow();
  }

  /**
   * Create element
   */
  public function create(array $params)
  {
    $id = $this->connect()
                ->generateInsertQuery($params)
                ->prepare()
                ->execute()
                ->connection
                ->lastInsertId();

    $className = $this->model;

    $element = new $className();

    $element->setParams(array_merge($params, ['id' => $id]));

    return $element;
  }

  /**
   * Update element
   */
  public function update(array $params, $id)
  {
    $this->connect()
          ->generateUpdateQuery($params, $id)
          ->prepare()
          ->execute();

    if($this->statement->rowCount() == 0)
      return false;

    return $this->fetchById($id);
  }

  /**
   * Delete element
   */
  public function delete($id)
  {
    $this->connect()
          ->generateDeleteQuery($id)
          ->prepare()
          ->execute();

    return $this->statement->rowCount() > 0;
  }
}