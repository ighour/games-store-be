<?php

namespace App\Sanitization;

abstract class ItemCategory extends Sanitization {
  /**
   * Sanitize
   */
  public static function sanitize($request)
  {
    //Name
    Sanitization::string($request, 'name', 'FILTER_FLAG_STRIP_HIGH');

    //Item Category Id
    Sanitization::integer($request, 'item_category_id');

    //Return sanitized request params
    return $request;
  }
}