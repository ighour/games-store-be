<?php

namespace App\Model;

use Exception;

class RecoverToken extends Model {
  public $id;
  public $token;
  public $email;
}