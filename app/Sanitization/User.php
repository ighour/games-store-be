<?php

namespace App\Sanitization;

abstract class User extends Sanitization {
  /**
   * Sanitize
   */
  public static function sanitize($request)
  {
    //Username
    Sanitization::string($request, 'username', 'FILTER_FLAG_STRIP_HIGH');

    //Email
    Sanitization::email($request, 'email');

    //Role
    Sanitization::string($request, 'role', 'FILTER_FLAG_STRIP_HIGH');

    //User Id
    Sanitization::integer($request, 'user_id');

    //Return sanitized request params
    return $request;
  }
}