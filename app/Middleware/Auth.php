<?php

namespace App\Middleware;

use \App\Libs\JWT;
use \App\DAO\TokenBlacklist as DAO;

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

    //Check if is blacklisted
    if((new DAO())->isBlacklisted($jwt)){
      $state->respondForbidden("Token is blacklisted.");
    }

    //Check allowed roles
    if(!is_null($roles)){
      $userRole = $decodedJWT->pay->role;

      if(!in_array($userRole, $roles))
        $state->respondForbidden("Forbidden access.");
    }

    //Save JWT
    $state->jwt = [
      'decoded' => $decodedJWT,
      'encoded' => $jwt
    ];
  }
}

