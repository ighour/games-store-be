<?php

namespace App\Libs;

use \Firebase\JWT\JWT as FirebaseJWT;

abstract class JWT {
  /**
   * Generate Token
   */
  public static function create($userResource)
  {
    $url = $_SERVER['REQUEST_SCHEME'] . '://' . parse_url($_SERVER['SERVER_NAME'])['path'];  //Get issuer by Scheme + Hostname

    $token = [
      'iss' =>  $url, //Issuer
      'aud' => $url, //Audience
      'iat' => date_timestamp_get(date_create()), //Issued at
      'nbf' => 1546634169, //Not before (2019-01-04)
      'exp' => getenv('JWT_EXPIRE') + 1546634169, //Expires in (ms)
      'pay' => [  //Payload
        'id' => $userResource['id'],
        'username' => $userResource['username'],
        'role' => $userResource['role']
      ]
    ];

    return FirebaseJWT::encode($token, getenv('JWT_KEY'));
  }

  /**
   * Decode Token
   */
  public static function decode($jwt)
  {
    try {
      $decoded = FirebaseJWT::decode($jwt, getenv("JWT_KEY"), ['HS256']);
    }
    catch(Exception $e){
      throw new \Exception("Error parsing JWT.", $e->getCode(), $e);
    }

    return $decoded;
  }

  /**
   * Get User Id
   */
  public static function getUserId($jwt)
  {
    $decoded = $this->decode($jwt);

    return $decoded['pay']['id'];
  }
}

