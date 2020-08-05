<?php

namespace App\Services;

use App\Repositories\PossibleDiscountRepository;
use App\Entities\Order;
use App\Repositories\CustomerRepository;
use App\Entities\Discount;
use App\Entities\FreeProductDiscount;
use App\Repositories\ProductRepository;

class DiscountService
{

	private $possibleDiscountRepository; 
	private $customerRepository;

	public function __construct(PossibleDiscountRepository $possibleDiscountRepository, CustomerRepository $customerRepository, ProductRepository $productRepository)
	{
		$this->possibleDiscountRepository = $possibleDiscountRepository;
		$this->customerRepository = $customerRepository;
		$this->productRepository = $productRepository;
	}

	/**
	 * Calculate all discounts on the given order
	 *
	 * @param Order $order
	 * @return array $discounts
	 */
	public function calculateDiscountsOnOrder(Order $order) {
		$discounts = array();
		$possibleDiscounts = $this->possibleDiscountRepository->getAllPossibleDiscounts();

		$applyCustomerDiscountOnTotal = false;
		$highestCustomerDiscountPercentage = 0;

		foreach($possibleDiscounts as $possibleDiscount) {
			switch($possibleDiscount->type) {
				case 1:
					// customer discount, apply it on total after other discounts are calculated
					// if there are multiple customer discounts, pick the highest one
					$customer = $this->customerRepository->getById($order->customerId);
					if($customer->revenue >= $possibleDiscount->amount && $possibleDiscount->percentage > $highestCustomerDiscountPercentage) {
						$applyCustomerDiscountOnTotal = $possibleDiscount;
						$highestCustomerDiscountPercentage = $possibleDiscount->percentage;
					}

					break;
				case 2: 
					// product for free discount

					// count items per product category
					$amountOfProducts = $this->countProductsInCategory($order->items, $possibleDiscount);
					

					// add exra products to order if enough items have been bought and show discount value
					foreach($amountOfProducts as $productId => $amountOfThisProduct) {
						if($amountOfThisProduct >= $possibleDiscount->minimumProductAmount) {
							$amountForFree = floor($amountOfThisProduct / $possibleDiscount->minimumProductAmount) * $possibleDiscount->amountOfFreeProducts;
							
							$product = $this->productRepository->getById($productId);
							$discount = new FreeProductDiscount($amountForFree * $product->price, $possibleDiscount->description, 2);
							$discount->setamountOfFreeProducts($amountForFree);
							$discounts[] = $discount;
							foreach($order->items as $item) {
								if($item->productId == $productId) {
									$item->quantity += $amountForFree;
								}
							}
						}
					}
					
					break;
				case 3:
					// Percentage of discount on cheapest item when you buy more than a certain amount
					$amountOfProducts = $this->countProductsInCategory($order->items, $possibleDiscount);
					$productsOfThisCategory = $this->productRepository->getProductsByCategory($possibleDiscount->productCategory);
					$cheapest = false;
					foreach($amountOfProducts as $productId => $amountOfThisProduct) {
						if($amountOfThisProduct >= $possibleDiscount->minimumProductAmount) {
							// find cheapest product
							foreach($productsOfThisCategory as $productInCategory) {
								foreach($order->items as $item) {
									if($item->productId == $productInCategory->id && (!$cheapest || $item->unitPrice <= $cheapest->unitPrice)) {
										$cheapest = $item;
									}
								}
							}
						}
					}

					if($cheapest) {
						$discount = new Discount(round($cheapest->unitPrice * $possibleDiscount->percentage / 100, 2) * $cheapest->quantity, $possibleDiscount->description, 3);
						$discounts[] = $discount;

						$order->total -= $discount->amount;
					}

					break;
			}
		}

		// handle customer discount on the total's order after other discounts were applied
		if($applyCustomerDiscountOnTotal && $highestCustomerDiscountPercentage) {
			$discount = new Discount(round($order->total * $applyCustomerDiscountOnTotal->percentage / 100, 2), $applyCustomerDiscountOnTotal->description, 1);
			$discounts[] = $discount;
			$order->total -= $discount->amount;
		}

		$order->discounts = $discounts;
		return $order;
	}

	private function countProductsInCategory($items, $possibleDiscount) {
		$amountOfProducts = array();
		foreach($items as $item) {
			$product = $this->productRepository->getById($item->productId);
			if($product->category == $possibleDiscount->productCategory) {
				if (!isset($amountOfProducts[$product->id])) {
					$amountOfProducts[$product->id] = 0;
				}
				$amountOfProducts[$product->id] += $item->quantity;
			}
		}

		return $amountOfProducts;
	}
}
