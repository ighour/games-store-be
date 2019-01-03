<?php

namespace App\Model;

use Exception;

class Model {
  /**
   * Set class parameters
   */
  public function setParams($params){
    foreach($params as $key => $value){
      if(!property_exists($this, $key))
        throw new Exception("Invalid property {$key}.");

      $this->$key = $value;
    }
  }
}