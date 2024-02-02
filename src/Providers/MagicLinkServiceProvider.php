<?php

namespace DT\Oikos\Providers;

use DT\Oikos\MagicLinks\App;
use function DT\Oikos\collect;

class MagicLinkServiceProvider extends ServiceProvider {
	protected $container;

	protected $magic_links = [
		'oikos/app' => App::class,
	];

	/**
	 * Do any setup needed before the theme is ready.
	 * DT is not yet registered.
	 */
	public function register(): void {
		$this->container->bind( 'DT\Oikos\MagicLinks', function () {
			return collect( $this->magic_links );
		} );
	}

	/**
	 * Do any setup after services have been registered and the theme is ready
	 */
	public function boot(): void {
		$this->container->make( 'DT\Oikos\MagicLinks' )
		                ->each( function ( $magic_link ) {
			                $this->container->singleton( $magic_link );
			                $this->container->make( $magic_link );
		                } );
	}
}
