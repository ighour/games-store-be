<?php

namespace App\Validation;

use \App\DAO\ItemCategory as ItemCategoryDAO;
use \App\DAO\User as UserDAO;

class Item extends Validation {
   /**
   * Constructor
   */
  public function __construct($request)
  {
    parent::__construct($request);

    $this->DAOS['item_category'] = new ItemCategoryDAO();
    $this->DAOS['user'] = new UserDAO();
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
    }

    //Type
    $type = $this->checkRequired('type');
    if($type){
      $this->checkString('type');
      $this->checkIn('type', ['new', 'used']);
    }

    //Description
    $description = $this->isPresent('description');
    if($description){
      $this->checkRequired('description');
      $this->checkString('description');
      $this->checkBetween('description', 1, 255);
    }

    //Amount
    $amount = $this->checkRequired('amount');
    if($amount){
      $this->checkDouble('amount', 2);
      $this->checkBetween('amount', 0, 9999999.99);  //0 -> 9,999,999.99
    }

    //Item Category Id
    $itemCategoryId = $this->checkRequired('item_category_id');
    if($itemCategoryId){
      $this->checkInteger('item_category_id');
      $this->checkExists('item_category_id', $this->DAOS['item_category']->fetchById($this->request['item_category_id']));
    }

    //Image (Sanitized as String, false -> remove)
    $image = $this->isPresent('image');
    if($image){
      $isBool = $this->isBoolean('image');
      if(!$isBool){
        $this->checkString('image');
        $this->checkImageDimension('image', 'games', 300, 200);
      }
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
    }

    //Type
    $type = $this->isPresent('type');
    if($type){
      $this->checkRequired('type');
      $this->checkString('type');
      $this->checkIn('type', ['new', 'used']);
    }

    //Description
    $description = $this->isPresent('description');
    if($description){
      $this->checkRequired('description');
      $this->checkString('description');
      $this->checkBetween('description', 1, 255);
    }

    //Amount
    $amount = $this->isPresent('amount');
    if($amount){
      $this->checkRequired('amount');
      $this->checkDouble('amount', 2);
      $this->checkBetween('amount', 0, 9999999.99);  //0 -> 9,999,999.99
    }

    //Item Category Id
    $itemCategoryId = $this->isPresent('itemCategoryId');
    if($itemCategoryId){
      $this->checkRequired('item_category_id');
      $this->checkInteger('item_category_id');
      $this->checkExists('item_category_id', $this->DAOS['item_category']->fetchById($this->request['item_category_id']));
    }

    //Image (Sanitized as String, false -> remove)
    $image = $this->isPresent('image');
    if($image){
      $isBool = $this->isBoolean('image');
      if(!$isBool){
        $this->checkString('image');
        $this->checkImageDimension('image', 'games', 300, 200);
      }
    }
  }
}