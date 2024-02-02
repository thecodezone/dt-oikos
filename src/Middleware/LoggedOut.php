<?php

namespace DT\Oikos\Middleware;

use DT\Oikos\CodeZone\Router\Middleware\Middleware;
use DT\Oikos\Illuminate\Http\RedirectResponse;
use DT\Oikos\Illuminate\Http\Request;
use DT\Oikos\Plugin;
use DT\Oikos\Symfony\Component\HttpFoundation\Response;

class LoggedOut implements Middleware {

	public function handle( Request $request, Response $response, $next ) {
		if ( is_user_logged_in() ) {
			$response = new RedirectResponse( '/' . Plugin::HOME_ROUTE, 302 );

		}

		return $next( $request, $response );
	}
}
