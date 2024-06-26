<?php

namespace App\Middleware;

use \App\Libs\JWT;
use \App\DAO\TokenBlacklist as DAO;
use \App\DAO\User as UserDAO;

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
      $state->withPayload(['error' => $e->message])->respondForbidden("INVALID_TOKEN");
    }

    //Check if is blacklisted
    if((new DAO())->isBlacklisted($jwt)){
      $state->respondForbidden("INVALID_TOKEN");
    }

    //Check allowed roles
    if(!is_null($roles)){
      $userRole = $decodedJWT->pay->role;

      if(!in_array($userRole, $roles))
        $state->respondForbidden("INVALID_TOKEN_ACCESS");
    }

    //Check is the last emitted token
    $userDAO = new UserDAO();
    $result = $userDAO->tokenIsValid($decodedJWT->pay->id, $decodedJWT->iat);

    if(is_null($result) || $result == false)
      $state->respondForbidden("INVALID_TOKEN");

    //Save JWT
    $state->jwt = [
      'decoded' => $decodedJWT,
      'encoded' => $jwt
    ];
  }
}

