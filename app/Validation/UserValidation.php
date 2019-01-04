<?php

namespace App\Validation;

use \App\DAO\User as UserDAO;

class UserValidation extends Validation {
   /**
   * Constructor
   */
  public function __construct($request)
  {
    parent::__construct($request);

    $this->DAOS['user'] = new UserDAO();
  }

  /**
   * Validate Create
   */
  public function create()
  {
    //Username
    $username = $this->checkRequired('username');
    if($username){
      $this->checkString('username');
      $this->checkBetween('username', 1, 255);
      $this->checkUnique('username', $this->DAOS['user']->fetchByWhere(['username' => $this->request['username']], 'username = :username'));
    }

    //Email
    $email = $this->checkRequired('email');
    if($email){
      $this->checkEmail('email');
      $this->checkBetween('email', 1, 255);
      $this->checkUnique('email', $this->DAOS['user']->fetchByWhere(['email' => $this->request['email']], 'email = :email'));
    }

    //Password
    $password = $this->checkRequired('password');
    if($password){
      $this->checkString('password');
      $this->checkBetween('password', 6, 255);
      $this->checkConfirmed('password');
    }

    //Role
    $role = $this->isPresent('role');
    if($role){
      $this->checkString('role');
      $this->checkIn('role', ['admin']);
    }
  }

  /**
   * Validate Update
   */
  public function update()
  {
    //Username
    $username = $this->isPresent('username');
    if($username){
      $this->checkRequired('username');
      $this->checkString('username');
      $this->checkBetween('username', 1, 255);
      $this->checkUnique('username', $this->DAOS['user']->fetchByWhere(['username' => $this->request['username']], 'username = :username'));
    }

    //Email
    $email = $this->isPresent('email');
    if($email){
      $this->checkRequired('email');
      $this->checkEmail('email');
      $this->checkBetween('email', 1, 255);
      $this->checkUnique('email', $this->DAOS['user']->fetchByWhere(['email' => $this->request['email']], 'email = :email'));
    }

    //Password
    $password = $this->isPresent('password');
    if($password){
      $this->checkRequired('password');
      $this->checkString('password');
      $this->checkBetween('password', 6, 255);
      $this->checkConfirmed('password');
    }

    //Role
    $role = $this->isPresent('role');
    if($role){
      $this->checkString('role');
      $this->checkIn('role', ['admin']);
    }
  }
}