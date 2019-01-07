<?php

namespace App;

use \App\Controller\Controller;
use \App\Libs\Helpers;
use \App\Middleware\CORS;

class FrontController extends Controller {
  /**
   * Request URL
   */
  protected $url;

  /**
   * Request Method
   */
  protected $method;

  /**
   * Request Parameters
   */
  protected $params;

  /**
   * App Routes
   */
  protected $routes = [];

  /**
   * Constructor
   */
  public function __construct(){
    $this->url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    //Set Routes
    $this->setRoute(['method' => 'GET', 'route' => '/', 'controller' => 'Home', 'action' => 'index'])
          ->setRoute(['method' => 'POST', 'route' => '/login', 'controller' => 'Auth', 'action' => 'login'])
          ->setRoute(['method' => 'POST', 'route' => '/logout', 'controller' => 'Auth', 'action' => 'logout'])
          ->setRoute(['method' => 'POST', 'route' => '/forget', 'controller' => 'Auth', 'action' => 'forget'])
          ->setRoute(['method' => 'POST', 'route' => '/recover', 'controller' => 'Auth', 'action' => 'recover'])
          ->setResourceRoute('users', 'user_id', 'UserController');
  }

  /**
   * Redirect to proper controller
   */
  public function run(){
    //Run CORS
    CORS::run();

    $urlSegments = explode("?", $this->url);
    $urlPath = explode("/", $urlSegments[0]);
    $method = $_SERVER['REQUEST_METHOD'];

    for($i = 0; $i < sizeof($this->routes); $i++){
      $route = $this->routes[$i];

      //Set path params
      $pathParams = [];

      //Not same method
      if($route['method'] != $method)
        continue;

      //Generate route array
      $routePath = explode("/", $route['route']);

      //Request and route not same length
      if(sizeof($urlPath) != sizeOf($routePath))
        continue;

      //Check route
      for($j = 0; $j < sizeof($urlPath); $j++){
        $abort = false;

        //Does not have path
        if(!isset($routePath[$j])){
          $abort = true;
          break;
        }

        //Get current path segment
        $path = $routePath[$j];

        //Is parameter
        if(Helpers::startsWith($path, ":")){
          //Request is not parameter
          if(!is_numeric($urlPath[$j])){
            $abort = true;
            break;
          }

          //Save parameter
          $pathParams[substr($path, 1)] = $urlPath[$j];
        }

        //Path is different
        else if($path !== $urlPath[$j]){
          $abort = true;
          break;
        }
      }

      //Invalid request
      if($abort)
        continue;

      //Set params
      $params = array_merge($this->getParams(), $pathParams);

      //Redirect to controller
      $className = "App\\Controller\\" . $route['controller'];
      $controller = new $className($params);        
      $method = $route['action'];
      $controller->$method();
      die();
    }

    //Invalid route
    http_response_code(404);
    $this->respondNotFound();
  }

  /**
   * Get request parameters
   */
  private function getParams()
  {
    $method = $_SERVER['REQUEST_METHOD'];

    //GET
    if($method == "GET")
      return $_GET;

    //POST (application/x-www-form-urlencoded)
    else if($method == "POST" && sizeof($_POST) > 0){
      return $_POST;
    }

    //OTHERS
    $contents = file_get_contents("php://input");

    if(strlen($contents) == 0 || $contents == null)
      return [];

    return json_decode(urldecode($contents), true);    
  }

  /**
   * Set route
   */
  private function setRoute(array $route)
  {
    $this->routes[] = $route;

    return $this;
  }

  /**
   * Generate resourcefull CRUD routes
   */
  private function setResourceRoute($resource, $id, $controller, $crud=['index', 'create', 'show', 'update', 'delete'])
  {
    if(in_array('index', $crud))
      $this->setRoute(['method' => 'GET',   'route' => "/{$resource}",              'controller' => $controller,     'action' => 'index']);

    if(in_array('create', $crud))
      $this->setRoute(['method' => 'POST',  'route' => "/{$resource}",              'controller' => $controller,     'action' => 'create']);

    if(in_array('show', $crud))
      $this->setRoute(['method' => 'GET',   'route' => "/{$resource}/:{$id}",       'controller' => $controller,     'action' => 'show']);

    if(in_array('update', $crud))
      $this->setRoute(['method' => 'PUT',   'route' => "/{$resource}/:{$id}/edit",  'controller' => $controller,     'action' => 'update']);
    
    if(in_array('delete', $crud))
      $this->setRoute(['method' => 'DELETE','route' => "/{$resource}/:{$id}",       'controller' => $controller,     'action' => 'delete']);

    return $this;
  }
}
