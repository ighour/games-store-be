<?php

namespace App\Resource;

class ItemCategory extends Resource {
  public function element($element)
  {
    return [
      'id' => (int) $element->id,
      'name' => $element->name
    ];
  }
}