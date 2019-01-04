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
    $username = $this->checkRequired('username', 'Username is required.');
    if($username){
      $this->checkString('username', 'Username needs to be string.');
      $this->checkBetween('username', 'Username needs to be between 1 and 255 characters.', 1, 255);
      $this->checkUnique('username', 'Username needs to be unique.', $this->DAOS['user']->fetchByWhere(['username' => $this->request['username']], 'username = :username'));
    }

    //Email
    $email = $this->checkRequired('email', 'Email is required.');
    if($email){
      $this->checkEmail('email', 'Email needs to be in an email format.');
      $this->checkBetween('email', 'Email needs to be between 1 and 255 characters.', 1, 255);
      $this->checkUnique('email', 'Email needs to be unique.', $this->DAOS['user']->fetchByWhere(['email' => $this->request['email']], 'email = :email'));
    }

    //Password
    $password = $this->checkRequired('password', 'Password is required.');
    if($password){
      $this->checkString('password', 'Need to be string.');
      $this->checkBetween('password', 'Need to be between 6 and 255 characters.', 6, 255);
      $this->checkConfirmed('password', 'Need to be confirmed.');
    }

    //Role
    $role = $this->isNotNull('role');
    if($role){
      $this->checkString('role', 'Need to be string.');
      $this->checkIn('role', 'Not valid.', ['admin']);
    }
  }
}