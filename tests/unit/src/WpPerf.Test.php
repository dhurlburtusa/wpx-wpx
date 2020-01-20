<?php

declare( strict_types = 1 );

require_once __DIR__ . '/../setup.php';

require_once __DIR__ . '/../../../src/WpPerf.php';

use PHPUnit\Framework\TestCase;

// use Wpx\Wpx\v0\WpPerf;

final class WpPerfTest extends TestCase {

	protected function setUp(): void {
	}

	public function test_WpPerf_has_get_stylesheet_directory_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpPerf', 'get_stylesheet_directory' ) );
	}

	public function test_WpPerf_has_get_stylesheet_directory_uri_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpPerf', 'get_stylesheet_directory_uri' ) );
	}

	public function test_WpPerf_has_get_stylesheet_uri_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpPerf', 'get_stylesheet_uri' ) );
	}

	public function test_WpPerf_has_get_template_directory_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpPerf', 'get_template_directory' ) );
	}

	public function test_WpPerf_has_get_template_directory_uri_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpPerf', 'get_template_directory_uri' ) );
	}

}
