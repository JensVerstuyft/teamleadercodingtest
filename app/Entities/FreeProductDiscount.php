<?php

namespace App\Entities;

class FreeProductDiscount extends Discount {
  
	public $amountOfFreeProducts;

	public function setamountOfFreeProducts($amount) {
		$this->amountOfFreeProducts = $amount;
	}

}