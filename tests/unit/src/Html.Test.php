<?php

declare( strict_types = 1 );

require_once __DIR__ . '/../setup.php';

require_once __DIR__ . '/../../../src/Html.php';

use PHPUnit\Framework\TestCase;

use Wpx\Wpx\v0\Html;

final class HtmlTest extends TestCase {

	protected function setUp(): void {
	}

	public function test_Html_attrs_with_empty_attrs_arg(): void {
		$attrs = [];

		$actual_html = Html::attrs( $attrs );

		$this->assertTrue( is_string( $actual_html ) );
		$this->assertEquals( '', $actual_html );
	}

	public function test_Html_attrs_with_various_non_empty_attrs_args(): void {
		$attrs = [
			'class' => 'foo',
		];

		$actual_html = Html::attrs( $attrs );

		$this->assertTrue( is_string( $actual_html ) );
		$this->assertEquals( ' class="foo"', $actual_html );
	}

	public function test_Html_attrs_with_boolean_attrs_args(): void {
		$attrs = [
			'checked' => true,
			'required' => true,
		];

		$actual_html = Html::attrs( $attrs );

		$this->assertTrue( is_string( $actual_html ) );
		$this->assertEquals( ' checked required', $actual_html );
	}

	public function test_Html_attrs_with_null_attrs_args(): void {
		$attrs = [
			'checked' => null,
			'class' => 'foo',
			'required' => true,
		];

		$actual_html = Html::attrs( $attrs );

		$this->assertTrue( is_string( $actual_html ) );
		$this->assertEquals( ' class="foo" required', $actual_html );
	}

}
