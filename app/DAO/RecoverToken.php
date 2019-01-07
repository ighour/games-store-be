<?php

namespace App\DAO;

use Exception;
use App\Config\DatabaseConnection;
use App\Model\RecoverToken as RecoverTokenModel;

class RecoverToken extends DAO {
  /**
   * Constructor
   */
  public function __construct(){
    $this->table = 'recover_tokens';
    $this->model = RecoverTokenModel::class;
  }

  /**
   * Check if token is valid
   */
  public function isValid($token, $email){
    return $this->fetchByWhere(['token' => $token, 'email' => $email], 'token = :token AND email = :email');
  }
}