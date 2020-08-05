<?php

namespace App\Entities;

use App\Entities\Item;

class Order {
  
	public $id;
	public $customerId;
	public $items;
	public $total;

	public function __construct($id, $customerId, $items, $total) {
		$this->id = intval($id);
		$this->customerId = intval($customerId);
		$this->items = $items;
		$this->total = floatval($total);

		foreach($this->items as &$item) {
			$item = new Item($item->{'product-id'}, $item->quantity, $item->{'unit-price'}, $item->total);
		}
	}

}