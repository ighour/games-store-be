<?php

namespace App\Sanitization;

class User extends Sanitization {
  /**
   * Sanitize
   */
  public function sanitize()
  {
    //Username
    $this->string('username', 'FILTER_FLAG_STRIP_HIGH');

    //Email
    $this->email('email');

    //Role
    $this->string('role', 'FILTER_FLAG_STRIP_HIGH');

    //User Id
    $this->integer('user_id');

    //Avatar
    $this->image('avatar', 'avatars');

    //Remove Avatar
    $this->boolean('remove_avatar');

    //Return sanitized request params
    return $this->request;
  }
}