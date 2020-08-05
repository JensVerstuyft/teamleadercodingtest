<?php

namespace App\Repositories;

use App\Entities\Customer;

class CustomerRepository {

  public function __construct() {

  }

	/**
	* Get all customers
	* Normally this would be fetched from database or external service/file
	*
	* @return array
	*/
	public function getAllCustomers() {
		$json = '[
				  {
				    "id": "1",
				    "name": "Coca Cola",
				    "since": "2014-06-28",
				    "revenue": "492.12"
				  },
				  {
				    "id": "2",
				    "name": "Teamleader",
				    "since": "2015-01-15",
				    "revenue": "1505.95"
				  },
				  {
				    "id": "3",
				    "name": "Jeroen De Wit",
				    "since": "2016-02-11",
				    "revenue": "0.00"
				  }
				]';
		$jsoncustomers = json_decode($json);

		$customers = array();
		foreach($jsoncustomers as $jsoncustomer) {
			$customers[$jsoncustomer->id] = new Customer($jsoncustomer->id, $jsoncustomer->name, $jsoncustomer->since, $jsoncustomer->revenue);
		}

		return $customers;
	}

	public function getById($id) {
		$customers = $this->getAllCustomers();

		if(isset($customers[$id])) {
			return $customers[$id];
		} else {
			throw new \Exception("Customer not found");
		}
	}

}