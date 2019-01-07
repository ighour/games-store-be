<?php

namespace App\DAO;

use Exception;
use App\Config\DatabaseConnection;
use App\Model\ItemCategory as ItemCategoryModel;

class ItemCategory extends DAO {
  /**
   * Constructor
   */
  public function __construct(){
    $this->table = 'item_categories';
    $this->model = ItemCategoryModel::class;
  }
}