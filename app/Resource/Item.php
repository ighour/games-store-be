<?php

namespace App\Resource;

use \App\DAO\User as UserDAO;

class Item extends Resource {
  public function element($element)
  {
    $dao = new UserDAO();
    $user = $dao->fetchById($element->user_id);

    return [
      'id' => (int) $element->id,
      'name' => $element->name,
      'type' => $element->type,
      'description' => $element->description,
      'amount' => (double) $element->amount,
      'item_category_id' => (int) $element->item_category_id,
      'user_id' => (int) $element->user_id,
      'image' => is_null($element->image) ? null : 'storage/games/' . $element->image,
      'relation_user' => !is_null($user) ? $user->email : 'Not Provided'
    ];
  }
}