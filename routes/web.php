<?php
/**
 * Conditions are used to determine if a group of routes should be registered.
 *
 * Groups are used to register a group of routes with a common URL prefix.
 *
 * Middleware is used to modify requests before they are handled by a controller, or to modify responses before they are returned to the client.
 *
 * Routes are used to bind a URL to a controller.
 *
 * @var Routes $r
 * @see https://github.com/thecodezone/wp-router
 */

use DT\Oikos\CodeZone\Router\FastRoute\Routes;
use DT\Oikos\Controllers\Admin\GeneralSettingsController;
use DT\Oikos\Controllers\HelloController;
use DT\Oikos\Controllers\AppController;
use DT\Oikos\Controllers\RedirectController;
use DT\Oikos\Controllers\StarterMagicLink\SubpageController;
use DT\Oikos\Controllers\UserController;
use DT\Oikos\Illuminate\Http\Request;
use DT\Oikos\Symfony\Component\HttpFoundation\Response;


$r->condition( 'plugin', function ( $r ) {
	$r->get( 'oikos', [ RedirectController::class, 'show', [ 'middleware' => 'auth' ] ] );

	$r->group( 'oikos', function ( Routes $r ) {
        //      $r->get( '/hello', [ HelloController::class, 'show' ] );
        //      $r->get( '/users/{id}', [ UserController::class, 'show', [ 'middleware' => [ 'auth', 'can:list_users' ] ] ] );
        //      $r->get( '/me', [ UserController::class, 'current', [ 'middleware' => 'auth' ] ] );
	} );

    //  $r->group( 'oikos/api', function ( Routes $r ) {
    //      $r->get( '/hello', [ HelloController::class, 'show' ] );
    //      $r->get( '/{path:.*}', fn( Request $request, Response $response ) => $response->setStatusCode( 404 ) );
    //  } );
} );

$r->middleware( 'magic:oikos/app', function ( Routes $r ) {
	$r->group( 'oikos/app/{key}', function ( Routes $r ) {
		$r->get( '', [ AppController::class, 'index' ] );
		//$r->get( '/subpage', [ SubpageController::class, 'show' ] );
	} );
} );



$r->condition( 'backend', function ( Routes $r ) {
	$r->middleware( 'can:manage_dt', function ( Routes $r ) {
		$r->group( 'wp-admin/admin.php', function ( Routes $r ) {
			$r->get( '?page=dt_oikos', [ GeneralSettingsController::class, 'show' ] );
			$r->get( '?page=dt_oikos&tab=general', [ GeneralSettingsController::class, 'show' ] );

			$r->middleware( 'nonce:dt_admin_form_nonce', function ( Routes $r ) {
				$r->post( '?page=dt_oikos', [ GeneralSettingsController::class, 'update' ] );
				$r->post( '?page=dt_oikos&tab=general', [ GeneralSettingsController::class, 'update' ] );
			} );
		} );
	} );
} );
