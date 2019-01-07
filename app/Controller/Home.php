<?php

namespace App\Controller;

class Home extends Controller {
  public function index(){
    return $this->respondOk("Server is alive!");
  }
}