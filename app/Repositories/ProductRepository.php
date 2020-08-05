<?php

namespace App\Repositories;

use App\Entities\Product;

class ProductRepository {

  public function __construct() {

  }

	/**
	* Get all products
	* Normally this would be fetched from database or external service/file
	*
	* @return array
	*/
	public function getAllProducts() {
		$json = '[
				  {
				    "id": "A101",
				    "description": "Screwdriver",
				    "category": "1",
				    "price": "9.75"
				  },
				  {
				    "id": "A102",
				    "description": "Electric screwdriver",
				    "category": "1",
				    "price": "49.50"
				  },
				  {
				    "id": "B101",
				    "description": "Basic on-off switch",
				    "category": "2",
				    "price": "4.99"
				  },
				  {
				    "id": "B102",
				    "description": "Press button",
				    "category": "2",
				    "price": "4.99"
				  },
				  {
				    "id": "B103",
				    "description": "Switch with motion detector",
				    "category": "2",
				    "price": "12.95"
				  }
				]';

		$jsonproducts = json_decode($json);

		$products = array();
		foreach($jsonproducts as $jsonproduct) {
			$products[$jsonproduct->id] = new Product($jsonproduct->id, $jsonproduct->description, $jsonproduct->category, $jsonproduct->price);
		}

		return $products;
	}

	/**
	* Get product by id
	* Normally this would be fetched from database or external service/file
	*
	* @return Product
	*/
	public function getById($id) {
		$products = $this->getAllProducts();

		if(isset($products[$id])) {
			return $products[$id];
		} else {
			throw new \Exception("Product not found");
		}
	}

	/**
	* Get products of a category
	* Normally this would be fetched from database or external service/file
	*
	* @return array
	*/
	public function getProductsByCategory($categoryId) {
		$products = $this->getAllProducts();

		$productsInCategory = array();
		foreach($products as $product) {
			if($product->category == $categoryId) {
				$productsInCategory[] = $product;
			}
		}

		return $productsInCategory;
	}

}