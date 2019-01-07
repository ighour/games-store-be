<?php

namespace App\DAO;

use Exception;
use App\Config\DatabaseConnection;
use App\Model\Item as ItemModel;

class Item extends DAO {
  /**
   * Constructor
   */
  public function __construct(){
    $this->table = 'items';
    $this->model = ItemModel::class;
  }
}