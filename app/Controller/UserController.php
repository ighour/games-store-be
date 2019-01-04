<?php

namespace App\Controller;

use \App\DAO\User as DAO;
use \App\Resource\UserResource as Resource;
use \App\Validation\UserValidation as Validation;

class UserController extends Controller {
  /**
   * Constructor
   */
  public function __construct($request)
  {
    parent::__construct($request);

    $this->DAO = new DAO();
    $this->resource = new Resource();
    $this->validation = new Validation($request);
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

    //Create
    $element = $this->DAO->create($params);

    //Set resource
    $resource = $this->resource->element($element);

    //Response
    $this->withPayload(['user' => $resource])->respondCreated();
  }
}