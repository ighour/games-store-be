<?php

namespace App\Resource;

abstract class Resource {
  abstract function element($element);

  public function collection(array $elements)
  {
    return array_map(function($element){
      return $this->element($element);
    }, $elements);
  }
}