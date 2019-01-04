<?php

namespace App\Controller;

use \App\DAO\User as DAO;
use \App\Resource\UserResource as Resource;
use \App\Sanitization\UserSanitization as Sanitization;
use \App\Validation\UserValidation as Validation;
use \Firebase\JWT\JWT;

class UserController extends Controller {
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
   * Fetch all elements
   */
  public function index()
  {
    //Fetch all
    $users = $this->DAO->fetchAll();

    //Set resource
    $resource = $this->resource->collection($users);

    //Response
    $this->withPayload(['users' => $resource])->respondOk();
  }

  /**
   * Create an element
   */
  public function create()
  {
    //Validate
    $this->validation->create();
    if($errors = $this->validation->errors())
      $this->withPayload(['errors' => $errors])->respondBadRequest();

    //Params
    $params = $this->params(['username', 'email', 'password', 'role']);

    //Hash password before storing in DB
    $hash = password_hash($params['password'], PASSWORD_BCRYPT);
    $params['password'] = $hash;

    //Create
    $element = $this->DAO->create($params);

    //Set resource
    $resource = $this->resource->element($element);

    //Response
    $this->withPayload(['user' => $resource])->respondCreated();
  }

  /**
   * Show an element
   */
  public function show()
  {
    //Get id
    $id = $this->request['user_id'];

    //Fetch element
    $element = $this->DAO->fetchById($id);

    //Not found
    if(!$element)
      $this->respondNotFound("User not found.");

    //Set resource
    $resource = $this->resource->element($element);

    //Response
    $this->withPayload(['user' => $resource])->respondOk();
  }

  /**
   * Update an element
   */
  public function update()
  {
    //Validate
    $this->validation->update();
    if($errors = $this->validation->errors())
      $this->withPayload(['errors' => $errors])->respondBadRequest();
      
    //Params
    $params = $this->params(['username', 'email', 'password', 'role']);

    //Get id
    $id = $this->request['user_id'];

    //Update
    $element = $this->DAO->update($params, $id);

    //Not Found
    if(!$element)
      $this->respondBadRequest("Nothing to update.");

    //Set resource
    $resource = $this->resource->element($element);

    //Response
    $this->withPayload(['user' => $resource])->respondOk();
  }

  /**
   * Delete an element
   */
  public function delete()
  {
    //Get id
    $id = $this->request['user_id'];

    //Delete
    $element = $this->DAO->delete($id);

    //Not Found
    if(!$element)
      $this->respondNotFound();

    //Response
    $this->respondOk();
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

    //Generate Token
    $jwt = $this->tokenGen($user);

    //Response
    $this->withPayload(['token' => $jwt])->respondOk("Logged in.");
  }

  /**
   * Generate Token
   */
  private function tokenGen($user)
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

    return JWT::encode($token, $key);
  }
}