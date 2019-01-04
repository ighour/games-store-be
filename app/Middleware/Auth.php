<?php

namespace App\Middleware;

use \App\Libs\JWT;

abstract class Auth {
  /**
   * Run middleware
   */
  public static function run($state, $roles=null)
  {
    //Get Authorization
    $headers = getallheaders();

    if(!isset($headers['Authorization']))
      $state->respondForbidden("Unauthenticated user.");

    $authorization = explode(" ", $headers['Authorization']);

    if($authorization[0] !== 'Bearer' || !isset($authorization[1]))
      $state->respondForbidden("Unauthenticated user.");

    //Get JWT
    $jwt = $authorization[1];

    //Decode JWT
    try {
      $decodedJWT = JWT::decode($jwt);
    }
    catch(Exception $e){
      $state->withPayload(['error' => $e->message])->respondForbidden("Invalid authentication.");
    }

    //Check allowed roles
    if(!is_null($roles)){
      $userRole = $decodedJWT->pay->role;

      if(!in_array($userRole, $roles))
        $state->respondForbidden("Forbidden access.");
    }

    //Save decoded JWT
    $state->decodedJWT = $decodedJWT;
  }
}

