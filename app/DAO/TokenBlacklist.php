<?php

namespace App\DAO;

use Exception;
use App\Config\DatabaseConnection;
use App\Model\TokenBlacklist as TokenBlacklistModel;

class TokenBlacklist extends DAO {
  /**
   * Constructor
   */
  public function __construct(){
    $this->table = 'token_blacklist';
    $this->model = TokenBlacklistModel::class;
  }

  /**
   * Check if token is blacklisted
   */
  public function isBlacklisted($token){
    return $this->fetchByWhere(['token' => $token], 'token = :token') != false;
  }
}