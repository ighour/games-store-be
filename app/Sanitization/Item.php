<?php

namespace App\Sanitization;

abstract class Item extends Sanitization {
  /**
   * Sanitize
   */
  public static function sanitize($request)
  {
    //Name
    Sanitization::string($request, 'name');

    //Type
    Sanitization::string($request, 'type');

    //Description
    Sanitization::string($request, 'description');

    //Amount
    Sanitization::double($request, 'amount');

    //Item Category Id
    Sanitization::integer($request, 'item_category_id');

    //User Id
    Sanitization::integer($request, 'user_id');

    //Return sanitized request params
    return $request;
  }
}