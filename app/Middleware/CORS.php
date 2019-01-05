<?php

namespace App\Middleware;

abstract class CORS {
  /**
   * Run middleware
   */
  public static function run()
  {
    //Set Headers
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Origin: " . getenv('HEADER_ACCESS_CONTROL_ALLOW_ORIGIN'));
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day

    //Get Origin
    if(isset($_SERVER['HTTP_ORIGIN'])){
      $origin = $_SERVER['HTTP_ORIGIN'];
    }
    else{
      $origin = $_SERVER['REQUEST_SCHEME'] . '://' . parse_url($_SERVER['SERVER_NAME'])['path'];
    } 

    //Check origin is allowed
    $allowedOrigin = getenv('HEADER_ACCESS_CONTROL_ALLOW_ORIGIN');
    if(is_string($allowedOrigin)){
      if($allowedOrigin !== '*' && $allowedOrigin !== $origin)
        CORS::notAllowed();
    }
    else{
      if(!in_array($origin, $allowedOrigin))
        CORS::notAllowed();
    }

    // Access-Control headers are received during OPTIONS requests
    if($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){

      if(isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: OPTIONS, GET, POST, PUT, DELETE");         

      if(isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

      //End script
      exit(0);
    }
  }

  /**
   * Origin not allowed
   */
  private function notAllowed()
  {
    echo json_encode(['message' => 'ORIGIN_NOT_ALLOWED']);
    exit(1);
  }
}

