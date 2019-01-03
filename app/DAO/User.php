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
   * Create a user
   */
  public function create(array $params){
    $id = $this->withQuery("INSERT INTO {$this->table} (username, email, password, role) VALUES (:username, :email, :password, :role)")
                ->insert($params);

    $element = new UserModel();

    $element->setParams([
      'id' => $id,
      'username' => $params['username'],
      'email' => $params['email'],
      'password' => $params['password'],
      'role' => $params['role']
    ]);

    return $element;
  }
}