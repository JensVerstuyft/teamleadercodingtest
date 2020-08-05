<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public $response;

    public function __construct() {
    	// added fix for serialize precision bug on local machine: https://stackoverflow.com/questions/42981409/php7-1-json-encode-float-issue/43056278
    	ini_set('serialize_precision', 14); ini_set('precision', 14);

    	$this->response = array('status' => 200, 'data' => array(), 'error' => '');
    }

	protected function output($data) {
        return response()->json($data);
	}
}
