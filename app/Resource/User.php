<?php

namespace App\Resource;

class User extends Resource {
  public function element($user)
  {
    return [
      'id' => $user->id,
      'username' => $user->username,
      'email' => $user->email,
      'role' => is_null($user->role) ? '_default' : $user->role
    ];
  }
}