<?php

namespace App\DAO;

use Exception;
use App\Config\DatabaseConnection;
use App\Model\User as UserModel;

class User extends DAO {
  /**
   * Constructor
   */
  public function __construct(){
    $this->table = 'users';
    $this->model = UserModel::class;
  }
}