<?php

namespace App\Sanitization;

use \App\Libs\Helpers;

abstract class Sanitization {
  /**
   * Request
   */
  protected $request;

  /**
   * Constructor
   */
  public function __construct($request)
  {
    $this->request = $request;
  }

  /**
   * Sanitize Boolean (FILTER_VALIDATE_BOOLEAN)
   */
  protected function boolean($param)
  {
    if(isset($this->request[$param])){
      $result = filter_var($this->request[$param], FILTER_VALIDATE_BOOLEAN);
      $this->request[$param] = $result;
    }
  }

  /**
   * Sanitize String (FILTER_SANITIZE_STRING)
   */
  protected function string($param, $flags=null)
  {
    if(isset($this->request[$param])){
      $result = filter_var($this->request[$param], FILTER_SANITIZE_STRING, ['flags' => $flags]);
      $this->request[$param] = $result;
    }
  }

  /**
   * Sanitize Email (FILTER_SANITIZE_EMAIL)
   */
  protected function email($param)
  {
    if(isset($this->request[$param])){
      $result = filter_var($this->request[$param], FILTER_SANITIZE_EMAIL);
      $this->request[$param] = $result;
    }
  }

  /**
   * Sanitize URL (FILTER_SANITIZE_URL)
   */
  protected function URL($param)
  {
    if(isset($this->request[$param])){
      $result = filter_var($this->request[$param], FILTER_SANITIZE_URL);
      $this->request[$param] = $result;
    }
  }

  /**
   * Sanitize Integer (FILTER_SANITIZE_NUMBER_INT)
   */
  protected function integer($param)
  {
    if(isset($this->request[$param])){
      $result = filter_var($this->request[$param], FILTER_SANITIZE_NUMBER_INT);
      $this->request[$param] = $result;
    }
  }

  /**
   * Sanitize Double (FILTER_SANITIZE_NUMBER_FLOAT)
   */
  protected function double($param)
  {
    if(isset($this->request[$param])){
      $result = filter_var($this->request[$param], FILTER_SANITIZE_NUMBER_FLOAT, ['flags' => FILTER_FLAG_ALLOW_FRACTION]);
      $this->request[$param] = $result;
    }
  }

  /**
   * Sanitize Images (Get Input, Parse and Return String Reference)
   */
  protected function image($param, $to)
  {
    try {
      $imageName = Helpers::storeFile($param, $to);

      //Add to request as image name
      $this->request[$param] = $imageName;
    }
    catch(\Exception $e){
      if(!isset($this->request[$param]))
        return;
        
      //Get value
      $result = $this->request[$param];

      //Not Null param -> set false
      if(!is_null($result)){
        $this->request[$param] = false;
      }
      else{
        unset($this->request[$param]);
      }     
    }
  }

  /**
   * Sanitize
   */
  abstract public function sanitize();
}