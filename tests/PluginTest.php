<?php

namespace Tests;

/**
 * @test
 */
class PluginTest extends TestCase {
	/**
	 * @test
	 */
	public function can_install() {
		activate_plugin( 'dt-oikos/dt-oikos.php' );

		$this->assertContains(
			'dt-oikos/dt-oikos.php',
			get_option( 'active_plugins' )
		);
	}

	/**
	 * @test
	 */
	public function example_http_test() {
		$response = $this->get( 'dt/oikos/api/hello' );

		$this->assertEquals( 200, $response->getStatusCode() );
		$this->assertStringContainsString( 'Hello World!', $response->getContent() );
	}
}
