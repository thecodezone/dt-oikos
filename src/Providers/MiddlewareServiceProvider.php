<?php

namespace DT\Oikos\Providers;

use DT\Oikos\CodeZone\Router\Middleware\DispatchController;
use DT\Oikos\CodeZone\Router\Middleware\HandleErrors;
use DT\Oikos\CodeZone\Router\Middleware\HandleRedirects;
use DT\Oikos\CodeZone\Router\Middleware\Middleware;
use DT\Oikos\CodeZone\Router\Middleware\Render;
use DT\Oikos\CodeZone\Router\Middleware\Route;
use DT\Oikos\CodeZone\Router\Middleware\Stack;
use DT\Oikos\CodeZone\Router\Middleware\UserHasCap;
use DT\Oikos\Middleware\LoggedIn;
use DT\Oikos\Middleware\LoggedOut;
use DT\Oikos\Middleware\MagicLink;
use DT\Oikos\Middleware\Nonce;

/**
 * Request middleware to be used in the request lifecycle.
 *
 * Class MiddlewareServiceProvider
 * @package DT\Oikos\Providers
 */
class MiddlewareServiceProvider extends ServiceProvider {
	protected $middleware = [
		Route::class,
		DispatchController::class,
		HandleErrors::class,
		HandleRedirects::class,
		Render::class,
	];

	protected $route_middleware = [
		'auth'  => LoggedIn::class,
		'can'   => UserHasCap::class, // can:manage_dt
		'guest' => LoggedOut::class,
		'magic' => MagicLink::class,
		'nonce' => Nonce::class,  // nonce:dt_oikos_nonce
	];

	/**
	 * Registers the middleware for the plugin.
	 *
	 * This method adds a filter to register middleware for the plugin.
	 * The middleware is added to the stack in the order it is defined above.
	 *
	 * @return void
	 */
	public function register(): void {
		add_filter( 'dt/oikos/middleware', function ( Stack $stack ) {
			$stack->push( ...$this->middleware );

			return $stack;
		} );

		add_filter( 'codezone/router/middleware', function ( array $middleware ) {
			return array_merge( $middleware, $this->route_middleware );
		} );

		/**
		 * Parse named signature to instantiate any middleware that takes arguments.
		 * Signature format: "name:signature"
		 */
		add_filter( 'codezone/router/middleware/factory', function ( Middleware|null $middleware, $attributes ) {
			$classname = $attributes['className'] ?? null;
			$name      = $attributes['name'] ?? null;
			$signature = $attributes['signature'] ?? null;

			switch ( $name ) {
				case 'magic':
					$magic_link_name       = $signature;
					$magic_link_class_name = $this->container->make( 'DT\Oikos\MagicLinks' )->get( $magic_link_name );
					if ( ! $magic_link_class_name ) {
						throw new Exception( "Magic link not found: $magic_link_name" );
					}
					$magic_link = $this->container->make( $magic_link_class_name );

					//The signature is the part of the route name after the ":". We need to break it into an array.
					$middleware = $this->container->makeWith( $classname, [
						'magic_link' => $magic_link
					] );
					break;
				case 'nonce':
					$middleware = $this->container->makeWith( $classname, [
						'nonce_name' => $signature
					] );
					break;
			}

			return $middleware;
		}, 10, 2 );
	}

	/**
	 * Do anything we need to do after the theme loads.
	 *
	 * @return void
	 */
	public function boot(): void {
	}
}
