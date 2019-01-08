<?php

namespace App\Sanitization;

class Item extends Sanitization {
  /**
   * Sanitize
   */
  public function sanitize()
  {
    //Name
    $this->string('name');

    //Type
    $this->string('type');

    //Description
    $this->string('description');

    //Amount
    $this->double('amount');

    //Item Category Id
    $this->integer('item_category_id');

    //User Id
    $this->integer('user_id');

    //Image
    $this->image('image', 'games');

    //Return sanitized request params
    return $this->request;
  }
}