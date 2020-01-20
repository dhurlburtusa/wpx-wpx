<?php

declare( strict_types = 1 );

require_once __DIR__ . '/../setup.php';

require_once __DIR__ . '/../../../src/WpHtml.php';

use PHPUnit\Framework\TestCase;

use Wpx\Wpx\v0\WpHtml;

final class WpHtmlTest extends TestCase {

	protected function setUp(): void {
	}

	public function test_WpHtml_body_attrs_with_empty_attrs_arg(): void {
		$attrs = [];

		$actual_html = WpHtml::body_attrs( $attrs );

		$this->assertTrue( is_string( $actual_html ) );
		$this->assertEquals( '', $actual_html );
	}

	public function test_WpHtml_body_attrs_with_various_non_empty_attrs_args(): void {
		$attrs = [
			'class' => 'foo',
		];
		$actual_html = WpHtml::body_attrs( $attrs );

		$this->assertTrue( is_string( $actual_html ) );
		$this->assertEquals( ' class="foo"', $actual_html );


		$attrs = [
			'class' => 'foo',
			'lang' => 'de-de',
		];
		$actual_html = WpHtml::body_attrs( $attrs );

		$this->assertTrue( is_string( $actual_html ) );
		$this->assertEquals( ' class="foo" lang="de-de"', $actual_html );


		$attrs = [
			'class' => 'foo',
			'contenteditable' => 'true',
			'lang' => 'de-de',
		];
		$actual_html = WpHtml::body_attrs( $attrs );

		$this->assertTrue( is_string( $actual_html ) );
		$this->assertEquals( ' class="foo" contenteditable="true" lang="de-de"', $actual_html );
	}

	public function test_WpHtml_has_dequeue_scripts_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpHtml', 'dequeue_scripts' ) );
	}

	public function test_WpHtml_has_dequeue_styles_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpHtml', 'dequeue_styles' ) );
	}

	public function test_WpHtml_has_enqueue_scripts_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpHtml', 'enqueue_scripts' ) );
	}

	public function test_WpHtml_has_enqueue_styles_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpHtml', 'enqueue_styles' ) );
	}

	public function test_WpHtml_has_register_script_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpHtml', 'register_script' ) );
	}

	public function test_WpHtml_has_register_style_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpHtml', 'register_style' ) );
	}

	public function test_WpHtml_html_attrs_with_empty_attrs_arg(): void {
		$attrs = [];
		$actual_html = WpHtml::html_attrs( $attrs );

		$this->assertTrue( is_string( $actual_html ) );
		$this->assertEquals( '', $actual_html );
	}

	public function test_WpHtml_html_attrs_with_various_non_empty_attrs_arg(): void {
		$attrs = [
			'class' => 'foo',
		];
		$actual_html = WpHtml::html_attrs( $attrs );

		$this->assertTrue( is_string( $actual_html ) );
		$this->assertEquals( ' class="foo"', $actual_html );


		$attrs = [
			'dir' => 'rtl',
		];
		$actual_html = WpHtml::html_attrs( $attrs );

		$this->assertTrue( is_string( $actual_html ) );
		$this->assertEquals( ' dir="rtl"', $actual_html );


		$attrs = [
			'lang' => 'en-US',
		];

		$actual_html = WpHtml::html_attrs( $attrs );

		$this->assertTrue( is_string( $actual_html ) );
		$this->assertEquals( ' lang="en-US"', $actual_html );
	}

	public function test_WpHtml_the_body_attrs(): void {
		ob_start();

		$attrs = [
			'class' => 'foo',
		];
		WpHtml::the_body_attrs( $attrs );

		$actual_html = ob_get_contents();

		ob_end_clean();

		$this->assertTrue( is_string( $actual_html ) );
		$this->assertEquals( ' class="foo"', $actual_html );
	}

	public function test_WpHtml_the_html_attrs(): void {
		ob_start();

		$attrs = [
			'class' => 'foo',
		];
		WpHtml::the_html_attrs( $attrs );

		$actual_html = ob_get_contents();

		ob_end_clean();

		$this->assertTrue( is_string( $actual_html ) );
		$this->assertEquals( ' class="foo"', $actual_html );
	}

}
