<?php

namespace App\Validation;

class Auth extends Validation {
  /**
   * Validate Login
   */
  public function login()
  {
    //Email
    $email = $this->checkRequired('email');

    //Password
    $password = $this->checkRequired('password');
  }

  /**
   * Validate Forget Password
   */
  public function forget()
  {
    //Email
    $email = $this->checkRequired('email');

    //Callback URL
    $callback = $this->checkRequired('callback');
    if($callback){
      $this->checkURL('callback');
    }
  }

  /**
   * Validate Recover Password
   */
  public function recover()
  {
    //Email
    $email = $this->checkRequired('email');

    //Token
    $token = $this->checkRequired('token');
    if($token){
      $this->checkString('token');
    }

    //Password
    $password = $this->checkRequired('password');
    if($password){
      $this->checkString('password');
      $this->checkBetween('password', 6, 255);
      $this->checkConfirmed('password');
    }
  }
}