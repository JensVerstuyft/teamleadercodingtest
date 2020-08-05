<?php

namespace App\Entities;

class Product {
  
	public $id;
	public $description;
	public $category;
	public $price;

	public function __construct($id, $description, $category, $price) {
		$this->id = $id;
		$this->description = $description;
		$this->category = intval($category);
		$this->price = floatval($price);
	}

}