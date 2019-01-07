<?php

namespace App\Controller;

use \App\DAO\User as DAO;
use \App\DAO\TokenBlacklist as TokenBlacklistDAO;
use \App\DAO\RecoverToken as RecoverTokenDAO;
use \App\Resource\UserResource as Resource;
use \App\Sanitization\AuthSanitization as Sanitization;
use \App\Validation\AuthValidation as Validation;
use \App\Libs\JWT;
use \App\Middleware\Auth as AuthMiddleware;
use \App\Libs\Emails\RecoverPassword;
use PHPMailer\PHPMailer\Exception as MailerException;

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
      $this->withPayload(['errors' => $errors])->respondValidationError();

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

  /**
   * Logout
   */
  public function logout()
  {
    //Auth Middleware
    AuthMiddleware::run($this);

    //Blacklist token
    $dao = new TokenBlacklistDAO();
    $dao->create(['token' => $this->getEncodedJWT()]);

    //Response
    $this->respondOk();
  }

  /**
   * Forget Password (generates token)
   */
  public function forget()
  {
    //Validate
    $this->validation->forget();
    if($errors = $this->validation->errors())
      $this->withPayload(['errors' => $errors])->respondValidationError();

    //Params
    $params = $this->params(['email', 'callback']);

    //Generate Token
    $token = bin2hex(random_bytes(mt_rand(15,30)));

    $dao = new RecoverTokenDAO();
    $recoverToken = $dao->create(['email' => $params['email'], 'token' => $token]);

    //Send Recover Email
    try{
      $email = new RecoverPassword();
      $email->sendEmail(['games.store@saw.testing.pt', 'Games Store'], [$params['email'], $params['email']], $recoverToken->token, $params['callback']);
    }
    catch(MailerException $e)
    {
      return $this->withPayload(['error' => $email->getError()])->respondInternalServerError("EMAIL_SEND_ERROR");
    }

    //Response
    $this->respondOk();
  }

  /**
   * Recover Password (uses token)
   */
  public function recover()
  {
    //Validate
    $this->validation->recover();
    if($errors = $this->validation->errors())
      $this->withPayload(['errors' => $errors])->respondValidationError();

    //Params
    $params = $this->params(['email', 'token', 'password']);

    //Check if Token is Valid
    $rtDao = new RecoverTokenDAO();
    $recoverToken = $rtDao->isValid($params['token'], $params['email']);

    //Invalid Token
    if($recoverToken == false)
      $this->respondBadRequest("Invalid Password Recovery.");

    //Get User
    $user = $this->DAO->fetchByEmail($params['email']);

    //Not found user
    if(!$user)
      $this->respondBadRequest("Invalid Password Recovery.");

    //Delete Recover Token
    $rtDao->delete($recoverToken->id);

    //Reset Password
    $hash = password_hash($params['password'], PASSWORD_BCRYPT);
    $this->DAO->update(['password' => $hash], $user->id);

    //Response
    $this->respondOk("Password Reset.");
  }
}