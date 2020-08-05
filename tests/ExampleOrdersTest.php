<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Laravel\Lumen\Testing\WithoutMiddleware;

class ExampleOrdersTest extends TestCase
{
	use WithoutMiddleware;

	/**
	 * Test with example data of order 1
	 *
	 * @return void
	 */
	public function testOrder1()
	{
		$response = $this->post("discount/calculate", array('order' => 
			'{
			  "id": "1",
			  "customer-id": "1",
			  "items": [
				{
				  "product-id": "B102",
				  "quantity": "10",
				  "unit-price": "4.99",
				  "total": "49.90"
				}
			  ],
			  "total": "49.90"
			}'));

		$this->assertEquals(
			json_encode(
				array(
					'status' => 200,
					'data' => array(
						'order' => array(
							'id' => 1, 
							'customerId' => 1,
							'items' => array(
								array(
									'productId' => 'B102',
									'quantity' => 12,
									'unitPrice' => 4.99,
									'total' => 49.9
								)
							),
							'total' => 49.9
						),
						'discounts' => array(
							array(
								'Amount of the discount' => 9.98,
								'Reason for the discount' => 'For every product of category Switches (id 2), when you buy five, you get a sixth for free.',
								'Free items added because of this discount' => 2
							)
						)
					),
					'error' => ''
				), 
				JSON_NUMERIC_CHECK
			),
			$this->response->content()
		);
	}

	/**
	 *  Test with example data of order 2
	 *
	 * @return void
	 */
	public function testOrder2()
	{
		$response = $this->post("discount/calculate", array('order' => 
			'{
			  "id": "2",
			  "customer-id": "2",
			  "items": [
			    {
			      "product-id": "B102",
			      "quantity": "5",
			      "unit-price": "4.99",
			      "total": "24.95"
			    }
			  ],
			  "total": "24.95"
			}'));

		$this->assertEquals(
			json_encode(
				array(
					'status' => 200,
					'data' => array(
						'order' => array(
							'id' => 2, 
							'customerId' => 2,
							'items' => array(
								array(
									'productId' => 'B102',
									'quantity' => 6,
									'unitPrice' => 4.99,
									'total' => 24.95
								)
							),
							'total' => 22.45
						),
						'discounts' => array(
							array(
								'Amount of the discount' => 4.99,
								'Reason for the discount' => 'For every product of category Switches (id 2), when you buy five, you get a sixth for free.',
								'Free items added because of this discount' => 1
							),
							array(
								'Amount of the discount' => 2.5,
								'Reason for the discount' => 'A customer who has already bought for over €1000, gets a discount of 10% on the whole order.'
							)
						)
					),
					'error' => ''
				), 
				JSON_NUMERIC_CHECK
			),
			$this->response->content()
		);
	}

	/**
	 *  Test with example data of order 3
	 *
	 * @return void
	 */
	public function testOrder3()
	{
		$response = $this->post("discount/calculate", array('order' => 
			'{
			  "id": "3",
			  "customer-id": "3",
			  "items": [
			    {
			      "product-id": "A101",
			      "quantity": "2",
			      "unit-price": "9.75",
			      "total": "19.50"
			    },
			    {
			      "product-id": "A102",
			      "quantity": "1",
			      "unit-price": "49.50",
			      "total": "49.50"
			    }
			  ],
			  "total": "69.00"
			}'));

		$this->assertEquals(
			json_encode(
				array(
					'status' => 200,
					'data' => array(
						'order' => array(
							'id' => 3, 
							'customerId' => 3,
							'items' => array(
								array(
									'productId' => 'A101',
									'quantity' => 2,
									'unitPrice' => 9.75,
									'total' => 19.5
								),
								array(
									'productId' => 'A102',
									'quantity' => 1,
									'unitPrice' => 49.5,
									'total' => 49.5
								)
							),
							'total' => 65.1
						),
						'discounts' => array(
							array(
								'Amount of the discount' => 3.9,
								'Reason for the discount' => 'If you buy two or more products of category Tools (id 1), you get a 20% discount on the cheapest product.',
							)
						)
					),
					'error' => ''
				), 
				JSON_NUMERIC_CHECK
			),
			$this->response->content()
		);
	}
}