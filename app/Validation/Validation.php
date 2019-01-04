<?php

namespace App\Validation;

abstract class Validation {
  /**
   * Request
   */
  protected $request;

  /**
   * Validation Messages
   */
  protected $errors = [];

  /**
   * DAOs
   */
  protected $DAOS = [];

  /**
   * Constructor
   */
  public function __construct($request)
  {
    $this->request = $request;
  }

  /**
   * Set an error
   */
  protected function setError($param, $message)
  {
    if(!isset($this->errors[$param]))
      $this->errors[$param] = [];

    array_push($this->errors[$param], $message);
  }

  /**
   * Get errors
   */
  public function errors()
  {
    if(empty($this->errors))
      return false;

    return $this->errors;
  }

  /**
   * Is Present
   */
  protected function isPresent($param)
  {
    if(isset($this->request[$param]))
      return true;

    return false;
  }

  /**
   * Is Present and Not Null
   */
  protected function isNotNull($param)
  {
    if(!isset($this->request[$param]) || is_null($this->request[$param]))
      return false;

    return true;
  }

  /**
   * Is Present and Null
   */
  protected function isNull($param)
  {
    if(!isset($this->request[$param]) || !is_null($this->request[$param]))
      return false;

    return true;
  }

  /**
   * Check: Required
   * Don't check anything else if false
   */
  protected function checkRequired($param, $message)
  {
    if(!$this->isNotNull($param)){
      $this->setError($param, $message);
      return false;
    }

    return true;
  }

  /**
   * Check: String
   */
  protected function checkString($param, $message)
  {
    if(!is_string($this->request[$param]))
      $this->setError($param, $message);
  }

  /**
   * Check: Email
   */
  protected function checkEmail($param, $message)
  {
    if(!filter_var($this->request[$param], FILTER_VALIDATE_EMAIL))
      $this->setError($param, $message);
  }

  /**
   * Check: Between
   */
  protected function checkBetween($param, $message, $min, $max)
  {
    if(is_string($this->request[$param])){
      $len = strlen($this->request[$param]);

      if($len < $min || $len > $max)
        $this->setError($param, $message);
    }
    else{
      if($this->request[$param] < $min || $this->request[$param] > $max)
        $this->setError($param, $message);
    }
  }

  /**
   * Check: Unique
   */
  protected function checkUnique($param, $message, $fetch)
  {
    if($fetch != false){
      $this->setError($param, $message);
    }
  }

  /**
   * Check: Confirmed
   */
  protected function checkConfirmed($param, $message)
  {
    $confirmed = "{$param}_confirmation";

    if(!$this->isNotNull($confirmed))
      $this->setError($param, $message);
  }

 /**
   * Check: In
   */
  protected function checkIn($param, $message, array $valid)
  {
    if(!in_array($this->request[$param], $valid))
      $this->setError($param, $message);
  }

  /**
   * Validate Create
   */
  abstract public function create();
}