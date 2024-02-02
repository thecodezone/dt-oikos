<?php

namespace DT\Oikos\Middleware;

use DT\Oikos\CodeZone\Router\Middleware\Middleware;
use DT\Oikos\Illuminate\Http\RedirectResponse;
use DT\Oikos\Illuminate\Http\Request;
use DT\Oikos\Symfony\Component\HttpFoundation\Response;

class LoggedIn implements Middleware {
	public function handle( Request $request, Response $response, $next ) {
		if ( ! is_user_logged_in() ) {
			$response = new RedirectResponse( wp_login_url( $request->getUri() ), 302 );
		}

		return $next( $request, $response );
	}
}