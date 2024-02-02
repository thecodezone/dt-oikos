<?php

namespace DT\Oikos\Controllers;

use DT\Oikos\Illuminate\Http\Request;
use DT\Oikos\Illuminate\Http\Response;
use DT_Magic_URL;
use function DT\Oikos\template;

class AppController {

	/**
	 * Index method.
	 *
	 * This method is responsible for handling the index route and generating the output.
	 *
	 * @param Request $request The request object.
	 * @param Response $response The response object.
	 * @param mixed $key The key parameter.
	 *
	 * @return mixed  The generated output.
	 */
	public function index( Request $request, Response $response, $key ) {
		$user        = wp_get_current_user();

		return template( 'index', compact(
			'user'
		) );
	}
}
