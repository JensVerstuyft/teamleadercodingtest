<?php

namespace App\Entities;

class PossibleDiscount {

	public $type;
	public $description;
	public $percentage;
	public $amount;
	public $productCategory;
	public $minimumProductAmount;
	public $amountOfFreeProducts;

	public function __construct($type, $description, $percentage = null, $amount = null, $productCategory = null, $minimumProductAmount = null, $amountOfFreeProducts = null) {
		$this->type = $type;
		$this->description = $description;
		$this->percentage = $percentage;
		$this->amount = $amount;
		$this->productCategory = $productCategory;
		$this->minimumProductAmount = $minimumProductAmount;
		$this->amountOfFreeProducts = $amountOfFreeProducts;
	}

}