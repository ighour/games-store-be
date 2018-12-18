<?php

require_once(__DIR__ . '/app/bootstrap.php');

try{
  $DB = new \App\Config\DatabaseConnection();
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