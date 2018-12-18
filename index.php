<?php

require_once(__DIR__ . '/app/bootstrap.php');

try{
  $userDAO = new \App\Model\User();
  $users = $userDAO->fetchAll();
}
catch(Exception $exception){
  die();
}

foreach($users as $user){
  echo $user['username'];
  echo "<br/>";
}