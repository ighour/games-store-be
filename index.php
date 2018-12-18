<?php

define('__ROOT__', __DIR__);

require_once(__ROOT__.'/config/db.php');

try{
  $DB = new DatabaseConnection();
  $conn = $DB->connect();
}
catch(Exception $exception){
  die();
}

$stmt = $conn->query('SELECT * FROM users');

while ($row = $stmt->fetch())
{
  echo $row['email'];
  echo '</br>';
}