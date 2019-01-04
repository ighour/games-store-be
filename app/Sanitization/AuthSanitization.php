<?php

namespace App\Sanitization;

abstract class AuthSanitization extends Sanitization {
  /**
   * Sanitize
   */
  public static function sanitize($request)
  {
    //Email
    Sanitization::email($request, 'email');

    //Return sanitized request params
    return $request;
  }
}