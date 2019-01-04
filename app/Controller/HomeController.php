<?php

namespace App\Controller;

use \App\DAO\User;

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
      echo "ID: " . $user->id . "<br/>";
      echo "Username: " . $user->username . "<br/>";
      echo "Email: " . $user->email . "<br/>";
      echo "Password: " . $user->password . "<br/>";
      echo "Role: " . $user->role . "<br/>";
      echo "</br>";
    }
  }
}