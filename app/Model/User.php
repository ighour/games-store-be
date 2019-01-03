<?php

namespace App\Model;

use Exception;

class User extends Model {
  public $id;
  public $username;
  public $email;
  public $password;
  public $role;
}