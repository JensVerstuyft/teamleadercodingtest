<?php

namespace App\Entities;

class Item {
  
	public $productId;
	public $quantity;
	public $unitPrice;
	public $total;

	public function __construct($productId, $quantity, $unitPrice, $total) {
		$this->productId = $productId;
		$this->quantity = intval($quantity);
		$this->unitPrice = floatval($unitPrice);
		$this->total = floatval($total);
	}

}
