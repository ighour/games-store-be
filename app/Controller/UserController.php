<?php

namespace App\Controller;

use \App\DAO\User as DAO;
use \App\Resource\UserResource as Resource;

class UserController extends Controller {
  /**
   * Constructor
   */
  public function __construct()
  {
    $this->DAO = new DAO();
    $this->resource = new Resource();
  }

  public function index()
  {
    $users = $this->DAO->fetchAll();

    $resource = $this->resource->collection($users);

    $this->withPayload(['users' => $resource])->respondOk();
  }
}