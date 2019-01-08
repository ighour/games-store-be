<?php

namespace App\Controller;

use \App\DAO\ItemCategory as DAO;
use \App\Resource\ItemCategory as Resource;
use \App\Sanitization\ItemCategory as Sanitization;
use \App\Validation\ItemCategory as Validation;
use \App\Middleware\Auth as AuthMiddleware;

class ItemCategory extends Controller {
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
    $this->withPayload(['item_categories' => $resource])->respondOk();
  }

  /**
   * Create an element
   */
  public function create()
  {
    //Auth Middleware
    AuthMiddleware::run($this, ['admin']);

    //Validate
    $this->validation->create();
    if($errors = $this->validation->errors())
      $this->withPayload(['errors' => $errors])->respondValidationError();

    //Params
    $params = $this->params(['name']);

    //Create
    $element = $this->DAO->create($params);

    //Set resource
    $resource = $this->resource->element($element);

    //Response
    $this->withPayload(['item_category' => $resource])->respondCreated();
  }

  /**
   * Show an element
   */
  public function show()
  {
    //Get id
    $id = $this->request['item_category_id'];

    //Fetch element
    $element = $this->DAO->fetchById($id);

    //Not found
    if(!$element)
      $this->respondNotFound("Item Category not found.");

    //Set resource
    $resource = $this->resource->element($element);

    //Response
    $this->withPayload(['item_category' => $resource])->respondOk();
  }

  /**
   * Update an element
   */
  public function update()
  {
    //Auth Middleware
    AuthMiddleware::run($this, ['admin']);

    //Validate
    $this->validation->update();
    if($errors = $this->validation->errors())
      $this->withPayload(['errors' => $errors])->respondValidationError();
      
    //Params
    $params = $this->params(['name']);

    //Get id
    $id = $this->request['item_category_id'];

    //Update
    $element = $this->DAO->update($params, $id);

    //Not Found
    if(!$element)
      $this->respondBadRequest("Nothing to update.");

    //Set resource
    $resource = $this->resource->element($element);

    //Response
    $this->withPayload(['item_category' => $resource])->respondOk();
  }

  /**
   * Delete an element
   */
  public function delete()
  {
    //Auth Middleware
    AuthMiddleware::run($this, ['admin']);

    //Get id
    $id = $this->request['item_category_id'];

    //Delete
    $element = $this->DAO->delete($id);

    //Not Found
    if(!$element)
      $this->respondNotFound();

    //Response
    $this->respondOk();
  }
}