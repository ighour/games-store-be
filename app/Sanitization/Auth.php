<?php

namespace App\Sanitization;

class Auth extends Sanitization {
  /**
   * Sanitize
   */
  public function sanitize()
  {
    //Email
    $this->email('email');

    //Callback
    $this->URL('callback');

    //Token
    $this->string('token');

    //Return sanitized request params
    return $this->request;
  }
}