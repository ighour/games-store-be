<?php

namespace App\Controller;

use \App\DAO\Item as DAO;
use \App\Resource\Item as Resource;
use \App\Sanitization\Item as Sanitization;
use \App\Validation\Item as Validation;
use \App\Middleware\Auth as AuthMiddleware;

class Item extends Controller {
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
    //Fetch all
    $elements = $this->DAO->fetchAll();

    //Set resource
    $resource = $this->resource->collection($elements);

    //Response
    $this->withPayload(['items' => $resource])->respondOk();
  }

  /**
   * Create an element
   */
  public function create()
  {
    //Auth Middleware
    AuthMiddleware::run($this);

    //Validate
    $this->validation->create();
    if($errors = $this->validation->errors())
      $this->withPayload(['errors' => $errors])->respondValidationError();

    //Params
    $params = $this->params(['name', 'type', 'description', 'amount', 'item_category_id']);

    //Get User Id
    $params['user_id'] = $this->getAuthId();

    //Check is the auth user
    if(!$this->isAuth($params['user_id']))
      $this->respondForbidden();

    //Create
    $element = $this->DAO->create($params);

    //Set resource
    $resource = $this->resource->element($element);

    //Response
    $this->withPayload(['item' => $resource])->respondCreated();
  }

  /**
   * Show an element
   */
  public function show()
  {
    //Get id
    $id = $this->request['item_id'];

    //Fetch element
    $element = $this->DAO->fetchById($id);

    //Not found
    if(!$element)
      $this->respondNotFound("Item not found.");

    //Set resource
    $resource = $this->resource->element($element);

    //Response
    $this->withPayload(['item' => $resource])->respondOk();
  }

  /**
   * Update an element
   */
  public function update()
  {
    //Auth Middleware
    AuthMiddleware::run($this);

    //Validate
    $this->validation->update();
    if($errors = $this->validation->errors())
      $this->withPayload(['errors' => $errors])->respondValidationError();
      
    //Params
    $params = $this->params(['name', 'type', 'description', 'amount', 'item_category_id']);

    //Get id
    $id = $this->request['item_id'];

    //Check is the owner of item
    if(!$this->isOwner($id))
      $this->respondForbidden();

    //Update
    $element = $this->DAO->update($params, $id);

    //Not Found
    if(!$element)
      $this->respondBadRequest("Nothing to update.");

    //Set resource
    $resource = $this->resource->element($element);

    //Response
    $this->withPayload(['item' => $resource])->respondOk();
  }

  /**
   * Delete an element
   */
  public function delete()
  {
    //Auth Middleware
    AuthMiddleware::run($this);

    //Get id
    $id = $this->request['item_id'];

    //Check is the owner of item
    if(!$this->isOwner($id))
      $this->respondForbidden();

    //Delete
    $element = $this->DAO->delete($id);

    //Not Found
    if(!$element)
      $this->respondNotFound();

    //Response
    $this->respondOk();
  }
}