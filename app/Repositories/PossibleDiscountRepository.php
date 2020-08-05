<?php

namespace App\Repositories;

use App\Entities\PossibleDiscount;

class PossibleDiscountRepository {

  public function __construct() {

  }

	/**
	* Get all possible discounts
	* Normally this would be fetched from database or external service/file
	*
	* @return array
	*/
	public function getAllPossibleDiscounts() {
		// discount with type 1 => customer purchase limit => set percentage and minimum purchase amount
		$discount1 = new PossibleDiscount(1, "A customer who has already bought for over €1000, gets a discount of 10% on the whole order.", 10, 1000, null, null, null);

		// discount with type 2 => free product => set product type, minimum purchase amount and amount of free products
		$discount2 = new PossibleDiscount(2, "For every product of category Switches (id 2), when you buy five, you get a sixth for free.", null, null, 2, 5, 1);

		// discount with type 3 => percent on product discount => set percentage, product type, and minimum purchase amount
		$discount3 = new PossibleDiscount(3, "If you buy two or more products of category Tools (id 1), you get a 20% discount on the cheapest product.", 20, null, 1, 2, null);

		return array($discount1, $discount2, $discount3);
	}

}