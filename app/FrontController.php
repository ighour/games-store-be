<?php

namespace App;

class FrontController {
  protected $url;
  protected $method;
  protected $params;

  protected $routes = [
    ['method' => 'GET',   'route' => '/',                 'controller' => 'HomeController',     'action' => 'index'],
    ['method' => 'GET',   'route' => '/users',            'controller' => 'UserController',     'action' => 'index']
  ];

  public function __construct(){
    $this->url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $this->method = $_SERVER['REQUEST_METHOD'];
    $this->params = $_REQUEST;
  }

  public function run(){
    array_walk($this->routes, function($route){

      //Valid route
      if($this->method = $route['method'] && ($this->url == $route['route'] || $this->url == $route['route'] . '/')){
        $className = "App\\Controller\\" . $route['controller'];
        $controller = new $className($this->params);        
        $method = $route['action'];
        $controller->$method();
        die();
      }

    });

    //Invalid route
    echo 'INVALID_ROUTE';
    die();
  }
}
