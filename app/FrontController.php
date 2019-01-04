<?php

namespace App;

use \App\Controller\Controller;
use \App\Helpers\Helpers;

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
  protected $routes = [
    ['method' => 'GET',   'route' => '/',                     'controller' => 'HomeController',     'action' => 'index'],

    ['method' => 'GET',   'route' => '/users',                'controller' => 'UserController',     'action' => 'index'],
    ['method' => 'POST',  'route' => '/users',                'controller' => 'UserController',     'action' => 'create'],
    ['method' => 'GET',   'route' => '/users/:user_id',       'controller' => 'UserController',     'action' => 'show'],
    ['method' => 'PUT',   'route' => '/users/:user_id/edit',  'controller' => 'UserController',     'action' => 'update'],
  ];

  /**
   * Constructor
   */
  public function __construct(){
    $this->url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
  }

  /**
   * Redirect to proper controller
   */
  public function run(){
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
    $this->respondNotFound();
  }

  /**
   * Get request parameters
   */
  private function getParams()
  {
    //GET and POST
    if($_SERVER['REQUEST_METHOD'] == "GET" || $_SERVER['REQUEST_METHOD'] == "POST")
      return $_REQUEST;

    //OTHERS
    $contents = file_get_contents("php://input");

    parse_str($contents, $params);

    return $params;    
  }
}
