<?php

namespace App\Validation;

class AuthValidation extends Validation {
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
}