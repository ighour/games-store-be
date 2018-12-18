<?php

require_once(__DIR__ . '/../app/bootstrap.php');

use App\FrontController;

$app = new FrontController();
$app->run();