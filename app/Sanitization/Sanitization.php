<?php

namespace App\Sanitization;

abstract class Sanitization {
  /**
   * Sanitize String (FILTER_SANITIZE_STRING)
   */
  protected static function string($request, $param, $flags=null)
  {
    if(isset($request[$param])){
      $result = filter_var($request[$param], FILTER_SANITIZE_STRING, ['flags' => $flags]);
      $request[$param] = $result;
    }
  }

  /**
   * Sanitize Email (FILTER_SANITIZE_EMAIL)
   */
  protected static function email($request, $param)
  {
    if(isset($request[$param])){
      $result = filter_var($request[$param], FILTER_SANITIZE_EMAIL);
      $request[$param] = $result;
    }
  }

  /**
   * Sanitize URL (FILTER_SANITIZE_URL)
   */
  protected static function URL($request, $param)
  {
    if(isset($request[$param])){
      $result = filter_var($request[$param], FILTER_SANITIZE_URL);
      $request[$param] = $result;
    }
  }

  /**
   * Sanitize Integer (FILTER_SANITIZE_NUMBER_INT)
   */
  protected static function integer($request, $param)
  {
    if(isset($request[$param])){
      $result = filter_var($request[$param], FILTER_SANITIZE_NUMBER_INT);
      $request[$param] = $result;
    }
  }

  /**
   * Sanitize
   */
  abstract public static function sanitize($request);
}