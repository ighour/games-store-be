<?php

namespace App\Controller;

use \App\Model\User;

class HomeController {
  public function index(){
    try{
      $userDAO = new User();
      $users = $userDAO->fetchAll();
    }
    catch(Exception $exception){
      die();
    }
    
    foreach($users as $user){
      echo $user['username'];
      echo "<br/>";
    }
  }
}