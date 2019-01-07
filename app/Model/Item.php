<?php

namespace App\Model;

class Item extends Model {
  public $id;
  public $name;
  public $type;
  public $description;
  public $amount;
  public $item_category_id;
  public $user_id;
}