<?php

declare( strict_types = 1 );

require_once __DIR__ . '/../setup.php';

require_once __DIR__ . '/../../../src/WpDebug.php';

use PHPUnit\Framework\TestCase;

// use Wpx\Wpx\v0\WpDebug;

final class WpDebugTest extends TestCase {

	protected function setUp(): void {
	}

	public function test_WpDebug_has_echo_wp_object_cache_stats_html_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpDebug', 'echo_wp_object_cache_stats_html' ) );
	}

	public function test_WpDebug_has_get_wp_object_cache_stats_html_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpDebug', 'get_wp_object_cache_stats_html' ) );
	}

	public function test_WpDebug_has_log_request_info_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpDebug', 'log_request_info' ) );
	}

}
