<?php

namespace App\Model;

use Exception;
use App\Config\DatabaseConnection;

class User extends DAO {
  protected $table = 'users';

  public function fetchAll(){
    $query = "SELECT * FROM {$this->table}";

    return $this->connect()
                ->prepare($query)
                ->execute()
                ->baseFetchAll();
  }
}