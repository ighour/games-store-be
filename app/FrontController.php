<?php

namespace App;

class FrontController {
  protected $url;

  protected $routes = [
    ['route' => '/', 'controller' => 'HomeController', 'action' => 'index']
  ];

  public function __construct(){
    $this->url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
  }

  public function run(){
    $url = $this->url;

    array_walk($this->routes, function($route) use($url){
      //Valid route
      if($url == $route['route'] || $url == $route['route'] . '/'){
        $className = "App\\Controller\\" . $route['controller'];
        $controller = new $className();        
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
