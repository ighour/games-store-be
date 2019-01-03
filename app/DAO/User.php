<?php

namespace App\DAO;

use Exception;
use App\Config\DatabaseConnection;
use App\Model\User as UserModel;

class User extends DAO {
  protected $table = 'users';

  public function fetchAll(){
    $query = "SELECT * FROM {$this->table}";

    return $this->connect()
                ->prepare($query)
                ->execute()
                ->baseFetchAll(UserModel::class);
  }
}