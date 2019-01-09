<?php

namespace App\Validation;

use \App\Libs\Helpers;

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
   * Is Boolean
   */
  protected function isBoolean($param)
  {
    return is_bool($this->request[$param]);
  }

  /**
   * Check: Required
   * Don't check anything else if false
   */
  protected function checkRequired($param)
  {
    if(!$this->isNotNull($param)){
      $this->setError($param, "Is required.");
      return false;
    }

    return true;
  }

  /**
   * Check: Boolean
   */
  protected function checkBoolean($param)
  {
    if(!is_bool($this->request[$param]))
      $this->setError($param, "Need to be boolean.");
  }

  /**
   * Check: String
   */
  protected function checkString($param)
  {
    if(!is_string($this->request[$param]))
      $this->setError($param, "Need to be string.");
  }

  /**
   * Check: Email
   */
  protected function checkEmail($param)
  {
    if(!filter_var($this->request[$param], FILTER_VALIDATE_EMAIL))
      $this->setError($param, "Need to be in email format.");
  }

  /**
   * Check: Url
   */
  protected function checkURL($param)
  {
    if(!filter_var($this->request[$param], FILTER_VALIDATE_URL))
      $this->setError($param, "Invalid URL.");
  }

  /**
   * Check: Integer
   */
  protected function checkInteger($param)
  {
    try {
      $val = intval($this->request[$param]);

      if($val != $this->request[$param])
        $this->setError($param, "Need to be integer numeric.");
    }
    catch(Exception $e){
      $this->setError($param, "Need to be integer numeric.");
    }
  }

  /**
   * Check: Double
   */
  protected function checkDouble($param, $digits=2)
  {
    try {
      $val = doubleval($this->request[$param]);

      if($val != $this->request[$param] || Helpers::numberDecimals($this->request[$param]) > $digits)
        $this->setError($param, "Need to be double numeric with {$digits} digits.");
    }
    catch(Exception $e){
      $this->setError($param, "Need to be double numeric.");
    }
  }

  /**
   * Check: Between
   */
  protected function checkBetween($param, $min, $max)
  {
    if(is_string($this->request[$param])){
      $len = strlen($this->request[$param]);

      if($len < $min || $len > $max)
        $this->setError($param, "Need to be between {$min} and {$max} character(s).");
    }
    else{
      if($this->request[$param] < $min || $this->request[$param] > $max)
        $this->setError($param, "Need to be between {$min} and {$max}.");
    }
  }

  /**
   * Check: Exists
   */
  protected function checkExists($param, $fetch)
  {
    if($fetch == false){
      $this->setError($param, "Do not exists.");
    }
  }

  /**
   * Check: Unique
   */
  protected function checkUnique($param, $fetch)
  {
    if($fetch != false){
      $this->setError($param, "Need to be unique.");
    }
  }

  /**
   * Check: Confirmed
   */
  protected function checkConfirmed($param)
  {
    $confirmed = "{$param}_confirmation";

    if(!$this->isNotNull($confirmed) || $this->request[$param] != $this->request[$confirmed])
      $this->setError($param, "Confirmation is wrong.");
  }

 /**
   * Check: In
   */
  protected function checkIn($param, array $valid)
  {
    if(!in_array($this->request[$param], $valid))
      $this->setError($param, "Invalid option.");
  }

  /**
   * Check: Image Dimensions
   */
  protected function checkImageDimension($param, $folder, $width, $height)
  {
    $name = $this->request[$param];
    $path = __PUBLIC_PATH__ . '/storage' . '/' . $folder . '/' . $name;

    if(!file_exists($path))
      $this->setError($param, "Error saving image.");

    else {
      $fileDim = getimagesize($path);

      if($fileDim[0] != $width || $fileDim[1] != $height){
        $this->setError($param, "Image dimension need to be {$width}px x {$height}px");
        Helpers::deleteFile($folder, $name);
      }
    }
  }
}