<?php

namespace App\Sanitization;

class ItemCategory extends Sanitization {
  /**
   * Sanitize
   */
  public function sanitize()
  {
    //Name
    $this->string('name', 'FILTER_FLAG_STRIP_HIGH');

    //Item Category Id
    $this->integer('item_category_id');

    //Return sanitized request params
    return $this->request;
  }
}