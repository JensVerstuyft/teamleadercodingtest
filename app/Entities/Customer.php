<?php

namespace App\Entities;

class Customer {
  
	public $id;
	public $name;
	public $since;
	public $revenue;

	public function __construct($id, $name, $since, $revenue) {
		$this->id = intval($id);
		$this->name = $name;
		$this->since = $since;
		$this->revenue = $revenue;

		$this->since = date("Y-m-d", strtotime($this->since));
	}

}
