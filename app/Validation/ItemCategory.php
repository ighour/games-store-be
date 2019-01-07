<?php

namespace App\Validation;

use \App\DAO\ItemCategory as ItemCategoryDAO;

class ItemCategory extends Validation {
   /**
   * Constructor
   */
  public function __construct($request)
  {
    parent::__construct($request);

    $this->DAOS['item_category'] = new ItemCategoryDAO();
  }

  /**
   * Validate Create
   */
  public function create()
  {
    //Name
    $name = $this->checkRequired('name');
    if($name){
      $this->checkString('name');
      $this->checkBetween('name', 1, 255);
      $this->checkUnique('name', $this->DAOS['item_category']->fetchByWhere(['name' => $this->request['name']], 'name = :name'));
    }
  }

  /**
   * Validate Update
   */
  public function update()
  {
    //Name
    $name = $this->isPresent('name');
    if($name){
      $this->checkRequired('name');
      $this->checkString('name');
      $this->checkBetween('name', 1, 255);
      $this->checkUnique('name', $this->DAOS['item_category']->fetchByWhere(['name' => $this->request['name']], 'name = :name'));
    }
  }
}