<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Services\DiscountService;

use App\Repositories\PossibleDiscountRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\ProductRepository;

class DiscountController extends Controller
{
	private $discountService;


	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(OrderService $orderService, DiscountService $discountService)
	{
		parent::__construct();
		$this->discountService = new DiscountService(new PossibleDiscountRepository(), new CustomerRepository(), new ProductRepository());
		$this->orderService = new OrderService();
	}

	/**
	 * Calculate the discounts on an order
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function calculate(Request $request) {
		$order = $request->input('order');

		try {
			$order = $this->orderService->convertJSONToOrder($order);
			$order = $this->discountService->calculateDiscountsOnOrder($order);
			$discounts = $this->formatDiscountData($order->discounts);
			unset($order->discounts);
			$this->response['data']['order'] = $order;
			$this->response['data']['discounts'] = $discounts;
			return $this->output($this->response);
		} catch(\Exception $e) {
			$this->response['error'] = $e->getMessage();
			$this->response['status'] = 500;
			return $this->output($this->response);
		}
	}

	/**
	 * Format the discounts in an human readible way.
	 *
	 * @param  array $discounts
	 * @return array
	 */
	private function formatDiscountData($discounts) {
		$allDiscountInformationForUser = array();
		foreach($discounts as $discount) {
			$discountInformationForUser = array('Amount of the discount' => $discount->amount, 'Reason for the discount' => $discount->description);
			if(isset($discount->amountOfFreeProducts)) {
				$discountInformationForUser['Free items added because of this discount'] = $discount->amountOfFreeProducts;
			}

			$allDiscountInformationForUser[] = $discountInformationForUser;
		}

		return $allDiscountInformationForUser;
	}
}
