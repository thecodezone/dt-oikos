<?php

namespace DT\Oikos\Controllers;


use Disciple_Tools_Users;
use DT\Oikos\Illuminate\Http\Request;
use DT\Oikos\Illuminate\Http\Response;
use DT_Magic_URL;
use function DT\Oikos\magic_url;
use function DT\Oikos\redirect;

class RedirectController {

	/**
	 * Redirects to the URL for the oikos magic link app. This uses the
	 * auth middleware, so the user will be redirected to
	 * the login page if they are not logged in.
	 *
	 * If the app is not already activated, this method will activate it
	 *
	 * @param Request $request The HTTP request object.
	 * @param Response $response The HTTP response object.
	 */
	public function show( Request $request, Response $response ) {
		global $wpdb;

		$preference_key = 'dt-oikos-app';
		$meta_key       = $wpdb->prefix . DT_Magic_URL::get_public_key_meta_key( 'oikos', 'app' );

		if ( ! $this->is_activated() ) {
			delete_user_meta( get_current_user_id(), $meta_key );
			delete_user_option( get_current_user_id(), $preference_key );

			add_user_meta( get_current_user_id(), $meta_key, DT_Magic_URL::create_unique_key() );
			Disciple_Tools_Users::app_switch( get_current_user_id(), $preference_key );
		}

		return redirect( magic_url() );
	}

	/**
	 * Checks if the oikos magic link app is activated for the current user.
	 * This method determines if the user has a valid public key and secret key
	 * stored in their user meta and user option respectively.
	 *
	 * @return bool Returns true if the app is activated, false otherwise.
	 */
	public function is_activated() {
		global $wpdb;
		$preference_key = 'dt-oikos-app';
		$meta_key       = $wpdb->prefix . DT_Magic_URL::get_public_key_meta_key( 'oikos', 'app' );
		$public         = get_user_meta( get_current_user_id(), $meta_key, true );
		$secret         = get_user_option( $preference_key );

		if ( $public === '' || $public === false || $public === '0' || $secret === '' || $secret === false || $secret === '0' ) {
			return false;
		}

		return true;
	}
}
