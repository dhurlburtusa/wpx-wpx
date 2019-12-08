<?php

declare( strict_types = 1 );

require_once __DIR__ . '/../setup.php';

require_once __DIR__ . '/../../../src/Is.php';

use PHPUnit\Framework\TestCase;

use Wpx\Wpx\v0\Is;

final class IsTest extends TestCase {

	protected function setUp(): void {
	}

	public function test_Is_local_when_SERVER_ADDR_is_IPv4_loopback(): void {
		try {
			$_SERVER['SERVER_ADDR'] = '127.0.0.1';
			$this->assertEquals( true, Is::local() );
		}
		finally {
			unset( $_SERVER['SERVER_ADDR'] );
		}
	}

	public function test_Is_local_when_HTTP_HOST_ends_with_dot_local(): void {
		try {
			$_SERVER['HTTP_HOST'] = 'example.local';
			$this->assertEquals( true, Is::local() );
		}
		finally {
			unset( $_SERVER['HTTP_HOST'] );
		}
	}

	public function test_Is_local_when_SERVER_NAME_ends_with_dot_local(): void {
		try {
			$_SERVER['SERVER_NAME'] = 'example.local';
			$this->assertEquals( true, Is::local() );
		}
		finally {
			unset( $_SERVER['SERVER_NAME'] );
		}
	}

	public function test_Is_wp_authentication(): void {
		try {
			// We expect that WordPress has set `pagenow` by the time `wp_authentication` is called.
			$GLOBALS['pagenow'] = 'index.php';
			$this->assertEquals( false, Is::wp_authentication() );
			$GLOBALS['pagenow'] = 'wp-login.php';
			$this->assertEquals( true, Is::wp_authentication() );
		}
		finally {
			unset( $GLOBALS['pagenow'] );
		}
	}

	public function test_Is_wp_autosave(): void {
		$this->assertEquals( false, Is::wp_autosave() );
		define( 'DOING_AUTOSAVE', true );
		$this->assertEquals( true, Is::wp_autosave() );
	}

	public function test_Is_wp_rest(): void {
		$this->assertEquals( false, Is::wp_rest() );
		define( 'REST_REQUEST', true );
		$this->assertEquals( true, Is::wp_rest() );
	}

	public function test_Is_wp_xmlrpc(): void {
		$this->assertEquals( false, Is::wp_xmlrpc() );
		define( 'XMLRPC_REQUEST', true );
		$this->assertEquals( true, Is::wp_xmlrpc() );
	}

}
