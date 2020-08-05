<?php

namespace App\Entities;

class Discount {
  
	public $amount;
	public $description;
	public $type;

	public function __construct($amount, $description, $type) {
		$this->amount = $amount;
		$this->description = $description;
		$this->type = $type;
	}

}