<?php

namespace App\Resource;

class Item extends Resource {
  public function element($element)
  {
    return [
      'id' => (int) $element->id,
      'name' => $element->name,
      'type' => $element->type,
      'description' => $element->description,
      'amount' => (double) $element->amount,
      'item_category_id' => (int) $element->item_category_id,
      'user_id' => (int) $element->user_id,
      'image' => is_null($element->image) ? null : __SERVER__ . '/storage' . '/games' . '/' . $element->image
    ];
  }
}