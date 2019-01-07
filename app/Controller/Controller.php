<?php

namespace App\Controller;

abstract class Controller {
  /**
   * Response http code
   */
  private $code;

  /**
   * Response message
   */
  private $message;

  /**
   * Response payload
   */
  private $payload;

  /**
   * Model DAO
   */
  protected $DAO;

  /**
   * Model Resource
   */
  protected $resource;

  /**
   * Request
   */
  protected $request;

  /**
   * Request validation
   */
  protected $validation;

  /**
   * JWT (decoded + encoded)
   */
  public $jwt;

  /**
   * Code Messages
   */
  private $CODES = [
    '200' => "OK",
    '201' => "Created",
    '400' => "Bad Request",
    '403' => "Forbidden",
    '404' => "Not Found",
    '500' => "Internal Server Error"
  ];

  /**
   * Constructor
   */
  public function __construct($request = null)
  {
    if(!is_null($request))
      $this->request = $request;
  }

  /**
   * Get auth id
   */
  protected function getAuthId()
  {
    try {
      $id = $this->jwt['decoded']->pay->id;
    }
    catch(Exception $e){
      return null;
    }

    return $id;
  }

  /**
   * Get auth encoded token
   */
  protected function getEncodedJWT()
  {
    try {
      $jwt = $this->jwt['encoded'];
    }
    catch(Exception $e){
      return null;
    }

    return $jwt;
  }

  /**
   * Provided user id is the same as auth
   */
  protected function isAuth($userId)
  {
    $auth = $this->getAuthId();

    return !is_null($auth) && $auth == $userId;
  }

  /**
   * Check if is owner of resource
   */
  protected function isOwner($id, $relation='user_id')
  {
    $element = $this->DAO->fetchById($id);

    if(!$element || !isset($element->$relation) || $element->$relation != $element->id)
      return false;

    return true;
  }

  /**
   * Filter request parameters
   */
  protected function params($params)
  {
    $result = [];

    foreach($params as $param){
      if(isset($this->request[$param]))
        $result[$param] = $this->request[$param];
    }

    return $result;
  } 

  /**
   * Set response http code
   */
  private function withCode($code)
  {
    $this->code = $code;

    return $this;
  }

  /**
   * Set response message
   */
  private function withMessage($message)
  {
    $this->message = $message;

    return $this;
  }

  /**
   * Set response payload
   */
  protected function withPayload(array $payload)
  {
    $this->payload = $payload;

    return $this;
  }

  /**
   * JSON Respond
   */
  private function respond()
  {
    //Set status code
    http_response_code($this->code);

    //Set response
    $response = [
      'code' => $this->code,
      'message' => !is_null($this->message) ? $this->message : $this->CODES[$this->code]
    ];

    //Set payload
    if(!is_null($this->payload))
      $response['payload'] = $this->payload;

    //Respond
    echo json_encode($response);

    die();
  }

  /**
   * Respond OK (200)
   */
  public function respondOk($message = null)
  {
    $this->withCode(200)->withMessage($message)->respond();
  }

  /**
   * Respond Created (201)
   */
  public function respondCreated($message = null)
  {
    $this->withCode(201)->withMessage($message)->respond();
  }

  /**
   * Respond Bad Request (400)
   */
  public function respondBadRequest($message = null)
  {
    $this->withCode(400)->withMessage($message)->respond();
  }

  /**
   * Respond Forbidden (403)
   */
  public function respondForbidden($message = null)
  {
    $this->withCode(403)->withMessage($message)->respond();
  }

  /**
   * Respond Not Found (404)
   */
  public function respondNotFound($message = null)
  {
    $this->withCode(404)->withMessage($message)->respond();
  }

  /**
   * Respond Internal Server Error (500)
   */
  public function respondInternalServerError($message = null)
  {
    $this->withCode(500)->withMessage($message)->respond();
  }

  /**
   * Respond Custom Validation Error
   */
  public function respondValidationError()
  {
    $this->withCode(400)->withMessage("FORM_VALIDATION_ERROR")->respond();
  }
}