<?php

namespace App\Services;

use App\Entities\Order;

class OrderService
{

	public function __construct()
	{
		//
	}

	/**
	* Convert the json input to actual orders
	*
	* @param String $order
	* @return Order
	*/
	public function convertJSONToOrder($order) {
		$order = json_decode($order);

		if(!$order) {
			throw new \Exception("Invalid JSON provided");
		}

		try {
			$order = new Order($order->id, $order->{'customer-id'}, $order->items, $order->total);
		} catch(\Exception $e) {
			throw new \Exception("Invalid order data provided");
		}
		
		return $order;
	}
}
