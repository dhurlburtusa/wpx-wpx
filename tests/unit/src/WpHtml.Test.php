<?php

declare( strict_types = 1 );

require_once __DIR__ . '/../setup.php';

require_once __DIR__ . '/../../../src/WpHtml.php';

use PHPUnit\Framework\TestCase;

final class WpHtmlTest extends TestCase {

	protected function setUp(): void {
	}

	public function test_has_configure_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpHtml', 'configure' ) );
	}

	public function test_has_dequeue_scripts_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpHtml', 'dequeue_scripts' ) );
	}

	public function test_has_dequeue_styles_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpHtml', 'dequeue_styles' ) );
	}

	public function test_has_enable_text_widget_shortcodes_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpHtml', 'enable_text_widget_shortcodes' ) );
	}

	public function test_has_enqueue_scripts_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpHtml', 'enqueue_scripts' ) );
	}

	public function test_has_enqueue_styles_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpHtml', 'enqueue_styles' ) );
	}

	public function test_has_remove_adjacent_posts_link_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpHtml', 'remove_adjacent_posts_link' ) );
	}

	public function test_has_remove_canonical_link_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpHtml', 'remove_canonical_link' ) );
	}

	public function test_has_remove_generator_meta_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpHtml', 'remove_generator_meta' ) );
	}

	public function test_has_remove_rsd_link_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpHtml', 'remove_rsd_link' ) );
	}

	public function test_has_remove_wlwmanifest_link_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpHtml', 'remove_wlwmanifest_link' ) );
	}

	public function test_has_set_meta_charset_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpHtml', 'set_meta_charset' ) );
	}

	public function test_has_set_meta_viewport_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpHtml', 'set_meta_viewport' ) );
	}

}
