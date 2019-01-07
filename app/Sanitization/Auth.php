<?php

namespace App\Sanitization;

abstract class Auth extends Sanitization {
  /**
   * Sanitize
   */
  public static function sanitize($request)
  {
    //Email
    Sanitization::email($request, 'email');

    //Callback
    Sanitization::URL($request, 'callback');

    //Token
    Sanitization::string($request, 'token');

    //Return sanitized request params
    return $request;
  }
}