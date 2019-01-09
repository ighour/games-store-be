<?php

namespace App\Controller;

use \App\DAO\User as DAO;
use \App\Resource\User as Resource;
use \App\Sanitization\User as Sanitization;
use \App\Validation\User as Validation;
use \App\Middleware\Auth as AuthMiddleware;
use \App\Libs\Helpers;

class User extends Controller {
  /**
   * Constructor
   */
  public function __construct($request)
  {
    $this->request = (new Sanitization($request))->sanitize();
    $this->DAO = new DAO();
    $this->resource = new Resource();
    $this->validation = new Validation($this->request);
  }

  /**
   * Fetch all elements
   */
  public function index()
  {
    //Auth Middleware
    AuthMiddleware::run($this, ['admin']);

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
      $this->withPayload(['errors' => $errors])->respondValidationError();

    //Params
    $params = $this->params(['username', 'email', 'password', 'role', 'avatar']);

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
    //Auth Middleware
    AuthMiddleware::run($this, ['admin']);

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
      $this->withPayload(['errors' => $errors])->respondValidationError();
      
    //Params
    $params = $this->params(['username', 'email', 'password', 'role', 'avatar']);

    //Auth Middleware
    AuthMiddleware::run($this);

    //Get id
    $id = $this->request['user_id'];

    //Auth Middleware (if is not himself)
    $userId = $this->getAuthId();
    if($userId !== $id)
      AuthMiddleware::run($this, ['admin']);

    //Remove old avatar if is false (delete) or updated (string)
    if(isset($params['avatar'])){
      $user = $this->DAO->fetchById($id);
      Helpers::deleteFile('avatars', $user->avatar);

      if($params['avatar'] == false)
        $params['avatar'] = null;
    }

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
    //Auth Middleware
    AuthMiddleware::run($this, ['admin']);

    //Get id
    $id = $this->request['user_id'];

    //Remove old avatar if is false (delete) or updated (string)
    $user = $this->DAO->fetchById($id);
    Helpers::deleteFile('avatars', $user->avatar);

    //Delete
    $element = $this->DAO->delete($id);

    //Not Found
    if(!$element)
      $this->respondNotFound();

    //Response
    $this->respondOk();
  }
}