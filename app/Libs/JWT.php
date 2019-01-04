<?php

namespace App\Libs;

use \Firebase\JWT\JWT as FirebaseJWT;

abstract class JWT {
  /**
   * Generate Token
   */
  public static function create($user)
  {
    $key = getenv('JWT_KEY');  //Private key
    $url = $_SERVER['REQUEST_SCHEME'] . '://' . parse_url($_SERVER['SERVER_NAME'])['path'];  //Get issuer by Scheme + Hostname

    $token = [
      'iss' =>  $url, //Issuer
      'aud' => $url, //Audience
      'iat' => date_timestamp_get(date_create()), //Issued at
      'nbf' => 1546634169, //Not before (2019-01-04)
      'exp' => getenv('JWT_EXPIRE') + 1546634169, //Expires in (ms)
      'pay' => [  //Payload
        'id' => $user->id,
        'username' => $user->username
      ]
    ];

    return FirebaseJWT::encode($token, $key);
  }
}

