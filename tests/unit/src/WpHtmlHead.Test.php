<?php

declare( strict_types = 1 );

require_once __DIR__ . '/../setup.php';

require_once __DIR__ . '/../../../src/WpHtmlHead.php';

use PHPUnit\Framework\TestCase;

final class WpHtmlHeadTest extends TestCase {

	protected function setUp(): void {
	}

	public function test_WpHtmlHead_has_remove_adjacent_posts_link_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpHtmlHead', 'remove_adjacent_posts_link' ) );
	}

	public function test_WpHtmlHead_has_remove_canonical_link_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpHtmlHead', 'remove_canonical_link' ) );
	}

	public function test_WpHtmlHead_has_remove_generator_meta_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpHtmlHead', 'remove_generator_meta' ) );
	}

	// public function test_WpHtmlHead_has_remove_rsd_link_method(): void {
	// 	$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpHtmlHead', 'remove_rsd_link' ) );
	// }

	public function test_WpHtmlHead_has_remove_shortlink_link_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpHtmlHead', 'remove_shortlink_link' ) );
	}

	public function test_WpHtmlHead_has_remove_wlwmanifest_link_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpHtmlHead', 'remove_wlwmanifest_link' ) );
	}

	public function test_WpHtmlHead_has_set_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpHtmlHead', 'set' ) );
	}

	public function test_WpHtmlHead_has_set_charset_meta_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpHtmlHead', 'set_charset_meta' ) );
	}

	public function test_WpHtmlHead_has_set_generator_meta_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpHtmlHead', 'set_generator_meta' ) );
	}

	public function test_WpHtmlHead_has_set_pingback_link_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpHtmlHead', 'set_pingback_link' ) );
	}

	public function test_WpHtmlHead_has_set_profile_link_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpHtmlHead', 'set_profile_link' ) );
	}

	public function test_WpHtmlHead_has_set_viewport_meta_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpHtmlHead', 'set_viewport_meta' ) );
	}

}
