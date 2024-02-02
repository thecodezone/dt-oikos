<?php

namespace DT\Oikos\Controllers\Admin;

use DT\Oikos\Illuminate\Http\RedirectResponse;
use DT\Oikos\Illuminate\Http\Request;
use DT\Oikos\Illuminate\Http\Response;
use function DT\Oikos\transaction;
use function DT\Oikos\validate;
use function DT\Oikos\view;


class GeneralSettingsController {
	/**
	 * Show the general settings admin tab
	 */
	public function show( Request $request, Response $response ) {
		$tab        = "general";
		$link       = 'admin.php?page=dt_oikos&tab=';
		$page_title = "DT Oikos Map Settings";

		return view( "settings/general", compact( 'tab', 'link', 'page_title' ) );
	}

	/**
	 * Submit the general settings admin tab form
	 */
	public function update( Request $request, Response $response ) {
		$error = false;

		// Add the settings update code here
		$errors = validate( $request->all(), [
			'option1' => 'required',
			'option2' => 'required',
		] );

		if ( count( $errors ) > 0 ) {
			$error = __( 'Please complete the required fields.', 'dt-oikos' );
		}

		if ( ! $error ) {
			//Perform update in a MYSQL transaction
			$result = transaction( function () use ( $request ) {
				set_option( 'option1', $request->post( 'option1' ) );
				set_option( 'option2', $request->post( 'option2' ) );
			} );

			if ( $result !== true ) {
				$error = __( 'The form could not be submitted.', 'dt-oikos' );
			}
		}


		if ( $error ) {
			return new RedirectResponse( 302, admin_url(
					'admin.php?page=dt_oikos&tab=general&' . http_build_query( [
						'error'  => $error,
						'fields' => $errors,
					] )
				)
			);
		}

		return new RedirectResponse( 302, admin_url( 'admin.php?page=dt_oikos&tab=general&updated=true' ) );
	}
}
