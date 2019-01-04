<?php

namespace App\Controller;

use \App\DAO\User as DAO;
use \App\Resource\UserResource as Resource;
use \App\Sanitization\AuthSanitization as Sanitization;
use \App\Validation\AuthValidation as Validation;
use \App\Libs\JWT;

class AuthController extends Controller {
  /**
   * Constructor
   */
  public function __construct($request)
  {
    parent::__construct(Sanitization::sanitize($request));

    $this->DAO = new DAO();
    $this->resource = new Resource();
    $this->validation = new Validation($this->request);
  }

  /**
   * Login
   */
  public function login()
  {
    //Validate
    $this->validation->login();
    if($errors = $this->validation->errors())
      $this->withPayload(['errors' => $errors])->respondBadRequest();

    //Get params
    $params = $this->params(['email', 'password']);

    //Check email exists
    $user = $this->DAO->fetchByEmail($params['email']);

    if(!$user)
      $this->respondBadRequest("Wrong Credentials.");

    //Check password
    if(!password_verify($params['password'], $user->password))
      $this->respondBadRequest("Wrong Credentials.");

    //Set resource
    $resource = $this->resource->element($user);

    //Generate Token
    $jwt = JWT::create($resource);

    //Response
    $this->withPayload(['token' => $jwt])->respondOk("Logged in.");
  }
}