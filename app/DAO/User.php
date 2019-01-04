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

  /**
   * Fetch user by email
   */
  public function fetchByEmail($email){
    return $this->fetchByWhere(['email' => $email], 'email = :email');
  }
}